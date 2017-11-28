<?php
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	$_SESSION["loggedIn"] = false;
	$_SESSION["userID"] = -1;
	$_SESSION["username"] = null;
	$_SESSION["role"] = 0;
}

$config = parse_ini_file("config/config.ini");

$requestedWebsite = "debananenwinkel.nl";

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

$stmt = $dbh->prepare("SELECT * FROM website WHERE name = :name");
$stmt->bindParam(":name", $requestedWebsite);
$stmt->execute();
$result = $stmt->fetch();
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
				imageSrc: 'img/<?php echo $result["bg1Path"]; ?>'
			});

			$('#homeContainer').parallax({
				imageSrc: 'img/<?php echo $result["bg2Path"]; ?>'
			});

			$('#productsContainer').parallax({
				imageSrc: 'img/<?php echo $result["bg3Path"]; ?>'
			});

	    </script>
	</body>
</html>
