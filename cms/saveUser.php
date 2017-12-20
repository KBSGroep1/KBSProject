<?php
require_once "include/init.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 3) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(!isset($_POST["userID"]) || !is_numeric($_POST["userID"])) {
	http_response_code(400);
	echo "400 Bad Request";
	exit;
}

$submittedUserID = intval($_POST["userID"]);
$submittedUsername = trim($_POST["username"]);
$submittedPassword1 = trim($_POST["password1"]);
$submittedPassword2 = trim($_POST["password2"]);
$submittedRole = intval($_POST["role"]);
$submittedActive = isset($_POST["active"]);

if($submittedPassword1 !== $submittedPassword2) {
	$_SESSION["errorPW"] = "Wachtwoorden komen niet overeen";
	header("Location: users.php?userID=" . $submittedUserID);
	exit;
}

$stmt0 = $dbh->prepare("SELECT userID FROM user WHERE username = :username AND userID <> :userID");
$stmt0->bindParam(":username", $submittedUsername);
$stmt0->bindParam(":userID", $submittedUserID);
$stmt0->execute();

if($stmt0->rowCount() > 0) {
	$_SESSION["errorU"] = "Gebruikersnaam is al in gebruik";
	header("Location: users.php?userID=" . $submittedUserID);
	exit;
}

$stmt1 = $dbh->prepare("
	INSERT INTO user
	(userID, username, role, active)
	VALUES (:userID, :username, :role, :active)
	ON DUPLICATE KEY UPDATE
	username = :username, role = :role, active = :active");
$stmt1->bindParam(":userID", $submittedUserID);
$stmt1->bindParam(":username", $submittedUsername);
$stmt1->bindParam(":role", $submittedRole);
$stmt1->bindParam(":active", $submittedActive);
$stmt1->execute();

if(!empty($submittedPassword1)) {

	$hashedPassword = password_hash($submittedPassword1, PASSWORD_BCRYPT);

	$dbh->query("UPDATE user SET password = '$hashedPassword' WHERE userID = $submittedUserID");
}

$_SESSION["success"] = "Gebruiker opgeslagen";
header("Location: users.php?userID=" . $submittedUserID);
