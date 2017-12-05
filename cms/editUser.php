<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php'; 
?>
<div>
 <?php
	if ($_SESSION["userRole"] == 3) {
	$stmt = $dbh->prepare("SELECT userID, username, role, active FROM user WHERE userID = :id ");
	$stmt->bindParam(":id", $_GET["userID"]);
	print("<table class='table table-hover tableUserEdit'><thead><tr><th>Gebruikersnaam</th><th>Wachtwoord wijzigen</th><th>Rol</th><th>Actief</th></tr></thead>");  
	$stmt->execute();
	while ($result = $stmt->fetch()) {
			print("<tr><td>" . $result["username"] . "</td>\n<td></td><td>" . $result["role"] ."</td>\n<td>");
			if ($result["active"] == 1) {
				$active = "ja";
			}else{
				$active = "nee";
			}
			print($active . "</td></tr>");
	}
 ?>
<tr>
	<form method="post" action="editUserSucces.php?userID=<?php print($_GET['userID'] . "&del=0")?>">
		<td>
			<input type="text" name="username" placeholder="Gebruikersnaam"></td>
		<td>
			<input type="password" name="editPassword" placeholder="Wachtwoord">
			<input type="password" name="editPassword1" placeholder="Wachtwoord"></td>
		<td>  
			<input type="radio" name="addRole" value="1"> Grafisch ontwerper<br>
			<input type="radio" name="addRole" value="2"> Contentbeheerder<br>
			<input type="radio" name="addRole" value="3"> Beheerder</td>
		<td>
			<input type="checkbox" name="active"></td>
		</tr>
	</table>
		<button class='btn btn-primary' type="submit" value="Submit">Opslaan</button>
	</form>
	<?php  
		}
	?>
</div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;