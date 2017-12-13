<style>
	/* TODO */
	input[type=file] {
		display: inline-block;
	}
</style>

<h1><?php echo $existingWebsite ? $result["name"] : "Nieuwe website"; ?></h1>
<a href="sites.php">Terug naar overzicht</a><br />

<form method="POST" action="saveWebsite.php" enctype="multipart/form-data">
	<input type="hidden" name="websiteID" value="<?php echo $websiteID ?>" />
	<h2>Algemene informatie</h2>
	Domein website: <input type="text" name="websiteName" placeholder="Voorbeeld: toolwelle.com" value="<?php echo $result["name"]; ?>" /><br />
	Website actief: <input type="checkbox" name="websiteActive" <?php echo $result["active"] ? "checked" : ""; ?> /><br />
<?php
if($existingWebsite) {
	echo "<a href=\"deleteWebsite.php?websiteID=" . $result["websiteID"] . "\">Delete website</a><br />";
}
?>
	<h2>Afbeeldingen</h2>
	<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-bg1.jpg" alt="" />
	Eerste achtergrondfoto (.jpg):<input type="file" name="bg1" class="imgUpload" accept="image/jpeg" /><br />
	<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-bg2.jpg" alt="" />
	Tweede achtergrondfoto (.jpg):<input type="file" name="bg2" class="imgUpload" accept="image/jpeg" /><br />
	<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-bg3.jpg" alt="" />
	Derde achtergrondfoto (.jpg):<input type="file" name="bg3" class="imgUpload" accept="image/jpeg" /><br />
	<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-smallLogo.svg" alt="" />
	Klein logo (.png):<input type="file" name="smallLogo" class="imgUpload" accept="image/svg+xml" /><br />
	<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-largeLogo.svg" alt="" />
	Groot logo(.png):<input type="file" name="largeLogo" class="imgUpload" accept="image/svg+xml" /><br />
	<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-favicon.ico" alt="" />
	Favicon (.ico):<input type="file" name="favicon" class="imgUpload" accept="image/x-icon" /><br />

	<input type="reset" value="Annuleren" />
	<input type="submit" value="Opslaan" />

	<h2>Kleuren</h2>
	<table class="table">
<?php
// TODO: either stop using $websiteID or turn this into a statement
$query4 = $dbh->query("SELECT cd.colorName, cd.description, c.hex
FROM colorDescription cd
LEFT JOIN color c ON c.colorName = cd.colorName AND (websiteID = $websiteID OR websiteID IS NULL)
ORDER BY heightOnList");

while($t = $query4->fetch()) {
	echo "<tr>";
	echo "<td>" . $t["colorName"] . "</td>";
	echo "<td>" . $t["description"] . "</td>";
	echo "<td><input type=\"color\" value=\"" . $t["hex"] . "\" name=\"" . $t["colorName"] . "\" /></td>";
	echo "</tr>";
}
$query4 = null;
?>
	</table>
	<input type="reset" value="Annuleren" />
	<input type="submit" value="Opslaan" />

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
	echo "<td><textarea name=\"" . $t["textName"] . "\" required placeholder=\"Voorbeeld: " . $t["exampleText"] . "\">" . $t["text"] . "</textarea></td>";
	echo "</tr>";
}
$query3 = null;
?>
	</table>

	<input type="reset" value="Annuleren" />
	<input type="submit" value="Opslaan" />
</form>

<script>

$("input[type=file].imgUpload").on("change", function() {
	if(this.files[0].type !== "image/png" && this.files[0].type !== "image/jpeg") {
		alert("Je kan alleen .jpg en .png uploaden");
		return false;
	}

	// Image preview
	var reader = new FileReader();
	var elem = this;
	reader.addEventListener("load", function(e) {
		elem.previousSibling.previousSibling.setAttribute('src', e.target.result);
	});
	reader.readAsDataURL(this.files[0]);
});

$("input[type=reset]").on("click", function() {
	window.location = "/cms/sites.php";
});

</script>
