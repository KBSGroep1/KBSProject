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
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/cms.css">	
	</head>
	<body>
		<nav class="navbar navbar-inverse">
  			<div class="container-fluid">
    			<div class="navbar-header">
    		  		<a class="navbar-brand" href="#"><img id="logoWilpe"src="img/cms/wilpeLogo.jpg"></a>
   				</div>
    		  		<p id="username">Ingelogd als: <a href="users.php"><?php print($_SESSION["username"]) ?></a><br>
    		  			<a href="logout.php">Uitloggen</a></p>
  			</div>
		</nav>
  <div id="sidebar">
            <nav id="spy">
                <ul class="sidebar-nav nav">
                    <li class="sidebar-brand">
                    	<select id="websiteSelect">
							<option value="">Selecteer een site</option>
							<?php
								$stmt = $dbh->prepare("SELECT websiteID, name FROM website");
								$stmt->execute();
								while ($result = $stmt->fetch()) {
									print("<option value='" . $result["websiteID"] . "'>" . $result["name"] . "</option>");
								}
							?>
						</select>
                    </li>
                    <li>
                        <a href="producten.php" data-scroll>
                            <span class="fa fa-anchor solo">Producten</span>
                        </a>
                    </li>
                    <li>
                        <a href="website.php" data-scroll>
                            <span class="fa fa-anchor solo">Website</span>
                        </a>
                    </li>
                    <li>
                        <a href="users.php" data-scroll>
                            <span class="fa fa-anchor solo">Gebruikers</span>
                        </a>
                    </li>
                    <li>
                        <a href="messages.php" data-scroll>
                            <span class="fa fa-anchor solo">Berichten</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

		<br>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;