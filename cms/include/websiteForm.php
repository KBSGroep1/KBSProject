<h1><?= $existingWebsite ? $result["name"] : "Nieuwe website" ?></h1>
<a href="sites.php">Terug naar overzicht</a><br />
<iframe id="preview" src="../indexPreview.php?websiteID=<?= $websiteID ?>&existingWebsite=<?= $existingWebsite ? 1 : 0 ?>" width="1366" height="768"></iframe>
<script>

	var iframe = document.getElementById("preview");
	iframe.addEventListener("load", function() {
		console.log(this.contentDocument);
		$("")
	});

</script>