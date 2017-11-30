<?php
// TODO: use correct websiteID

session_start();

if(!isset($_POST["fullname"]) || !isset($_POST["message"])) {
	header("Location: /#pageContact");
	$_SESSION["contactError"] = "Name and message are required fields";
	exit;
}

$submittedName = trim($_POST["fullname"]);
$submittedEmail = trim($_POST["email"]);
$submittedMessage = trim($_POST["message"]);

if(strlen($submittedName) < 1
|| strlen($submittedMessage) < 1
|| (strlen($submittedEmail) > 0 && !filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)))
{
	header("Location: /#pageContact");
	$_SESSION["contactError"] = "Invalid data entered";
	exit;
}

$config = parse_ini_file("config/config.ini");
$dbh = new PDO("mysql:"
	. "host=" . $config["host"]
	. ";port=" . $config["port"]
	. ";dbname=" . $config["db"],
	$config["username"], $config["password"]);

$statement = $dbh->prepare("INSERT INTO contact (customerName, email, text, websiteID) VALUES (:name, :email, :text, 1)");
$statement->bindParam("name", $submittedName);
$statement->bindParam("email", $submittedEmail);
$statement->bindParam("text", $submittedMessage);
// $statement->bindParam("websiteID", );
$statement->execute();

header("Location: thankyou.php");
