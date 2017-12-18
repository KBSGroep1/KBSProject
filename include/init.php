<?php
error_reporting(E_ALL);

session_start();

if(isset($_SERVER["HTTP_HOST"]))
	$requestedDomain = $_SERVER["HTTP_HOST"];
if(isset($_SESSION["domain"]))
	$requestedDomain = $_SESSION["domain"];
if(!isset($requestedDomain)) {
	http_response_code(404);
	echo "404 Page Not Found";
	
	// TODO: remove
	echo "<br />Waarschijnlijk staat de HTTP_HOST niet goed, dat kan je oplossen op /changeDomain.php";
	exit;
}

if(!isset($_SESSION["loggedIn"])) $_SESSION["loggedIn"] = false;
if(!isset($_SESSION["userID"]))   $_SESSION["userID"] = -1;
if(!isset($_SESSION["userName"])) $_SESSION["userName"] = null;
if(!isset($_SESSION["userRole"])) $_SESSION["userRole"] = 0;
if(!isset($_SESSION["role"]))     $_SESSION["role"] = 0; // TODO: use userRole everywhere

$config = parse_ini_file("config/config.ini");

try {
	$dbh = new PDO("mysql:"
		. "host=" . $config["host"]
		. ";port=" . $config["port"]
		. ";dbname=" . $config["db"],
	$config["username"], $config["password"]);

	// TODO: remove
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo "Failed to connect to database";
	exit;
}

$stmt = $dbh->prepare("SELECT * FROM website WHERE name = :name AND active");
$stmt->bindParam(":name", $requestedDomain);
$stmt->execute();

if($stmt->rowCount() !== 1) {
	http_response_code(404);
	echo "404 Page not found";

	// TODO: remove
	echo "<br />Waarschijnlijk staat de HTTP_HOST niet goed, dat kan je oplossen op /changeDomain.php";
	exit;
}

$result = $stmt->fetch();

$websiteID = intval($result["websiteID"]);
$websiteDomain = $result["name"];
