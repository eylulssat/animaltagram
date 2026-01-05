<?php
ob_start(); 
session_start();
// error_reporting(0);

date_default_timezone_set('Europe/Istanbul');

define("PATH", $_SERVER['DOCUMENT_ROOT'] . "/internet teknolojileri");
define("URL", "http://localhost/internet teknolojileri/");

require_once(PATH . "/classes/allclass.php");

$db = new Hayvanlar\Database();
?>