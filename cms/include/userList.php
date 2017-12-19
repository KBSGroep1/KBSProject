<table class="table table-hover ">
	<thead>
		<tr>
			<th class="tableUsername">Gebruikersnaam</th>
			<th>Rol</th>
			<th>Actief</th>
			<th>Verwijderen</th>
		</tr>
	</thead>
	<tbody>
<?php
$roleNames = ["Bezoeker", "Grafisch ontwerper", "Contentbeheerder", "Beheerder"];
foreach($users as $user) {
?>
		<tr>
			<td class="tableUsername">
				<a href="users.php?userID=<?= $user["userID"] ?>"><?= $user["username"] ?></a>
			</td>
			<td><?= $roleNames[intval($user["role"])] ?></td>
			<td><?= $user["active"] == 1 ? "Ja" : "Nee" ?></td>
			<td><a class="btn-primary btn" href="deleteUser.php?userID=<?= $user["userID"] ?>">Verwijderen</a>
		</tr>
<?php
}
?>
	</tbody>
</table>
<?php
$query = $dbh->query("SELECT MAX(userID) + 1 AS nextUserID FROM user");
$result = $query->fetch(PDO::FETCH_ASSOC);

echo "<a href=\"users.php?userID=" . $result["nextUserID"] . "\" class=\"btn-primary btn\">Gebruiker toevoegen</a>";
