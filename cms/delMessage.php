<?php 
require_once "include/init.php";
if (isset($_GET["contactID"])) {
$stmt = $dbh->prepare("DELETE FROM contact WHERE contactID = :contactID");
$stmt->bindParam(":contactID", $_GET["contactID"]);
$stmt->execute();
}else{
	include 'include/topBar.php'; 
	include 'include/sideBar.php';
	if (isset($_GET["delAll"])&&($_GET["delAll"] == "ja")) {
		print ('Alle berichten zijn verwijderd');
		$stmt = $dbh->prepare("DELETE FROM contact WHERE contactID = contactID");
		$stmt->execute();
	}else{
	print("Weet u zeker dat u alle berichten wil verwijderen?");
?>
<br>
<a class='btn-primary btn' href="/cms/delMessage.php?delAll=ja">Verwijder alles</a>
<a class='btn-primary btn' href="/cms/messages.php">Nee, ga terug</a>
<?php
}}
?>