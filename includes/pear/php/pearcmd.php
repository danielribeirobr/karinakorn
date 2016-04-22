<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Stig Bakken <ssb@php.net>                                   |
// |          Tomas V.V.Cox <cox@idecnet.com>                             |
// |                                                                      |
// +----------------------------------------------------------------------+
//
// $Id: pearcmd.php,v 1.37 2007/01/08 05:14:01 cellog Exp $

ob_end_clean();
if (!defined('PEAR_RUNTYPE')) {
    // this is defined in peclcmd.php as 'pecl'
    define('PEAR_RUNTYPE', 'pear');
}
define('PEAR_IGNORE_BACKTRACE', 1);
/**
 * @nodep Gtk
 */
if ('/home/daniel_com/pear/php' != '@'.'include_path'.'@') {
    ini_set('include_path', '/home/daniel_com/pear/php');
    $raw = false;
} else {
    // this is a raw, uninstalled pear, either a cvs checkout, or php distro
    $raw = true;
}
@ini_set('allow_url_fopen', true);
if (!ini_get('safe_mode')) {
    @set_time_limit(0);
}
ob_implicit_flush(true);
@ini_set('track_errors', true);
@ini_set('html_errors', false);
@ini_set('magic_quotes_runtime', false);
$_PEAR_PHPDIR = '#$%^&*';
set_error_handler('error_handler');

$pear_package_version = "1.5.0";

require_once 'PEAR.php';
require_once 'PEAR/Frontend.php';
require_once 'PEAR/Config.php';
require_once 'PEAR/Command.php';
require_once 'Console/Getopt.php';


PEAR_Command::setFrontendType('CLI');
$all_commands = PEAR_Command::getCommands();

// remove this next part when we stop supporting that crap-ass PHP 4.2
if (!isset($_SERVER['argv']) && !isset($argv) && !isset($HTTP_SERVER_VARS['argv'])) {
    echo 'ERROR: either use the CLI php executable, or set register_argc_argv=On in php.ini';
    exit(1);
}
$argv = Console_Getopt::readPHPArgv();
// fix CGI sapi oddity - the -- in pear.bat/pear is not removed
if (php_sapi_name() != 'cli' && isset($argv[1]) && $argv[1] == '--') {
    unset($argv[1]);
    $argv = array_values($argv);
}
$progname = PEAR_RUNTYPE;
if (in_array('getopt2', get_class_methods('Console_Getopt'))) {
    array_shift($argv);
    $options = Console_Getopt::getopt2($argv, "c:C:d:D:Gh?sSqu:vV");
} else {
    $options = Console_Getopt::getopt($argv, "c:C:d:D:Gh?sSqu:vV");
}
if (PEAR::isError($options)) {
    usage($options);
}

$opts = $options[0];

$fetype = 'CLI';
if ($progname == 'gpear' || $progname == 'pear-gtk') {
    $fetype = 'Gtk';
} else {
    foreach ($opts as $opt) {
        if ($opt[0] == 'G') {
            $fetype = 'Gtk';
        }
    }
}
//Check if Gtk and PHP >= 5.1.0
if ($fetype == 'Gtk' && version_compare(phpversion(), '5.1.0', '>=')) {
    $fetype = 'Gtk2';
}

$pear_user_config = '';
$pear_system_config = '';
$store_user_config = false;
$store_system_config = false;
$verbose = 1;

foreach ($opts as $opt) {
    switch ($opt[0]) {
        case 'c':
            $pear_user_config = $opt[1];
            break;
        case 'C':
            $pear_system_config = $opt[1];
            break;
    }
}

PEAR_Command::setFrontendType($fetype);
$ui = &PEAR_Command::getFrontendObject();
$config = &PEAR_Config::singleton($pear_user_config, $pear_system_config);

if (PEAR::isError($config)) {
    $_file = '';
    if ($pear_user_config !== false) {
       $_file .= $pear_user_config;
    }
    if ($pear_system_config !== false) {
       $_file .= '/' . $pear_system_config;
    }
    if ($_file == '/') {
        $_file = 'The default config file';
    }
    $config->getMessage();
    $ui->outputData("ERROR: $_file is not a valid config file or is corrupted.");
    // We stop, we have no idea where we are :)
    exit(1);    
}

// this is used in the error handler to retrieve a relative path
$_PEAR_PHPDIR = $config->get('php_dir');
$ui->setConfig($config);
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, array($ui, "displayFatalError"));
if (ini_get('safe_mode')) {
    $ui->outputData('WARNING: running in safe mode requires that all files created ' .
        'be the same uid as the current script.  PHP reports this script is uid: ' .
        @getmyuid() . ', and current user is: ' . @get_current_user());
}

$verbose = $config->get("verbose");
$cmdopts = array();

if ($raw) {
    if (!$config->isDefinedLayer('user') && !$config->isDefinedLayer('system')) {
        $found = false;
        foreach ($opts as $opt) {
            if ($opt[0] == 'd' || $opt[0] == 'D') {
                $found = true; // the user knows what they are doing, and are setting config values
            }
        }
        if (!$found) {
            // no prior runs, try to install PEAR
            if (strpos(dirname(__FILE__), 'scripts')) {
                $packagexml = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'package2.xml';
                $pearbase = dirname(dirname(__FILE__));
            } else {
                $packagexml = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'package2.xml';
                $pearbase = dirname(__FILE__);
            }
            if (file_exists($packagexml)) {
                $options[1] = array(
                    'install',
                    $packagexml
                );
                $config->set('php_dir', $pearbase . DIRECTORY_SEPARATOR . 'php');
                $config->set('data_dir', $pearbase . DIRECTORY_SEPARATOR . 'data');
                $config->set('doc_dir', $pearbase . DIRECTORY_SEPARATOR . 'docs');
                $config->set('test_dir', $pearbase . DIRECTORY_SEPARATOR . 'tests');
                $config->set('ext_dir', $pearbase . DIRECTORY_SEPARATOR . 'extensions');
                $config->set('bin_dir', $pearbase);
                $config->mergeConfigFile($pearbase . 'pear.ini', false);
                $config->store();
                $config->set('auto_discover', 1);
            }
        }
    }
}
foreach ($opts as $opt) {
    $param = !empty($opt[1]) ? $opt[1] : true;
    switch ($opt[0]) {
        case 'd':
            if ($param === true) {
                die('Invalid usage of "-d" option, expected -d config_value=value, ' .
                    'received "-d"' . "\n");
            }
            $possible = explode('=', $param);
            if (count($possible) != 2) {
                die('Invalid usage of "-d" option, expected -d config_value=value, received "' .
                    $param . '"' . "\n");
            }
            list($key, $value) = explode('=', $param);
            $config->set($key, $value, 'user');
            break;
        case 'D':
            if ($param === true) {
                die('Invalid usage of "-d" option, expected -d config_value=value, ' .
                    'received "-d"' . "\n");
            }
            $possible = explode('=', $param);
            if (count($possible) != 2) {
                die('Invalid usage of "-d" option, expected -d config_value=value, received "' .
                    $param . '"' . "\n");
            }
            list($key, $value) = explode('=', $param);
            $config->set($key, $value, 'system');
            break;
        case 's':
            $store_user_config = true;
            break;
        case 'S':
         