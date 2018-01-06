<?php
require_once "include/init.php";
include "include/topBar.php";
include "include/sideBar.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 2) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

echo "<div class=\"messageHome\">";

if(empty($_SESSION["site"]) || !is_numeric($_SESSION["site"])) {
	$stmt = $dbh->prepare("SELECT contactID, customerName, text, timestamp, C.websiteID FROM contact C ORDER BY timestamp DESC");
}
else {
	$stmt = $dbh->prepare("SELECT contactID, customerName, text, timestamp, C.websiteID FROM contact C WHERE C.websiteID = :id ORDER BY timestamp DESC");
	$stmt->bindParam(":id", $_SESSION["site"]);
}

$stmt->execute();

if($stmt->rowCount() === 0) {
	echo "<br />Deze mailbox is leeg";
}
else {
	echo "<table class='table table-hover'><thead><tr><th>Naam</th><th>Bericht</th><th>Datum</th><th>Verwijderen</th></tr></thead>";

	while($result = $stmt->fetch()) {
		echo "<tr><td>" . substr($result['customerName'],0,20) . "</td>\n<td><a href='viewMessage.php?&message=" . $result['contactID'] . "'>" . substr($result["text"],0,50);
		if(strlen($result["text"]) >= 50) 
			echo "...";
		echo "</a></td>\n<td>" . $result["timestamp"] . "</td><td><a class='btn-primary btn' data-contactID='".$result['contactID']."' >Verwijderen</a></td></tr>";
	}
	echo "</table>";
	echo "<a class=\"btn-primary btn\" href=\"/cms/delMessage.php\">Verwijder alles</a>";
}
?>
</div>
<script>

	$("a[data-contactID]").on("click", function() {
		var xhttp = new XMLHttpRequest();
		xhttp.open("GET", "/cms/delMessage.php?contactID=" + this.dataset.contactid, true);
		xhttp.send();
		var x = this.parentNode.parentNode;
		x.parentNode.removeChild(x);
	});

</script>
</body>
</html>
<?php
$dbh = null;
$stmt = null;
