<?php
	include 'include/init.php';
	include 'include/topBar.php';
	include 'include/sideBar.php';

	$success = false;

	if (isset($_POST['submit'])) {
		$stmt = $dbh->prepare("UPDATE product SET name = :name, description = :description, price = :price * 100 WHERE productID = :productID");
		$stmt->bindParam(":productID", $_GET["product"]);
		$stmt->bindParam(":name", $_POST["name"]);
		$stmt->bindParam(":description", $_POST["description"]);
		$stmt->bindParam(":price", $_POST["price"]);
		$stmt->execute();
		$success = true;
	}

	$stmt = $dbh->prepare("SELECT productID, name, price, description FROM product where productID = :productID");
	$stmt->bindParam(":productID", $_GET["product"]);
	$stmt->execute();
	$result = $stmt->fetch();
?>
<form action="" method="POST">
	<div class="form-group">
		<label for="name">Productnaam</label>
		<input type="text" name="name" id="name" class="form-control" value="<?php print($result['name']); ?>">
	</div>
	<div class="form-group">
		<label for="description">Beschrijving</label>
		<textarea name="description" id="description" class="form-control"><?php print($result['description']); ?></textarea>
	</div>
	<div class="form-group">
		<label for="price">Prijs</label>
		<input type="number" name="price" id="price" class="form-control" value="<?php print($result['price'] / 100); ?>">
	</div>
	<input type="submit" name="submit" class="btn btn-default" value="Opslaan">
</form>
<?php
	if ($success) {
		print("Opgeslagen");
	}
?>
</body>
</html>
<?php
	$dbh = null;
	$stmt = null;