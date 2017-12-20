<div>
	<div class="topTextView">
<?php
if(isset($_SESSION["success"]) && !empty($_SESSION["success"])) {
	echo "<div class=\"alert alert-success\" role=\"alert\">" . $_SESSION["success"] . "</div><br />";
	$_SESSION["success"] = null;
}
?>
		<form method="post" action="saveUser.php?userID=<?= $userID ?>">
			<input type="hidden" name="userID" value="<?= $userID ?>" />
			<div class="form-group">
				<label for="username">Gebruikersnaam</label><br />
<?php
if(isset($_SESSION["errorU"]) && !empty($_SESSION["errorU"])) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">" . $_SESSION["errorU"] . "</div><br />";
	$_SESSION["errorU"] = null;
}
?>
				<input type="text" id="username" name="username" placeholder="Gebruikersnaam" value="<?= $user["username"] ?>" />
			</div>
			<div class="form-group">
				<label for="password1">Wachtwoord</label><br />
<?php
if(isset($_SESSION["errorPW"]) && !empty($_SESSION["errorPW"])) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">" . $_SESSION["errorPW"] . "</div><br />";
	$_SESSION["errorPW"] = null;
}
?>
				<input type="password" id="password1" name="password1" placeholder="Wachtwoord" /><br /><br />
				<input type="password" name="password2" placeholder="Herhaal wachtwoord" />
			</div>
			<div class="form-group">
				<label>Rol</label><br />
				<label for="role1" style="font-weight: normal"><input type="radio" name="role" id="role1" value="1"<?= $user["role"] < 2 ? " checked" : "" ?> /> Productbeheerder</label><br />
				<label for="role2" style="font-weight: normal"><input type="radio" name="role" id="role2" value="2"<?= $user["role"] == 2 ? " checked" : "" ?> /> Contentbeheerder</label><br />
				<label for="role3" style="font-weight: normal"><input type="radio" name="role" id="role3" value="3"<?= $user["role"] == 3 ? " checked" : "" ?> /> Beheerder</label><br />
			</div>
			<div class="form-group">
				<label for="active">Actief</label><br />
				<input type="checkbox" id="active" name="active"<?= $user["active"] == 1 ? " checked" : "" ?> />
			</div>
			<button class="btn btn-primary" type="submit" value="Submit">Opslaan</button>
		</form>
	</div>
</div>
