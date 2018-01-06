<?php
require_once "include/init.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 2) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(!isset($_POST["websiteID"]) || !is_numeric($_POST["websiteID"])
|| !isset($_POST["websiteName"]) || empty($_POST["websiteName"])) {
	http_response_code(400);
	echo "400 Bad Request";
	exit;
}

$websiteID = intval($_POST["websiteID"]);
$submittedName = trim($_POST["websiteName"]);
$submittedActive = isset($_POST["websiteActive"]);

// 1. Update generic website data

$statement = $dbh->prepare("INSERT INTO website
	(websiteID, name, active)
	VALUES (:websiteID, :name, :active)
	ON DUPLICATE KEY UPDATE name = :name, active = :active");
$statement->bindParam(":websiteID", $websiteID);
$statement->bindParam(":name", $submittedName);
$statement->bindParam(":active", $submittedActive);
$statement->execute();

// 2. Upload images

// We don't need a lot of checks on $_FILES, because it is provided by an admin, and because images
// are stored with predetermined filenames

function try_to_upload_img($file, $type, $path) {
	if($file["type"] !== $type) return false;
	if($file["size"] <= 0) return false;
	if($file["error"] > UPLOAD_ERR_OK) return false;
	if(!is_uploaded_file($file["tmp_name"])) return false;

	return move_uploaded_file($file["tmp_name"], $path);
}

try_to_upload_img($_FILES["bg1"], "image/jpeg", "../img/bg/$websiteID-bg1.jpg");
try_to_upload_img($_FILES["bg2"], "image/jpeg", "../img/bg/$websiteID-bg2.jpg");
try_to_upload_img($_FILES["bg3"], "image/jpeg", "../img/bg/$websiteID-bg3.jpg");
try_to_upload_img($_FILES["smallLogo"], "image/svg+xml", "../img/logo/$websiteID-smallLogo.svg");
try_to_upload_img($_FILES["largeLogo"], "image/svg+xml", "../img/logo/$websiteID-largeLogo.svg");
try_to_upload_img($_FILES["favicon"], "image/x-icon", "../img/logo/$websiteID-favicon.ico");

// 3. Update colors

// We load a list of accepted color fields from the database, then insert/update those provided in $_POST
$query3 = $dbh->query("SELECT colorName FROM colorDescription");

$colors = [];
while($field = $query3->fetch()) {
	if(isset($_POST[$field["colorName"]]) && !empty($_POST[$field["colorName"]])) {
		$submittedColor = trim($_POST[$field["colorName"]]);

		$s = $dbh->prepare("INSERT INTO color (colorName, websiteID, hex) VALUES (:colorName, :websiteID, :hex) ON DUPLICATE KEY UPDATE hex = :hex");
		$s->bindParam(":colorName", $field["colorName"]);
		$s->bindParam(":websiteID", $websiteID);
		$s->bindParam(":hex", $submittedColor);
		$s->execute();
	}
}

// 4. Update texts

// Texts work the same as colors, see step 3
$query = $dbh->query("SELECT textName FROM textDescription");

$texts = [];
while($field = $query->fetch()) {
	if(isset($_POST[$field["textName"]]) && !empty($_POST[$field["textName"]])) {
		$submittedText = trim($_POST[$field["textName"]]);

		$s = $dbh->prepare("INSERT INTO text (textName, websiteID, text) VALUES (:textName, :websiteID, :text) ON DUPLICATE KEY UPDATE text = :text");
		$s->bindParam(":textName", $field["textName"]);
		$s->bindParam(":websiteID", $websiteID);
		$s->bindParam(":text", $submittedText);
		$s->execute();
	}
}

$query = null;
$statement = null;
$stmt = null;
$dbh = null;

header("Location: sites.php?websiteID=$websiteID");
