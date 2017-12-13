<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Wilpe CMS</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/cms.css">
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
							<?php
							if(isset($_SESSION["site"])) {
								if($_SESSION["site"] == 0) {
									echo "Alle websites";
								}
								else {
									$stmt = $dbh->prepare("SELECT websiteID, name FROM website");
									$stmt->execute();
									while ($result = $stmt->fetch()) {
										if($result["websiteID"] === $_SESSION["site"]) {
											echo $result["name"];
										}
									}
								}
							}
							else {
								echo "Selecteer website";
							}
							?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="?site=0">Alle websites</a></li>
							<?php
							$stmt = $dbh->prepare("SELECT websiteID, name FROM website");
							$stmt->execute();
							while($result = $stmt->fetch()) {
								echo "<li><a href=\"?site=" . $result["websiteID"] . "\">" . $result["name"] . "</a></li>";
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