<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';
?>
<div>
	<?php
	if($_SESSION["userRole"] == 3){
		$stmt = $dbh->prepare("SELECT userID, username, role, active FROM user ");
		print("<table class='table table-hover tableUser'><thead><tr><th class='tableUserID'>Gebruikersnummer</th><th class='tableUsername'>Gebruikersnaam</th><th>Rol</th><th>Actief</th><th>Verwijderen</th></tr></thead>");
		$stmt->execute();
		$roleName = "Unkown";
		while ($result = $stmt->fetch()) {
			if($result['role'] == 1){
				$result['role'] = "Grafisch ontwerper";
			}elseif($result['role'] == 2){
				$result['role'] = "Contentbeheerder";
			}elseif($result['role'] == 3){
				$result['role'] = "Beheerder";
			}else{
				$result['role'] = "";
			}
			print("<tr><td>" . $result["userID"]. "</td>\n<td class=\"tableUsername\"><a href='editUser.php?userID=" . $result['userID'] . "'>" . $result["username"]."</td>\n<td>" . $result['role'] . "</td></a>");
			if ($result["active"] == 1) {
				$active = "ja";
			}elseif ($result["active"] == 0) {
				$active = "nee";
			}else {
				$active = $result["active"];
			}
			print("<td>" . $active); ?>
			</td><td><a href="deleteUser.php?userID=<?php print($result['userID']); ?>" class='btn-primary btn' type='submit' value='Submit'>Verwijderen</button></td></tr>
			</form>
<?php 
}
?>

</div>
</table>

<div class="addUser">
	<form action='addUser.php'>
		<button class='buttonOpslaan btn-primary btn' type="submit" value="Submit">Gebruiker toevoegen</button>
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