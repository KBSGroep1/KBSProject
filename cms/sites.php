<?php
include "include/init.php";
include "include/topBar.php";

// TODO: check role

$websiteID = -1;
$viewingSingleWebsite = false;
$existingWebsite = false;

if(isset($_GET["site"]) && is_numeric($_GET["site"])) {
	$websiteID = $_GET["site"];

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
			<li><a href="products.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Producten</a></li>
			<li class="active"><a href="sites.php">Websites</a></li>
			<li><a href="users.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Gebruikers</a></li>
			<li><a href="messages.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Berichten</a></li>
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
	<a href="sites.php?site=<?php echo $query->rowCount() + 1; ?>">Nieuwe website</a>
	<table class="table">
		<tr>
			<th>Naam</th>
			<th></th>
		</tr>
<?php
	while($row = $query->fetch()) {
		echo "<tr>";
		echo "<td><a href=\"sites.php?site=" . $row["websiteID"] . "\">" . $row["name"] . "</a></td>";
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