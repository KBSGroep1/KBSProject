<?php
if(!isset($_SESSION["site"]) || !is_numeric($_SESSION["site"])) {
	$_SESSION["site"] = 0;
}

$sites = [];
$q = $dbh->query("SELECT websiteID, name FROM website");
while($row = $q->fetch()) {
	$sites[intval($row["websiteID"])] = $row["name"];
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Wilpe CMS</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/cms.css" />
		<link href="../css/font-awesome.min.css" rel="stylesheet" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<script src="../js/jquery-1.11.3.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="cms.php"><img id="logoWilpe" src="../img/logo/wilpeLogo.png" alt="Wilpe" /></a>
					<a class="navbar-brand" href="cms.php">Website Editor</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<?= $_SESSION["site"] > 0 ? $sites[$_SESSION["site"]] : "Alle websites" ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="?site=0">Alle websites</a></li>
<?php
foreach($sites as $index => $site) {
	echo "<li><a href=\"?site=" . $index . "\">" . $site . "</a></li>";
}
?>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Ingelogd als: <?php echo $_SESSION["username"]; ?></a></li>
					<li><a href="logout.php">Uitloggen</a></li>
				</ul>
			</div>
		</nav>
