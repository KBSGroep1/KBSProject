<?php
require_once "include/init.php";
include "include/topBar.php"; 
include "include/sideBar.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 2) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(!isset($_GET["message"]) || !is_numeric($_GET["message"])) {
	http_response_code(400);
	echo "400 Bad Request";
	exit;
}

echo "<div class=\"message\">";

$stmt = $dbh->prepare("SELECT customerName, timestamp, email, C.websiteID, name, text FROM contact C JOIN website W on W.websiteID = C.websiteID WHERE C.contactID = :id ");
$stmt->bindParam(":id", $_GET["message"]);
$stmt->execute();

if($stmt->rowCount() === 0) {
	http_response_code(404);
	echo "Bericht met ID " . $_GET["message"] . " bestaat niet";
}

while($result = $stmt->fetch()) {
	echo "<h3>" . $result["customerName"] . "\n" . $result["timestamp"] . "</h3><p><a href='mailto:" . $result['email'] . "?Subject=". $result['name'] ."'>". $result["email"] . "</a><br>" . $result["text"] . "\n" .  "</p>";
}

echo "</div></body></html>";

$dbh = null;
$stmt = null;
