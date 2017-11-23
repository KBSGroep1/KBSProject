<?php
session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	echo "fuck u";
	exit;
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

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Wilpe CMS</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/cms.css">
	</head>
	<body>
		<div id="topBar">
			<img src="img/cms/wilpeLogo.jpg">
			<p id="username">Ingelogd als: <a href="users.php"><?php print($_SESSION["username"]) ?></a></p>
		</div>
		<br>
		<div id="sideBar">
			<select>
				<option value="">Selecteer een site</option>
				<?php
					$stmt = $dbh->prepare("SELECT websiteID, name FROM website");
					$stmt->execute();
					while ($result = $stmt->fetch()) {
						print("<option value='" . $result["websiteID"] . "'>" . $result["name"] . "</option>");
					}
				?>
			</select><br>
			<a href="producten.php">Producten</a><br>
			<a href="thema.php">Thema aanpassen</a><br>
			<a href="users.php">Gebruikers</a><br>
			<a href="websites.php">Websites</a><br>
		</div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;