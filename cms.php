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
                    <a class="navbar-brand" href="#">Website Editor</a>
   				</div>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php
                                $stmt = $dbh->prepare("SELECT websiteID, name FROM website");
                                $stmt->execute();
                                while ($result = $stmt->fetch()) {
                                    print("<li><a href='#''>" . $result["name"] . "</a></li>");
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Ingelogd als: <?php print($_SESSION["username"]) ?></a></li>
                    <li><a href="logout.php">Uitloggen</a></li>
                </ul>
  			</div>
		</nav>
  <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Producten</a></li>        
        <li ><a href="#">Website</a></li>        
        <li ><a href="#">Gebruikers</a></li>
        <li ><a href="#">Berichten</a></li>
      </ul>
    </div>
  </div>
</nav>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;