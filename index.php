<?php
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	$_SESSION["loggedIn"] = false;
	$_SESSION["userID"] = -1;
	$_SESSION["username"] = null;
	$_SESSION["role"] = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Toolwelle</title>
		<meta charset="utf-8" />
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/font-awesome.min.css" rel="stylesheet" />

		<style media="screen">

			.contactIcon i, .contact h3:after{
				background-color: #e95b12;
			}

			.sendButton{
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
        imageSrc: 'img/bg/729674.jpg'
      });

      $('#homeContainer').parallax({
        imageSrc: 'img/bg/tools.jpg'
      });

      $('#productsContainer').parallax({
        imageSrc: 'img/bg/default.jpg'
      });

    </script>
	</body>
</html>
