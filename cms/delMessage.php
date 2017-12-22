<?php 
require_once "include/init.php";
$stmt = $dbh->prepare("DELETE FROM contact WHERE contactID = :contactID");
$stmt->bindParam(":contactID", $_GET["contactID"]);
$stmt->execute();
?>