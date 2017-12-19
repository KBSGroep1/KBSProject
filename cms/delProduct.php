<?php
require "include/init.php";
require "include/topBar.php";
require "include/sideBar.php";

if(isset($_GET["confirm"]) && isset($_GET["productID"]) && is_numeric($_GET["productID"])){
	$stmt = $dbh->prepare("DELETE FROM product WHERE productID = :productID");
	$stmt->bindParam(":productID", $_GET["productID"]);
	$stmt->execute();
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
	print("Weet u zeker dat u <i>" . $result["name"] . "</i> wilt verwijderen<br>");
	print("<a class='btn btn-primary' href=delProduct.php?productID=" . $_GET["productID"] . "&confirm=1>Ja</a>");
	print("<a class='btn btn-primary' href=products.php>Nee</a>");

	// TODO: delete images
}
else {
	echo "Wat doe jij nou";
}

$dbh = null;
$stmt = null;
