<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';
?>
<div>
 <?php

	$stmt = $dbh->prepare("SELECT userID, username, role, active FROM user WHERE userID = :id ");
	$stmt->bindParam(":id", $_GET["userID"]);
	print("<table><tr><th>Gebruikersnummer</th><th>Gebruikersnaam</th><th>Rol</th><th>Actief</th></tr>");  
	$stmt->execute();
	while ($result = $stmt->fetch()) {
			print("<tr><td>" . $result["userID"] . "</td>\n<td>" . $result["username"] . "</td>\n<td>" . $result["role"] ."</td>\n<td>");
			print($result["active"] . "</td></tr></table><a href='editUser.php?userID=" . $result['userID'] ."'>gebruiker wijzigen</a>");
	}
 ?>
</div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;