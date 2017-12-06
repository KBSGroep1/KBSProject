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
		<th>Actief</th>
	</thead>
		<?php
		if (isset($_SESSION["site"])) {
			if ($_SESSION["site"] == 0) {
				$stmt = $dbh->prepare("SELECT productID, name, price, description, active FROM product");
			}
			else {
				$stmt = $dbh->prepare("SELECT productID, name, price, description, active FROM product WHERE websiteID = :websiteID");
				$stmt->bindParam(":websiteID", $_SESSION["site"]);
			}
			$stmt->execute();
			while ($result = $stmt->fetch()) {
				print("<tr><td><a href='editProduct.php?product=" . $result["productID"] . "'>" . $result["name"] . "</td><td>" . $result["description"] . "</td><td>&euro;" . number_format($result["price"] / 100, 2,  ',', ' ' ) . "</td><td>");
				if ($result["active"] == 1) {
					print("Ja");
				}
				elseif ($result["active"] == 0) {
					print("Nee");
				}
				print("<td><a class='btn btn-primary' href='delProduct.php?product=" . $result["productID"] . "'>Verwijder</a></td></tr>");
			}
		}
		else {
			print("Selecteer eerst een website");
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