<?php
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	$_SESSION["loggedIn"] = false;
	$_SESSION["userID"] = -1;
	$_SESSION["username"] = null;
	$_SESSION["role"] = 0; // todo: fix this accross all php scripts
	$_SESSION["userRole"] = 0;
}

$config = parse_ini_file("config/config.ini");

try {
	$dbh = new PDO("mysql:"
		. "host=" . $config["host"]
		. ";port=" . $config["port"]
		. ";dbname=" . $config["db"],
		$config["username"], $config["password"]);
}
catch(PDOException $e) {
	echo "Failed to connect to database";
	exit;
}

if(isset($_SERVER["HTTP_HOST"]))
	$requestedDomain = $_SERVER["HTTP_HOST"];
if(isset($_SESSION["domain"]))
	$requestedDomain = $_SESSION["domain"];
if(!isset($requestedDomain)) {
	http_response_code(400);
	echo "400 Bad Request";
	
	// TODO: remove
	echo "<br />Waarschijnlijk staat de HTTP_HOST niet goed, dat kan je oplossen op /changeDomain.php";
	exit;
}

$stmt = $dbh->prepare("SELECT * FROM website WHERE name = :name AND active");
$stmt->bindParam(":name", $requestedDomain);
$stmt->execute();

if($stmt->rowCount() !== 1) {
	http_response_code(404);
	echo "Page not found";

	// TODO: remove
	echo "<br />Waarschijnlijk staat de HTTP_HOST niet goed, dat kan je oplossen op /changeDomain.php";
	exit;
}

$result = $stmt->fetch();

$websiteID = $result["websiteID"];

$stmt2 = $dbh->prepare("SELECT * FROM text WHERE websiteID = :id");
$stmt2->bindParam(":id", $result["websiteID"]);
$stmt2->execute();

$texts = [];

while($t = $stmt2->fetch()) {
	$texts[$t["textName"]] = $t["text"];
}

$stmt3 = $dbh->prepare("SELECT * FROM product WHERE websiteID = :id AND active = 1");
$stmt3->bindParam(":id", $result["websiteID"]);
$stmt3->execute();

while($p = $stmt3->fetch()) {
	$productName[$p["productID"]] = $p["name"];
	$productDesc[$p["productID"]] = $p["description"];
	$productPrice[$p["productID"]] = $p["price"] / 100;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Toolwelle</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/font-awesome.min.css" rel="stylesheet" />

		<style media="screen">

			.contactIcon i, .contact h3:after{
				background-color: #e95b12;
			}

			.productName{
				border-bottom: 2px solid #e95b12;
			}

			.buttonColor{
				background-color: #e95b12;
			}

			.bodyText{
				color: #fff;
			}
			.titleAbout {
				color: #e95b12;
			}


		</style>
	</head>
	<body>
		<?php include 'include/menu.php'; ?>
		<?php include 'include/home.php'; ?>
		<?php include 'include/about.php'; ?>
		<?php include 'include/products.php'; ?>
		<?php include 'include/footer.php'; ?>

		<!-- Libraries -->
		<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
		<script src="js/jquery.visible.min.js" type="text/javascript"></script>
		<script src="js/modernizr.js" type="text/javascript"></script>
		<script src="js/parallax.min.js" type="text/javascript"></script>
		<script src="js/scroll_anchor.js" type="text/javascript"></script>
		<script src="js/smoothscroll.js" type="text/javascript"></script>

		<!-- Own scripts-->
		<script src="js/scripts.js" type="text/javascript"></script>
	    <script type="text/javascript">

			$('#homeContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg1.jpg'
			});

			$('#aboutContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg2.jpg'
			});

			$('#productsContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg3.jpg'
			});

			<?php
			foreach ($productName as $id => $value) {
				print("$('#hoverProduct" . $id . ", #product" . $id . "').hover(function() {
			  			$('#product" . $id . "').toggle();
					});");
			}
			?>
			</script>
	</body>
</html>
