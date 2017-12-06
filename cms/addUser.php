<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php';
?>
<div>
	<?php 
		if ($_SESSION["userRole"] == 3) {
	?>
	<div class="topTextView">
				<form method="post" action="addUserProcces.php?userID=">
				<div class="form-group">
					<label>Gebruikersnaam</label><br>
						<input type="text" name="addUsername" placeholder="Gebruikersnaam"><br></div>
				<div class="form-group">
					<label>Wachtwoord</label><br>
						<input type="password" name="addPassword" placeholder="Wachtwoord"></div>
				<div class="form-group">
						<input type="password" name="addPassword1" placeholder="Wachtwoord"></div>
				<div class="form-group">
					<label>Rol</label><br>
						<input type="radio" name="addRole" value="1"> Grafisch ontwerper<br>
						<input type="radio" name="addRole" value="2"> Contentbeheerder<br>
						<input type="radio" name="addRole" value="3"> Beheerder<br></div>
				<div class="form-group">
					<label>Actief</label><br>
						<input type="checkbox" name="addActive"></div>
			<button class='btn-primary btn' type="submit" value="Submit">Opslaan</button>
		</form>
	</div>
	<?php 
		}
	?>
</div>
	</body>
</html>
<?php 
	$dbh = null;
	$stmt = null;