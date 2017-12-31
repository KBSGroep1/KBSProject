<?php
// TODO: use colors from database
session_start();
error_reporting(E_ALL);

if(isset($_GET["websiteID"]) && is_numeric($_GET["websiteID"])
&& isset($_GET["existingWebsite"]) && is_numeric($_GET["existingWebsite"])) {
	$websiteID = intval($_GET["websiteID"]);
	$existingWebsite = intval($_GET["existingWebsite"]) === 1;
}

if(!$_SESSION["loggedIn"] || $_SESSION["userRole"] < 3) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

try {
	$config = parse_ini_file("config/config.ini");

	$dbh = new PDO("mysql:"
		. "host=" . $config["host"]
		. ";port=" . $config["port"]
		. ";dbname=" . $config["db"],
	$config["username"], $config["password"]);

	// TODO: change so that it hides all errors
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	http_response_code(500);
	echo "500 Internal Server Error";
	exit;
}

$texts = [];
if($existingWebsite) {
	$query = $dbh->query("SELECT textName, text FROM text WHERE websiteID = $websiteID");
	while($text = $query->fetch()) {
		$texts[$text["textName"]] = $text["text"];
	}
}
else {
	$query = $dbh->query("SELECT textName FROM textDescription");
	while($text = $query->fetch()) {
		$texts[$text["textName"]] = $text["textName"];
	}
}

$editing = true;

/* This function eturns a bit of HTML along the likes of
   contenteditable data-textname="$name" data-disabledlink="$disabledlink"
   Basically just a shorthand so we don't pollute the HTML */
function cEditable($name, $disabledLink = false) {
	return "contenteditable data-textname=\"$name\"" . ($disabledLink ? "data-disabledlink=\"true\" " : "");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?= $texts["pageTitle"] ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/font-awesome.min.css" rel="stylesheet" />
		<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css'>
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
		<?php include "include/menu.php"; ?>
		<?php include "include/home.php"; ?>
		<?php include "include/about.php"; ?>
		<?php include "include/products.php"; ?>
		<?php include "include/footer.php"; ?>

		<!-- Libraries -->
		<script src="js/jquery-1.11.3.min.js"></script>
		<script src="js/jquery.visible.min.js"></script>
		<script src="js/modernizr.js"></script>
		<script src="js/parallax.min.js"></script>
		<script src="js/scroll_anchor.js"></script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js'></script>

		<!-- Own scripts-->
		<script src="js/scripts.js"></script>
		<script>

			$('#homeContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg1.jpg'
			});

			$('#aboutContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg2.jpg'
			});

			$('#productsContainer').parallax({
				imageSrc: 'img/bg/<?php echo $websiteID; ?>-bg3.jpg'
			});
 
			$("*[data-disabledlink]").removeAttr("href");

		</script>
	</body>
</html>
