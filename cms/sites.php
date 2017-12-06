<?php
include "include/init.php";
include "include/topBar.php";

// TODO: check role

$websiteID = -1;
$viewingSingleWebsite = false;
$existingWebsite = false;

if(isset($_GET["websiteID"]) && is_numeric($_GET["websiteID"])) {
	$websiteID = $_GET["websiteID"];

	$statement = $dbh->prepare("SELECT * FROM website WHERE websiteID = :id");
	$statement->bindParam(":id", $websiteID);
	$statement->execute();

	if($statement->rowCount() === 1) {
		$existingWebsite = true;
	}

	$result = $statement->fetch();

	$viewingSingleWebsite = true;
}
?>
<nav class="navbar navbar-default sidebar" role="navigation">
	<div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li><a href="products.php<?php if (isset($_GET["websiteID"])) { print("?site=" . $_GET["websiteID"]); } ?>">Producten</a></li>
			<li class="active"><a href="sites.php">Websites</a></li>
			<li><a href="users.php<?php if (isset($_GET["websiteID"])) { print("?site=" . $_GET["websiteID"]); } ?>">Gebruikers</a></li>
			<li><a href="messages.php<?php if (isset($_GET["websiteID"])) { print("?site=" . $_GET["websiteID"]); } ?>">Berichten</a></li>
		</ul>
	</div>
</nav>
<div>
<?php
if($viewingSingleWebsite) {
	include "include/websiteForm.php";
}
else {
	$query = $dbh->query("SELECT * FROM website");
?>
	<a href="sites.php?websiteID=<?php echo $query->rowCount() + 1; ?>">Nieuwe website</a>
	<table class="table">
		<tr>
			<th>Naam</th>
			<th></th>
		</tr>
<?php
	while($row = $query->fetch()) {
		echo "<tr>";
		echo "<td><a href=\"sites.php?websiteID=" . $row["websiteID"] . "\">" . $row["name"] . "</a></td>";
		echo "<td><a href=\"deleteWebsite.php?websiteID=" . $row["websiteID"] . "\">Delete</a></td>";
		echo "</tr>";
	}
?>
	</table>
<?php
}
?>
</div>
	</body>
</html>
<?php
$query = null;
$statement = null;
$dbh = null;