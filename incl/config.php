<?php
	$mysqliConn = mysqli_connect("server.localhost", "username", "password", "datebase");
	$obj_mySqliConn = new mysqli("server.localhost", "username", "password", "datebase");

$basedir = dirname(__FILE__)."/..";

	$BACKGRNDCOLOR="purple";
	$BACKGRNDCOLOR="white";
	$BACKGRNDCOLOR="grey";

// define table names
	$TABUSER="link_sys_users";
	$TABLINK="link_sys";
	$TABACCESS="link_sys_access";
	
	// ------- constants for MySQL-Bind
   // i 	the related variable has type integer
   // d 	the related variable has type double
   // s 	the related variable has type string
   // b 	the related variable is a BLOB and will be send paket-whise 
$globMySQLBindInteger = 'i';
$globMySQLBindDouble  = 'd';
$globMySQLBindString  = 's';
$globMySQLBindBlob    = 'b';

$timeoutminutes = 10 * 60;

?>
