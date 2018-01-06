<link rel="stylesheet" type="text/css" href="../css/websiteForm.css" />
<h1><?= $existingWebsite ? $result["name"] : "Nieuwe website" ?></h1>

<!--
	If this link is enabled, the preview won't fit on a 1920x1080 screen.
	I don't think it is needed, because there is a link to sites.php right
	in the sidebar, but I'll leave it in for now so whoever checks this
	code can decide if we keep it

	<a href="sites.php">Terug naar overzicht</a><br />
-->

<main>
<form method="POST" action="saveWebsite.php" enctype="multipart/form-data">
	<input class="displayNone" id="tab1" type="radio" name="tabs" checked />
	<label for="tab1">Algemeen</label>

	<input class="displayNone" id="tab2" type="radio" name="tabs" />
	<label for="tab2">Afbeeldingen</label>

	<input class="displayNone" id="tab3" type="radio" name="tabs" />
	<label for="tab3">Kleuren</label>

	<input class="displayNone" id="tab4" type="radio" name="tabs" />
	<label for="tab4">Teksten</label>

	<input class="displayNone" id="tab5" type="radio" name="tabs" />
	<label for="tab5">Live preview</label>

	<section id="content1">
		<input type="hidden" name="websiteID" value="<?php echo $websiteID ?>" />
		Domeinnaam: <input type="text" name="websiteName" id="domainName" placeholder="Voorbeeld: toolwelle.com" value="<?= $existingWebsite ? $result["name"] : "" ?>" /><br />
		Website actief: <input type="checkbox" name="websiteActive" <?= $result["active"] == 1 ? "checked" : "" ?>><br />
		<input type="submit" value="Opslaan" />
		<br /><br /><br />
		<div id="domainCheck"></div>
	</section>

	<section id="content2">
		<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-bg1.jpg" alt="" />
		Eerste achtergrondfoto (.jpg):<input data-index="1" type="file" name="bg1" class="imgUpload" accept="image/jpeg" /><br />
		<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-bg2.jpg" alt="" />
		Tweede achtergrondfoto (.jpg):<input data-index="2" type="file" name="bg2" class="imgUpload" accept="image/jpeg" /><br />
		<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-bg3.jpg" alt="" />
		Derde achtergrondfoto (.jpg):<input data-index="3" type="file" name="bg3" class="imgUpload" accept="image/jpeg" /><br />
		<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-smallLogo.svg" alt="" />
		Klein logo (.png):<input type="file" name="smallLogo" class="imgUpload" accept="image/svg+xml" /><br />
		<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-largeLogo.svg" alt="" />
		Groot logo(.png):<input type="file" name="largeLogo" class="imgUpload" accept="image/svg+xml" /><br />
		<img height="80" class="imagePreview" src="../img/bg/<?= $websiteID ?>-favicon.ico" alt="" />
		Favicon (.ico):<input type="file" name="favicon" class="imgUpload" accept="image/x-icon" /><br />

		<input type="submit" value="Opslaan" />
	</section>

	<section id="content3">
		<table class="table">
			<tr>
				<th>Naam in systeem</th>
				<th>Beschrijving</th>
				<th>Waarde</th>
			</tr>
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
		echo "<td><input type=\"color\" value=\"" . ($t["hex"] === null ? "#AAAAAA" : $t["hex"]) . "\" name=\"" . $t["colorName"] . "\" /></td>";
		echo "</tr>";
	}

	$query4 = null;
?>
		</table>
		<input type="submit" value="Opslaan" />
	</section>

	<section id="content4">
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
	echo "<td class=\"tName\">" . $t["textName"] . "</td>";
	echo "<td class=\"tDescription\">" . $t["description"] . "</td>";
	echo "<td><textarea class=\"tab4Input\" data-textname=\"" . $t["textName"] . "\" name=\"" . $t["textName"] . "\" placeholder=\"Voorbeeld: " . $t["exampleText"] . "\">" . $t["text"] . "</textarea></td>";
	echo "</tr>";
}

$query3 = null;
?>
		</table>

		<input type="submit" value="Opslaan" />
</section>

<section id="content5">
	<iframe id="preview" src="../indexPreview.php?websiteID=<?= $websiteID ?>&existingWebsite=<?= $existingWebsite ? 1 : 0 ?>" width="1366" height="768"></iframe>
	<div id="previewSidebar">
		<p>
			<b>Preview</b><br />
			Klik op teksten om ze aan te passen. <i>Niet alle teksten zijn zichtbaar in de preview.</i> Als je teksten, kleuren of afbeeldingen aanpast in de andere tabjes, worden ze hier live geupdated.
		</p>
		<input type="submit" value="Opslaan" />
	</div>
</section>
</form>
</main>

<script>

	var iframe = $("#preview");

	// Sync texts between <textarea>s and the iframe
	iframe.on("load", function() {
		// We use two dictionaries: one for the <textarea>s and one for the contenteditables
		// Elements are accessible by name
		var formTextInputs = {};
		var iframeTextInputs = {};

		$("textarea[data-textname]").each(function(i, e) {
			e.addEventListener("input", function() {
				if(iframeTextInputs[this.dataset.textname] !== undefined)
					iframeTextInputs[this.dataset.textname].innerText = this.value;
			});

			formTextInputs[e.dataset.textname] = e;
		});

		iframe.contents().find("*[data-textname]").each(function(i, e) {
			e.addEventListener("input", function() {
				formTextInputs[this.dataset.textname].value = this.innerText;
			});

			iframeTextInputs[e.dataset.textname] = e;
		});
	});

	$("input[type=color]").on("change", function() {
		iframe.contents().find(".contactIcon i, .buttonColor").css("background-color", this.value);
		iframe.contents().find(".titleAbout").css("color", this.value);
		iframe.contents().find(".productCard figcaption").css("border-top", "3px solid " + this.value);

		// Sadly, we cant edit the :after node styles that are used to underline some texts
	});

	// Image preview
	$("input[type=file].imgUpload").on("change", function() {
		var reader = new FileReader();
		var elem = this;
		reader.addEventListener("load", function(e) {
			// Update <img> next to <input> element
			elem.previousSibling.previousSibling.style.backgroundImage = 'url(' + e.target.result + ')';
			elem.previousSibling.previousSibling.style.backgroundSize = '100% auto';
			
			// Update iframe background

			if(elem.dataset.index === undefined) return;

			// parallax.js makes it tricky to change a background in an iframe, this comes close enough
			let index = 3 - parseInt(elem.dataset.index, 10);
			let bg = iframe.contents().find(".parallax-slider");
			bg[index].src = e.target.result;
		});

		reader.readAsDataURL(this.files[0]);
	});

	// Domain availability check
	var currentXHR = null, currentTimeout = null, v = null;
	$("#domainName").on("input", function() {
		v = this.value;
		v = v.split(".")[0];

		if(currentTimeout !== null)
			window.clearTimeout(currentTimeout);

		currentTimeout = window.setTimeout(function() {
			if(v.length > 0)
				$("#domainCheck").html("Domeinnamen controleren - kan even duren...");
			else
				$("#domainCheck").html("");

			if(currentXHR !== null)
				currentXHR.abort();

			currentXHR = $.ajax({url: "domainCheck.php?domain=" + v, success: function(r) {
				$("#domainCheck").html(r);
			}})
		}, 1000);
	});

	$("input[type=submit]").on("click", function(e) {
		$("input:not([type=submit], [type=checkbox], [type=radio], [type=file]), textarea").each(function(i, g) {
			if(this.value.length < 1) {
				alert("Niet alle vereiste velden zijn ingevuld");
				e.preventDefault();
				return false;
			}
		});

		// e.preventDefault();
		// return false;
	});

</script>