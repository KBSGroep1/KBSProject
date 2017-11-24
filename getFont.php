<?php
if(!isset($_GET["name"]) || empty($_GET["name"])) {
	// 400 Bad Request
	http_response_code(400);
	echo "<h1>400 Bad request</h1>";
	exit;
}

$fontName = implode(" ", explode("%20", $_GET["name"]));

$config = parse_ini_file("config/config.ini");

try {
	$dbh = new PDO("mysql:"
		. "host=" . $config["host"]
		. ";port=" . $config["port"]
		. ";dbname=" . $config["db"],
		$config["username"], $config["password"]);
}
catch(PDOException $e) {
	// 503 Service Unavailable
	http_response_code(503);
	echo "<h1>503 Service Unajkl;vailable</h1>";
	exit;
}

$stmt = $dbh->prepare("SELECT blobRegular FROM font WHERE fontName = :name");
$stmt->bindParam(":name", $fontName);
$stmt->execute();

$result = $stmt->fetch();

header("Content-Type: application/x-font-ttf");
echo $result["blobRegular"];
