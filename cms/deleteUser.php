<?php
require_once "include/init.php";

if(!isset($_SESSION["userRole"]) || $_SESSION["userRole"] < 3) {
	http_response_code(403);
	echo "403 Forbidden";
	exit;
}

if(!isset($_GET["userID"]) || !is_numeric($_GET["userID"])) {
	http_response_code(400);
	echo "400 Bad Request";
	exit;
}

$userID = intval($_GET["userID"]);

if(isset($_GET["sure"])) {
	$stmt = $dbh->prepare("DELETE FROM user WHERE userID = :userID");
	$stmt->bindParam(":userID", $userID);
	$stmt->execute();

	header("Location: users.php");
}

include "include/topBar.php"; 
include "include/sideBar.php";

$stmt = $dbh->prepare("SELECT userID, username FROM user WHERE userID = :userID");
$stmt->bindParam(":userID", $userID);
$stmt->execute();
$user = $stmt->fetch();
?>
		<h1>Gebruiker verwijderen</h1>
		Weet u zeker dat u de gebruiker <i><?= $user["username"] ?></i> wil verwijderen?<br /><br />
		<a href="deleteUser.php?userID=<?= $user["userID"] ?>&sure" style='width: 80px; text-align: center' class="btn-primary btn">Ja</a>
		<a href="users.php" style='width: 80px; text-align: center' class="btn-primary btn">Nee</a>
	</body>
</html>
<?php
$stmt = null;
$dbh = null;
