<?php
require "include/init.php";

// TODO: style

if(!isset($_GET["websiteID"]) || !is_numeric($_GET["websiteID"])) {
	http_response_code(400);
	echo "400 Bad Request";
	exit;
}

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 3) {
	http_response_code(401);
	echo "401 Unauthorized";
	exit;
}

if(isset($_GET["sure"])) {
	// Queries will do because it's been established $_GET["websiteID"] is only an int
	// and the user has permission to delete whatever he wants

	$dbh->query("DELETE FROM website WHERE websiteID = " . $_GET["websiteID"]);
	$dbh->query("DELETE FROM text WHERE websiteID = " . $_GET["websiteID"]);
	$dbh->query("DELETE FROM color WHERE websiteID = " . $_GET["websiteID"]);

	if(isset($_GET["deleteProducts"])) {
		$dbh->query("DELETE FROM product WHERE websiteID = " . $_GET["websiteID"]);
	}

	header("Location: sites.php");
}
else {
	include "include/topBar.php";
?>
Weet u zeker dat u de website met ID <?= $_GET["websiteID"] ?> wil verwijderen?<br />
<a href="deleteWebsite.php?websiteID=<?= $_GET["websiteID"] ?>&sure&deleteProducts" class="btn-primary btn">Ja, verwijder website + producten</a><br />
<a href="deleteWebsite.php?websiteID=<?= $_GET["websiteID"] ?>&sure" class="btn-primary btn">Ja, verwijder website, laat producten bestaan</a><br />
<a href="sites.php?site=<?= $_GET["websiteID"] ?>" class="btn-primary btn">Nee, verwijder niks</a><br />
<?php
}
