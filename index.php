<?php
// TODO: use colors from database

require_once "include/init.php";

$texts = [];
$query1 = $dbh->query("SELECT * FROM text WHERE websiteID = $websiteID");
while($text = $query1->fetch()) {
	$texts[$text["textName"]] = $text["text"];
}

$products = [];
$query2 = $dbh->query("SELECT * FROM product WHERE websiteID = $websiteID AND active");
while($product = $query2->fetch(PDO::FETCH_ASSOC)) {
	array_push($products, $product);
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
		<!-- <script src="js/smoothscroll.js"></script> -->

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

<?php
foreach($products as $product) {
?>
			$('#hoverProduct<?= $product["productID"] ?>, #product<?= $product["productID"] ?>').hover(function() {
				$('#product<?= $product["productID"] ?>').toggle();
			});
<?php
}
?>
			</script>
	</body>
</html>
