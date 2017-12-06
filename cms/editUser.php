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
	$stmt->execute();
	while ($result = $stmt->fetch()) {
			$placeName = $result["username"];
			$placeRole = $result["role"];
			$active = $result["active"];
	}
 ?>
	<form method="post" action="editUserSucces.php?userID=<?php print($_GET['userID'] . "&del=0")?>">
		<div class="form-group">
			<label>Gebruikersnaam</label><br>
			<input type="text" name="username" placeholder="<?php print($placeName); ?>"><br></div>
		<div class="form-group">
			<label>Wachtwoord</label><br>
			<input type="password" name="editPassword" placeholder="Wachtwoord"><br></div>
		<div class="form-group">
			<input type="password" name="editPassword1" placeholder="Wachtwoord"><br></div>
		<div class="form-group">
			<label>Rol</label><br>
			<input type="radio" name="addRole" value="1" <?php if($placeRole == 1){print("checked");}
			?>> Grafisch ontwerper<br>
			<input type="radio" name="addRole" value="2" <?php if($placeRole == 2){print("checked");}
			?>> Contentbeheerder<br>
			<input type="radio" name="addRole" value="3" <?php if($placeRole == 3){print("checked");}
			?>> Beheerder<br></div>
		<div class="form-group">
			<label>Actief</label><br>
			<input type="checkbox" name="active"  <?php if($active == 1){print("checked");}
			?>></div>
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