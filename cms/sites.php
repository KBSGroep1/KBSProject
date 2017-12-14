<?php
include "include/init.php";
include "include/topBar.php";
include 'include/sideBar.php';

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 2) {
	http_send_status(401);
	echo "401 Unauthorized";
	exit;
}

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
print("<div>");
if($viewingSingleWebsite) {
	include "include/websiteForm.php";
}
else {
	$query = $dbh->query("SELECT * FROM website");
?>
	<table class="table">
		<thead>
			<tr>
				<th>Naam</th>
				<th>Actief</th>
				<th>Verwijderen</th>
			</tr>
		</thead>
<?php
	while($row = $query->fetch()) {
		echo "<tr>";
		echo "<td><a href=\"sites.php?websiteID=" . $row["websiteID"] . "\">" . $row["name"] . "</a></td>";
		echo "<td>" . ($row["active"] ? "ja" : "nee") . "</td>";
		echo "<td><a href=\"deleteWebsite.php?websiteID=" . $row["websiteID"] . "\" class=\"btn-primary btn\">Delete</a></td>";
		echo "</tr>";
	}
?>
	</table>
	<a href="sites.php?websiteID=<?php echo $query->rowCount() + 1; ?>" class="btn-primary btn">Nieuwe website</a>
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