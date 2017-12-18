<?php
// TODO: use colors from database

require_once "include/init.php";

$texts = [];
$query = $dbh->query("SELECT * FROM text WHERE websiteID = $websiteID");
while($text = $query->fetch()) {
	$texts[$text["textName"]] = $text["text"];
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

		<style media="screen">

			*, *:before, *:after {
				box-sizing: border-box;
				padding: 0;
				margin: 0;
			}

			body {
				background: url(img/bg/<?= $websiteID ?>-bg1.jpg) no-repeat center center fixed;
				background-size: cover;
			}

			#thankyou {
				margin: auto;
				margin-top: 260px;
				width: 100vw;
				max-width: 600px;
				color: white;
				padding: 64px;
				background-color: rgba(56, 56, 56, .95) /* todo: get from DB */;
			}

			#thankyou h1 {
				color: white;
			}

			#thankyou a {
				color: white;
				text-decoration: underline;
				font-weight: bold;
			}

		</style>
	</head>
	<body>
		<div id="thankyou">
			<h1><?php echo $texts["contactThankyouTitle"]; ?></h1>
			<p><?php echo $texts["contactThankyouText"]; ?></p>
			<a href="/"><?php echo $texts["contactThankyouLink"]; ?></a>
		</div>
	</body>
</html>
