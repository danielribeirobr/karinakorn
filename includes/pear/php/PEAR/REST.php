<?php
/**
 * PEAR_REST
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   pear
 * @package    PEAR
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: REST.php,v 1.21 2006/03/27 04:33:11 cellog Exp $
 * @link       http://pear.php.net/package/PEAR
 * @since      File available since Release 1.4.0a1
 */

/**
 * For downloading xml files
 */
require_once 'PEAR.php';
require_once 'PEAR/XMLParser.php';

/**
 * Intelligently retrieve data, following hyperlinks if necessary, and re-directing
 * as well
 * @category   pear
 * @package    PEAR
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.5.0
 * @link       http://pear.php.net/package/PEAR
 * @since      Class available since Release 1.4.0a1
 */
class PEAR_REST
{
    var $config;
    var $_options;
    function PEAR_REST(&$config, $options = array())
    {
        $this->config = &$config;
        $this->_options = $options;
    }

    /**
     * Retrieve REST data, but always retrieve the local cache if it is available.
     *
     * This is useful for elements that should never change, such as information on a particular
     * release
     * @param string full URL to this resource
     * @param array|false contents of the accept-encoding header
     * @param boolean     if true, xml will be returned as a string, otherwise, xml will be
     *                    parsed using PEAR_XMLParser
     * @return string|array
     */
    function retrieveCacheFirst($url, $accept = false, $forcestring = false)
    {
        $cachefile = $this->config->get('cache_dir') . DIRECTORY_SEPARATOR .
            md5($url) . 'rest.cachefile';
        if (file_exists($cachefile)) {
            return unserialize(implode('', file($cachefile)));
        }
        return $this->retrieveData($url, $accept, $forcestring);
    }

    /**
     * Retrieve a remote REST resource
     * @param string full URL to this resource
     * @param array|false contents of the accept-encoding header
     * @param boolean     if true, xml will be returned as a string, otherwise, xml will be
     *                    parsed using PEAR_XMLParser
     * @return string|array
     */
    function retrieveData($url, $accept = false, $forcestring = false)
    {
        $cacheId = $this->getCacheId($url);
        if ($ret = $this->useLocalCache($url, $cacheId)) {
            return $ret;
        }
        if (!isset($this->_options['offline'])) {
            $trieddownload = true;
            $file = $this->downloadHttp($url, $cacheId ? $cacheId['lastChange'] : false, $accept);
        } else {
            $trieddownload = false;
            $file = false;
        }
        if (PEAR::isError($file)) {
            if ($file->getCode() == -9276) {
                $trieddownload = false;
                $file = false; // use local copy if available on socket connect error
            } else {
                return $file;
            }
        }
        if (!$file) {
            $ret = $this->getCache($url);
            if (!PEAR::isError($ret) && $trieddownload) {
                // reset the age of the cache if the server says it was unmodified
                $this->saveCache($url, $ret, null, true, $cacheId);
            }
            return $ret;
        }
        if (is_array($file)) {
            $headers = $file[2];
            $lastmodified = $file[1];
            $content = $file[0];
        } else {
            $content = $file;
            $lastmodified = false;
            $headers = array();
        }
        if ($forcestring) {
            $this->saveCache($url, $content, $lastmodified, false, $cacheId);
            return $content;
        }
        if (isset($headers['content-type'])) {
            switch ($headers['content-type']) {
                case 'text/xml' :
                case 'application/xml' :
                    $parser = new PEAR_XMLParser;
                    PEAR::pushErrorHandling(PEAR_ERROR_RETURN);
                    $err = $parser->parse($content);
                    PEAR::popErrorHandling();
                    if (PEAR::isError($err)) {
                        return PEAR::raiseError('Invalid xml downloaded from "' . $url . '": ' .
                            $err->getMessage());
                    }
                    $content = $parser->getData();
                case 'text/html' :
                default :
                    // use it as a string
            }
        } else {
            // assume XML
            $parser = new PEAR_XMLParser;
            $parser->parse($content);
            $content = $parser->getData();
        }
        $this->saveCache($url, $content, $lastmodified, false, $cacheId);
        return $content;
    }

    function useLocalCache($url, $cacheid = null)
    {
        if ($cacheid === null) {
            $cacheidfile = $this->config->get('cache_dir') . DIRECTORY_SEPARATOR .
                md5($url) . 'rest.cacheid';
            if (file_exists($cacheidfile)) {
                $cacheid = unserialize(implode('', file($cacheidfile)));
            } else {
                return false;
            }
        }
        $cachettl = $this->config->get('cache_ttl');
        // If cache is newer than $cachettl seconds, we use the cache!
        if (time() - $cacheid['age'] < $cachettl) {
            return $this->getCache($url);
        }
        return false;
    }

    function getCacheId($url)
    {
        $cacheidfile = $this->config->get('cache_dir') . DIRECTORY_SEPARATOR .
            md5($url) . 'rest.cacheid';
        if (file_exists($cacheidfile)) {
            $ret = unserialize(implode('', file($cacheidfile)));
            return $ret;
        } else {
            return false;
        }
    }

    function getCache($url)
    {
        $cachefile = $this->config->get('cache_dir') . DIRECTORY_SEPARATOR .
            md5($url) . 'rest.cachefile';
        if (file_exists($cachefile)) {
            return unserialize(implode('', file($cachefile)));
        } else {
            return PEAR::raiseError('No cached content available for "' . $url . '"');
        }
    }

    /**
     * @param string full URL to REST resource
     * @param string original contents of the REST resource
     * @param array  HTTP Last-Modified and ETag headers
     * @param bool   if true, then the cache id file should be regenerated to
     *               trigger a new time-to-live value
     */
    function saveCache($url, $contents, $lastmodified, $nochange = false, $cacheid = null)
    {
        $cacheidfile = $this->config->get('cache_dir') . DIRECTORY_SEPARATOR .
            md5($url) . 'rest.cacheid';
        $cachefile = $this->config->get('cache_dir') . DIRECTORY_SEPARATOR .
            md5($url) . 'rest.cachefile';
        if ($cacheid === null && $nochange) {
            $cacheid = unserialize(implode('', file($cacheidfile)));
        }

        $fp = @fopen($cacheidfile, 'wb');
        if (!$fp) {
            $cache_dir = $this->config->get('cache_dir');
            if (!is_dir($cache_dir)) {
                System::mkdir(array('-p', $cache_dir));
                $fp = @fopen($cacheidfile, 'wb');
                if (!$fp) {
                    return false;
                }
            } else {
                return false;
            }
        }

        if ($nochange) {
            fwrite($fp, serialize(array(
                'age'        => time(),
      