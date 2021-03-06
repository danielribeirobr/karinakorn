<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2006 Paul Cooper, Lukas Smith, Lorenzo Alberton   |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB2 is a merge of PEAR DB and Metabases that provides a unified DB  |
// | API as well as database abstraction for PHP applications.            |
// | This LICENSE is in the BSD license style.                            |
// |                                                                      |
// | Redistribution and use in source and binary forms, with or without   |
// | modification, are permitted provided that the following conditions   |
// | are met:                                                             |
// |                                                                      |
// | Redistributions of source code must retain the above copyright       |
// | notice, this list of conditions and the following disclaimer.        |
// |                                                                      |
// | Redistributions in binary form must reproduce the above copyright    |
// | notice, this list of conditions and the following disclaimer in the  |
// | documentation and/or other materials provided with the distribution. |
// |                                                                      |
// | Neither the name of Manuel Lemos, Tomas V.V.Cox, Stig. S. Bakken,    |
// | Lukas Smith nor the names of his contributors may be used to endorse |
// | or promote products derived from this software without specific prior|
// | written permission.                                                  |
// |                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
// | FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE      |
// | REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,          |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
// | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS|
// |  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED  |
// | AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT          |
// | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY|
// | WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE          |
// | POSSIBILITY OF SUCH DAMAGE.                                          |
// +----------------------------------------------------------------------+
// | Authors: Paul Cooper <pgc@ucecom.com>                                |
// |          Lorenzo Alberton <l dot alberton at quipo dot it>           |
// +----------------------------------------------------------------------+
//
// $Id: MDB2_extended_testcase.php,v 1.9 2006/09/18 07:41:35 lsmith Exp $

require_once 'MDB2_testcase.php';

class MDB2_Extended_TestCase extends MDB2_TestCase
{
    /**
     *
     */
    function testAutoExecute()
    {
        $data = $this->getSampleData();
        $select_query = 'SELECT ' . implode(', ', array_keys($this->fields)) . ' FROM users';

        $result = $this->db->loadModule('Extended');
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error loading "Extended" module: '.$result->getMessage());
        }

        $result = $this->db->extended->autoExecute('users', $data, MDB2_AUTOQUERY_INSERT, null, $this->fields);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error auto executing insert: '.$result->getMessage());
        }

        $this->db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        $result =& $this->db->query($select_query, $this->fields);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error selecting from users: '.$result->getMessage());
        } else {
            $this->verifyFetchedValues($result, null, $data);
            $result->free();
        }

        $where = 'user_id = '.$this->db->quote($data['user_id'], 'integer');
        $result = $this->db->extended->autoExecute('users', null, MDB2_AUTOQUERY_SELECT, $where, null, true, $this->fields);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error auto executing select: '.$result->getMessage());
        } else {
            $this->verifyFetchedValues($result, null, $data);
            $result->free();
        }

        $where = 'user_id = '.$this->db->quote($data['user_id'], 'integer');
        $result = $this->db->extended->autoExecute('users', null, MDB2_AUTOQUERY_SELECT, $where, null, true, MDB2_PREPARE_RESULT);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error auto executing select: '.$result->getMessage());
        } else {
            $result->setResultTypes($this->fields);
            $this->verifyFetchedValues($result, null, $data);
            $result->free();
        }

        $update_data = array();
        $data['user_name'] = $update_data['user_name'] = 'foo';

        $where = 'user_id = '.$this->db->quote($data['user_id'], 'integer');
        $result = $this->db->extended->autoExecute('users', $update_data, MDB2_AUTOQUERY_UPDATE, $where, $this->fields);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error auto executing insert: '.$result->getMessage());
        }

        $this->db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        $result =& $this->db->query($select_query, $this->fields);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error selecting from users: '.$result->getMessage());
        } else {
            $this->verifyFetchedValues($result, null, $data);
            $result->free();
        }

        $where = array($where, 'user_name = '.$this->db->quote($data['user_name'], 'text'));
        $result = $this->db->extended->autoExecute('users', null, MDB2_AUTOQUERY_DELETE, $where, null);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error auto executing insert: '.$result->getMessage());
        }

        $this->db->setFetchMode(MDB2_FETCHMODE_ASSOC);
        $result =& $this->db->query($select_query, $this->fields);
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error selecting from users: '.$result->getMessage());
        } else {
            $this->assertEquals(0, $result->numRows(), 'No rows were expected to be returned');
            $result->free();
        }
    }

    /**
     * Test getAssoc()
     *
     * Test fetching two columns from a resultset. Return them as (key,value) pairs.
     */
    function testGetAssoc()
    {
        $result = $this->db->loadModule('Extended');
        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error loading "Extended" module: '.$result->getMessage());
        }

        $data = $this->getSampleData(1234);

        $query = 'INSERT INTO users (' . implode(', ', array_keys($this->fields)) . ') VALUES ('.implode(', ', array_fill(0, count($this->fields), '?')).')';
        $stmt = $this->db->prepare($query, array_values($this->fields), MDB2_PREPARE_MANIP);
        $result = $stmt->execute(array_values($data));
        $stmt->free();

        if (PEAR::isError($result)) {
            $this->assertTrue(false, 'Error executing prepared query'.$result->getMessage());
        }

        //test getAssoc() with query parameters
        $query = 'SELECT user_id, user_name FROM users WHERE user_id=?';
        $result = $this->db->getAssoc($query, array('integer', 'text'), array(1234), array('integer'));
        if (PEAR::isError(