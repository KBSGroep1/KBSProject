<?php
require_once "include/init.php";
include "include/topBar.php"; 
include "include/sideBar.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 3) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(isset($_GET["userID"]) && is_numeric($_GET["userID"])) {
	$userID = intval($_GET["userID"]);

	$query = $dbh->query("SELECT * FROM user WHERE userID = $userID");
	$user = $query->fetch(PDO::FETCH_ASSOC);

	include "include/userForm.php";
}
else {
	$users = [];
	$query = $dbh->query("SELECT userID, username, role, active FROM user");
	while($user = $query->fetch(PDO::FETCH_ASSOC)) {
		array_push($users, $user);
	}

	include "include/userList.php";
}

echo "</body></html>";
