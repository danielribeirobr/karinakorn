<?php

/**
 * Configuration file
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 */

// General configuration
$appConfig['app_name'] = 'Karina Korn';
$appConfig['app_email'] = 'danielribeiro2001@gmail.com';

// Path configuration (in most of the cases the system get this values alone)
$appConfig['url'] = 'http://' . $_SERVER['SERVER_NAME']  . dirname($_SERVER['SCRIPT_NAME']) . '/';
$appConfig['base'] = dirname(__FILE__) . '/';
$appConfig['error_log'] = $appConfig['base'] . 'logs/error.log';
$appConfig['template_dir'] = $appConfig['base'] . 'templates/';
$appConfig['db_imagens'] = 'db_imagens/';
$appConfig['db_banners'] = 'db_banners/';
$appConfig['db_arquivos'] = $appConfig['base'] . 'db_arquivos/';

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Include path
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $appConfig['base'] . 'includes/');

// Include the PEAR path directory
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . $appConfig['base'] . 'includes/pear/php/');

// Database configuration
$appConfig['dsn'] = array(
	'phptype'  => 'mysql',
	'username' => 'xxxxx',
	'password' => 'xxxxx',
	'hostspec' => 'xxxxx',
	'database' => 'karinakorn'
);
