<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';

if (isset($_GET['confirm'])){
	$stmt = $dbh->prepare("DELETE FROM product WHERE productID=:productID");
	$stmt->bindParam(":productID", $_GET["product"]);
	$stmt->execute();
	print("Product is verwijderd");
}
else {
	$stmt = $dbh->prepare("SELECT name FROM product WHERE productID=:productID");
	$stmt->bindParam(":productID", $_GET["product"]);
	$stmt->execute();
	$result = $stmt->fetch();
	print("Weet u zeker dat u " . $result["name"] . " wilt verwijderen<br>");
	print("<a class='btn btn-primary' href=delProduct.php?product=" . $_GET["product"] . "&confirm=1>Ja</a>");
	print("<a class='btn btn-primary' href=products.php>Nee</a>");
}
?>
</body>
</html>
<?php
	$dbh = null;
	$stmt = null;