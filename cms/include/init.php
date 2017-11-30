<?php
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	echo "fuck u";
	exit;
}

$config = parse_ini_file("../config/config.ini");

try {
	$dbh = new PDO("mysql:"
		. "host=" . $config["host"]
		. ";port=" . $config["port"]
		. ";dbname=" . $config["db"],
	$config["username"], $config["password"]);
}
catch(PDOException $e) {
	echo "Failed to connect to database";
	exit;
}
?>