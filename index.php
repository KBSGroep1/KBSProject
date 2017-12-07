<?php
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	$_SESSION["loggedIn"] = false;
	$_SESSION["userID"] = -1;
	$_SESSION["username"] = null;
	$_SESSION["role"] = 0;
}

$config = parse_ini_file("config/config.ini");

$requestedWebsite = "toolwelle.com";
$websiteID = 1;

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

$stmt = $dbh->prepare("SELECT * FROM website WHERE name = :name AND active");
$stmt->bindParam(":name", $requestedWebsite);
$stmt->execute();

if($stmt->rowCount() !== 1) {
	http_response_code(404);
	echo "Page not found";
	exit;
}

$result = $stmt->fetch();

$stmt2 = $dbh->prepare("SELECT * FROM text WHERE websiteID = :id");
$stmt2->bindParam(":id", $result["websiteID"]);
$stmt2->execute();

$texts = [];

while($t = $stmt2->fetch()) {
	$texts[$t["textName"]] = $t["text"];
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

			$('#aboutContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg1.jpg'
			});

			$('#homeContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg2.jpg'
			});

			$('#productsContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg3.jpg'
			});

			$('#hoverProduct1, #product1').hover(function() {
			  $('#product1').toggle();
			});
			$('#hoverProduct2, #product2').hover(function() {
				$('#product2').toggle();
			});
			$('#hoverProduct3, #product3').hover(function() {
				$('#product3').toggle();
			});
			$('#hoverProduct4, #product4').hover(function() {
				$('#product4').toggle();
			});
			$('#hoverProduct5, #product5').hover(function() {
				$('#product5').toggle();
			});
			$('#hoverProduct6, #product6').hover(function() {
				$('#product6').toggle();
			});
			</script>
	</body>
</html>
