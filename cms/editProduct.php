<?php
require_once "include/init.php";
include "include/topBar.php";
include "include/sideBar.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 1) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(!isset($_SESSION["site"]) || !is_numeric($_SESSION["site"])) {
	// TODO: is this enough?
	header("Location: products.php");
	exit;
}

function try_to_upload_img($file, $type, $path) {
	if($file["type"] !== $type) return false;
	if($file["size"] <= 0) return false;
	if($file["error"] > UPLOAD_ERR_OK) return false;
	if(!is_uploaded_file($file["tmp_name"])) return false;

	return move_uploaded_file($file["tmp_name"], $path);
}

// Get product ID
if(isset($_GET["productID"]) && is_numeric($_GET["productID"])) {
	$productID = $_GET["productID"];
}
else {
	$q = $dbh->query("SELECT MAX(productID) + 1 AS productID FROM product");
	$qResult = $q->fetch();
	$productID = $qResult["productID"];
}

$saved = false;

// This form handles itself, and this part handles the form
if(isset($_POST["submit"])) {
	if(isset($_FILES["imageSmall"]))
		try_to_upload_img($_FILES["imageSmall"], "image/jpeg", "../img/products/$productID-small.jpg");

	if(isset($_FILES["imageLarge"]))
		try_to_upload_img($_FILES["imageLarge"], "image/jpeg", "../img/products/$productID-large.jpg");

	$submittedName = trim($_POST["name"]);
	$submittedDescription = trim($_POST["description"]);
	$submittedSub = trim($_POST["subInfo"]);
	$submittedPrice = floatval($_POST["price"]) * 100;
	$submittedActive = $_POST["active"] === "1" ? true : false;

	$stmt = $dbh->prepare("
		INSERT INTO product (productID, name, description, subInfo, price, active, websiteID)
		VALUES (:productID, :name, :description, :subInfo, :price, :active, :websiteID)
		ON DUPLICATE KEY UPDATE name = :name, description = :description, subInfo = :subInfo, price = :price, active = :active ");
	$stmt->bindParam(":productID", $productID);
	$stmt->bindParam(":name", $submittedName);
	$stmt->bindParam(":subInfo", $submittedSub);
	$stmt->bindParam(":description", $submittedDescription);
	$stmt->bindParam(":price", $submittedPrice);
	$stmt->bindParam(":active", $submittedActive);
	$stmt->bindParam(":websiteID", $_SESSION["site"]);
	$stmt->execute();
	$stmt = null;

	$saved = true;
}

// The form is displayed no matter if the form has been handled
$stmt = $dbh->prepare("SELECT productID, name, price, description, subInfo, active FROM product where productID = :productID");
$stmt->bindParam(":productID", $productID);
$stmt->execute();
$result = $stmt->fetch();
?>
<div class="topTextView">
<?php
if($saved)
	echo "<div class=\"alert alert-success\" role=\"alert\">Product opgeslagen</div>";
?>
<form method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label for="name">Productnaam</label>
		<input type="text" name="name" id="name" class="form-control" required value="<?php echo $result["name"]; ?>">
	</div>
	<div class="form-group">
		<label for="description">Beschrijving</label>
		<textarea name="description" id="description" required class="form-control"><?php echo $result["description"]; ?></textarea>
	</div>
	<div class="form-group">
		<label for="price">Editie, kleur etc.</label>
		<input type="text" name="subInfo" id="subInfo" required class="form-control" value="<?php echo $result["subInfo"]; ?>">
	</div>
	<div class="form-group">
		<label for="price">Prijs (€)</label>
		<input type="number" name="price" id="price" required class="form-control" step="0.01" value="<?php echo $result["price"] / 100; ?>">
	</div>
	<div class="form-group">
		<label for="price">Kleine productafbeelding</label><br />
		<img height="100" class="imgPreview" src="../img/products/<?php echo $productID; ?>-small.jpg" alt="" /><br />
		<input type="file" name="imageSmall" id="imageSmall"  class="form-control-file imgUpload">
	</div>
	<div class="form-group"><br />
		<label for="imageLarge">Grote productafbeelding</label><br />
		<img height="100" class="imgPreview" src="../img/products/<?php echo $productID; ?>-large.jpg" alt="" /><br />
		<input type="file" name="imageLarge" id="imageLarge" class="form-control-file imgUpload">
	</div>
	<div class="radio">
		<label><input type="radio" name="active" value="1" <?php if($result["active"] == "1") echo "checked"; ?>>Actief</label>
	</div>
	<div class="radio">
		<label><input type="radio" name="active" value="0" <?php if($result["active"] != "1") echo "checked"; ?>>Niet actief</label>
	</div>
	<input type="submit" name="submit" class="btn btn-default" value="Opslaan">
</form>
</div>
<script>
$("input[type=file].imgUpload").on("change", function(e) {
	if(this.files[0].type !== "image/jpeg") {
		alert("Je kan alleen .jpg uploaden");
		e.preventDefault();
		return false;
	}

	// Image preview
	var reader = new FileReader();
	var elem = this;
	reader.addEventListener("load", function(e) {
		elem.previousSibling.previousSibling.previousSibling.setAttribute("src", e.target.result);
	});
	reader.readAsDataURL(this.files[0]);
});
</script>
</body>
</html>
<?php
$dbh = null;
$stmt = null;
