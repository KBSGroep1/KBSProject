<?php
	include 'include/init.php';
	include 'include/topBar.php';
	include 'include/sideBar.php';

	$success = false;

	if (isset($_POST['submit']) && isset($_GET['product'])) {
		$stmt = $dbh->prepare("UPDATE product SET name = :name, description = :description, price = :price * 100 WHERE productID = :productID");
		$stmt->bindParam(":productID", $_GET["product"]);
		$stmt->bindParam(":name", $_POST["name"]);
		$stmt->bindParam(":description", $_POST["description"]);
		$stmt->bindParam(":price", $_POST["price"]);
		$stmt->execute();
		if (is_uploaded_file($_FILES['imageSmall']['tmp_name'])) {
			$extension = pathinfo(basename($_FILES["imageSmall"]["name"]),PATHINFO_EXTENSION);
			move_uploaded_file($_FILES["imageSmall"]["tmp_name"], "../img/products/" . $_GET["product"] . "small." . $extension);
		}
		if (is_uploaded_file($_FILES['imageBig']['tmp_name'])) {
			$extension = pathinfo(basename($_FILES["imageBig"]["name"]),PATHINFO_EXTENSION);
			move_uploaded_file($_FILES["imageBig"]["tmp_name"], "../img/products/" . $_GET["product"] . "big." . $extension);
		}
		$success = true;
	}
	elseif (isset($_POST['submit'])) {
		$stmt = $dbh->prepare("INSERT INTO product (name, description, price, websiteID) VALUES (:name, :description, :price * 100, :websiteID); SELECT productID FROM product WHERE name = :name, description = :description, price = :price, websiteID = :websiteID");
		$stmt->bindParam(":name", $_POST["name"]);
		$stmt->bindParam(":description", $_POST["description"]);
		$stmt->bindParam(":price", $_POST["price"]);
		$stmt->bindParam(":websiteID", $_SESSION["site"]);
		$stmt->execute();
		$productID = $dbh->lastInsertId();
		if (is_uploaded_file($_FILES['imageSmall']['tmp_name'])) {
			$extension = pathinfo(basename($_FILES["imageSmall"]["name"]),PATHINFO_EXTENSION);
			move_uploaded_file($_FILES["imageSmall"]["tmp_name"], "../img/products/" . $productID . "small." . $extension);
		}
		if (is_uploaded_file($_FILES['imageBig']['tmp_name'])) {
			$extension = pathinfo(basename($_FILES["imageBig"]["name"]),PATHINFO_EXTENSION);
			move_uploaded_file($_FILES["imageBig"]["tmp_name"], "../img/products/" . $productID . "big." . $extension);
		}
		$success = true;
	}

	

	$stmt = $dbh->prepare("SELECT productID, name, price, description FROM product where productID = :productID");
	$stmt->bindParam(":productID", $_GET["product"]);
	$stmt->execute();
	$result = $stmt->fetch();
?>
<form action="" method="POST" enctype="multipart/form-data">
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
		<input type="number" name="price" id="price" class="form-control" step="0.01" value="<?php print($result['price'] / 100); ?>">
	</div>
	<div class="form-group">
		<label for="price">Kleine product afbeelding</label>
		<input type="file" name="imageSmall" id="imageSmall" class="form-control-file">
	</div>
	<div class="form-group">
		<label for="imageBig">Grote product afbeelding</label>
		<input type="file" name="imageBig" id="imageBig" class="form-control-file">
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