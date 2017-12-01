<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';

if (isset($_SESSION['site'])) {
?>
<table class="table table-hover">
	<thead>
		<th>Product</th>
		<th>Beschrijving</th>
		<th>Prijs</th>
	</thead>
		<?php
		$stmt = $dbh->prepare("SELECT productID, name, price, description FROM product WHERE websiteID = :websiteID");
		$stmt->bindParam(":websiteID", $_SESSION["site"]);
		$stmt->execute();
		while ($result = $stmt->fetch()) {
				print("<tr><td><a href='editProduct.php?product=" . $result["productID"] . "'>" . $result["name"] . "</td><td>" . $result["description"] . "</td><td>&euro;" . $result["price"] / 100 . "</td></tr>");
		}
		?>
</table>
<a href="editProduct.php" class="btn btn-primary">Product toevoegen</a>
</body>
</html>
<?php
}
	$dbh = null;
	$stmt = null;