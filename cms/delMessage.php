<?php 
require_once "include/init.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 2) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(isset($_GET["contactID"])) {
	$stmt = $dbh->prepare("DELETE FROM contact WHERE contactID = :contactID");
	$stmt->bindParam(":contactID", $_GET["contactID"]);
	$stmt->execute();
}
else {
	include "include/topBar.php"; 
	include "include/sideBar.php";
	if(isset($_GET["delAll"]) && ($_GET["delAll"] == "ja")) {
		echo "Alle berichten zijn verwijderd";
		$stmt = $dbh->prepare("DELETE FROM contact");
		$stmt->execute();
	}
	else {
?>
Weet u zeker dat u alle berichten van <i>alle sites</i> wil verwijderen?
<br>
<a class="btn-primary btn" href="/cms/delMessage.php?delAll=ja">Verwijder alles</a>
<a class="btn-primary btn" href="/cms/messages.php">Nee, ga terug</a>
<?php
	}
}
