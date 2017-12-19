		<h2>Teksten</h2>
		<table class="table">
			<tr>
				<th>Naam in systeem</th>
				<th>Beschrijving</th>
				<th>Waarde</th>
			</tr>
	<?php
	$query3 = $dbh->query("SELECT td.textName, td.description, td.exampleText, t.text
	FROM textDescription td
	LEFT JOIN text t ON t.textName = td.textName AND (websiteID = $websiteID OR websiteID IS NULL)
	ORDER BY heightOnList");

	while($t = $query3->fetch()) {
		echo "<tr>";
		echo "<td>" . $t["textName"] . "</td>";
		echo "<td>" . $t["description"] . "</td>";
		echo "<td><textarea name=\"" . $t["textName"] . "\" placeholder=\"Voorbeeld: " . $t["exampleText"] . "\">" . $t["text"] . "</textarea></td>";
		echo "</tr>";
	}
	$query3 = null;
	?>
		</table>

		<input type="reset" value="Annuleren" />
		<input type="submit" value="Opslaan" />
	</form>