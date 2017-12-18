<?php
// TODO: different colors and fonts for each website

session_start();

if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
	$_SESSION["loggedIn"] = false;
	$_SESSION["userID"] = -1;
	$_SESSION["username"] = null;
	$_SESSION["role"] = 0;
}

$config = parse_ini_file("config/config.ini");

if(isset($_SERVER["HTTP_HOST"]))
	$requestedWebsite = $_SERVER["HTTP_HOST"];
if(isset($_SESSION["domain"]))
	$requestedWebsite = $_SESSION["domain"];
else{
$requestedWebsite = 'sb1.ictm1l.nl';
}

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

			*, *:before, *:after {
				box-sizing: border-box;
				padding: 0;
				margin: 0;
			}

			body {
				background: url(img/<?php echo $result["bg1Path"]; ?>) no-repeat center center fixed;
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
