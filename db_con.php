<?php
	$host = 'localhost';
	$user = 'root';
	$password = 'root';
	$dbName = 'sf_studios';

	$db = new mysqli($host, $user, $password, $dbName);

	if ($db->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
	} $db->set_charset('utf8'); 
?>