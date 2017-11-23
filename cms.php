<?php
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	echo "fuck u";
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Wilpe CMS</title>
		<meta charset="UTF-8" />
	</head>
	<body>
		boo dit is de front page van het cms
	</body>
</html>
