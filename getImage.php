<?php
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"])) {
	// 400 Bad Request
	http_response_code(400);
	echo "<h1>400 Bad request</h1>";
	exit;
}

$imageID = $_GET["id"];

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
	echo "<h1>503 Service Unavailable</h1>";
	exit;
}

$stmt = $dbh->prepare("SELECT imageBlob FROM image WHERE imageID = :id");
$stmt->bindParam(":id", $imageID);
$stmt->execute();

$result = $stmt->fetch();

header("Content-Type: image/jpeg");
echo $result["imageBlob"];
