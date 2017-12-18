<?php
require_once "include/init.php";
include "include/topBar.php"; 
include "include/sideBar.php";

$stmt = $dbh->prepare("SELECT userID, username, role FROM user WHERE userID = :userID");
$stmt->bindParam(":userID", $_GET['userID']);
$stmt-> execute();
$result = $stmt->fetch();
print("Verwijder: " . $result['username']);
?><br>
<a href="editUserSucces.php?userID=<?php print($_GET["userID"]. "&del=1&un=".$result["username"]."&rl=".$result["role"]);?>" class='btn-primary btn'>JA, DAT ZIE JE TOCH</a>
<a href="users.php" class='btn-primary btn' type="submit" name="delete" value="0">NEE, TUUKNIE</a>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;