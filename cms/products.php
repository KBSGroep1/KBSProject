<?php
require_once "include/init.php";
include "include/topBar.php";
include "include/sideBar.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 1) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(!isset($_SESSION["site"])) {
	echo "<h1>Producten</h1>";
	echo "Selecteer een website hierboven.";
	echo "</body></html>";

	$dbh = null;
	$stmt = null;

	exit;
}

if($_SESSION["site"] === 0 || !is_numeric($_SESSION["site"])) {
	$stmt = $dbh->prepare("SELECT productID, name, price, description, subInfo, active FROM product");
}
else {
	$stmt = $dbh->prepare("SELECT productID, name, price, description, subInfo, active FROM product WHERE websiteID = :websiteID");
	$stmt->bindParam(":websiteID", $_SESSION["site"]);
}

$stmt->execute();

if($stmt->rowCount() === 0) {
	echo "<br />Er staan nog geen producten in de database.<br /><br />";
}
else {
?>
<table class="table table-hover">
	<thead>
		<th>Product</th>
		<th>Beschrijving</th>
		<th>Prijs</th>
		<th>Actief</th>
		<th>Verwijderen</th>
	</thead>
<?php
	while($result = $stmt->fetch()) {
		echo "<tr><td><a href='editProduct.php?productID=" . $result["productID"] . "'>" . $result["name"] . "</td><td>" . $result["description"] . "</td><td>&euro;" . number_format($result["price"] / 100, 2,  ',', ' ' ) . "</td><td>";
		echo $result["active"] == 1 ? "Ja" : "Nee";
		echo "<td><a class='btn btn-primary' href='delProduct.php?productID=" . $result["productID"] . "'>Verwijder</a></td></tr>";
	}
	echo "</table>";
}

if($_SESSION["site"] > 0) {
	echo "<a href=\"editProduct.php\" class=\"btn btn-primary\">Product toevoegen</a>";
}
else {
	echo "Om nieuwe producten toe te voegen moet u eerst een website selecteren in de zwarte balk bovenaan.";
}
?>
</body>
</html>
