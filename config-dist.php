<?php
$DEBUG = true;
if ($DEBUG) {
    ini_set('log_errors', 1);
    ini_set('display_errors', 1);
}

$CFG = new stdClass();
$CFG->dbuser = 'username';
$CFG->dbpassword = 'password';
$CFG->dbhost = '127.0.0.1';
$CFG->dbname = 'dap407';

$CFG->dirroot = __DIR__;
$page = str_replace('DAP406/', '', $_SERVER['SCRIPT_NAME']);
$CFG->www = 'http://localhost/DAP406';
require_once($CFG->dirroot . '/inc/incs.php');
