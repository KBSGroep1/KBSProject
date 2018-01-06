<?php
require_once "include/init.php";
include "include/topBar.php";
include "include/sideBar.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 1) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(isset($_GET["confirm"]) && isset($_GET["productID"]) && is_numeric($_GET["productID"])){
	$stmt = $dbh->prepare("DELETE FROM product WHERE productID = :productID");
	$stmt->bindParam(":productID", $_GET["productID"]);
	$stmt->execute();

	// This is safe because is_numeric() returned true
	unlink("../img/products/" . $_GET["productID"] . "-large.jpg");
	unlink("../img/products/" . $_GET["productID"] . "-small.jpg");

	echo "Product is verwijderd";
}
else if(isset($_GET["productID"]) && is_numeric($_GET["productID"])) {
	$stmt = $dbh->prepare("SELECT name FROM product WHERE productID = :productID");
	$stmt->bindParam(":productID", $_GET["productID"]);
	$stmt->execute();

	if($stmt->rowCount() !== 1) {
		http_response_code(400);
		echo "400 Bad Request";
		exit;
	}

	$result = $stmt->fetch();
	echo "Weet u zeker dat u <i>" . $result["name"] . "</i> wilt verwijderen<br>";
	echo "<a class='btn btn-primary' href=delProduct.php?productID=" . $_GET["productID"] . "&confirm=1>Ja</a>";
	echo "<a class='btn btn-primary' href=products.php>Nee</a>";
}
else {
	echo "Wat doe jij nou";
}

$dbh = null;
$stmt = null;
