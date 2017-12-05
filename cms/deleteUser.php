<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';
?>
<?php
$stmt = $dbh->prepare("SELECT userID, username FROM user WHERE userID=:iduser ");
$stmt->bindParam(":iduser", $_GET['userID']);
$stmt-> execute();
$result = $stmt->fetch();
print("Verwijder: " . $result['username']);
?>
<form action='editUserSucces.php?userID=<?php print($_GET["userID"]. "'"); ?> method="post">
<button class='buttonOpslaan btn-primary btn' type="submit" name="delete" value="1">JA, DAT ZIE JE TOCH</button>
</form>
<form action='users.php' method="post">
<button class='buttonOpslaan btn-primary btn' type="submit" name="delete" value="0">NEE, TUUKNIE</button>
</form>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;