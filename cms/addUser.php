<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php';
?>
<div>
	<?php 
		if ($_SESSION["userRole"] == 3) {
	?>
	<table class='table table-hover tableUser'> 
		<thead>
			<tr>
				<th class='tableUsername'>Gebruikersnaam</th>
				<th>Wachtwoord</th>
				<th>Rol</th><th>Actief</th>
			</tr>
		</thead>
			<tr>
				<form method="post" action="addUserProcces.php?userID=">
					<td>
						<input type="text" name="addUsername" placeholder="Gebruikersnaam"></td>
					<td>
						<input type="password" name="addPassword" placeholder="Wachtwoord">
						<input type="password" name="addPassword1" placeholder="Wachtwoord"></td>
					<td> 
						<input type="radio" name="addRole" value="1"> Grafisch ontwerper<br>
						<input type="radio" name="addRole" value="2"> Contentbeheerder<br>
						<input type="radio" name="addRole" value="3"> Beheerder</td>
					<td>
						<input type="checkbox" name="addActive"></td>
					</tr>
				</table>
			<button class='btn-primary btn' type="submit" value="Submit">Opslaan</button>
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