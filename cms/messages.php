<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';
?>
	<div class="messageHome">
		<?php 
			if (empty($_SESSION["site"])){
				$stmt = $dbh->prepare("SELECT contactID, customerName, text, timestamp, C.websiteID FROM contact C ORDER BY timestamp DESC");
			}else {
				$stmt = $dbh->prepare("SELECT contactID, customerName, text, timestamp, C.websiteID FROM contact C WHERE C.websiteID = :id ORDER BY timestamp DESC");
				$stmt->bindParam(":id", $_SESSION["site"]);
			}
			$stmt->execute();
			print("<table class='table table-hover'><thead><tr><th>Naam</th><th>Bericht</th><th>Datum</th><th>Verwijderen</th></tr></thead>");
			while ($result = $stmt->fetch()) {
				print("<tr><td>" . substr($result['customerName'],0,15) . "</td>\n<td><a href='viewMessage.php?&message=" . $result['contactID'] . "'>" . substr($result["text"],0,50)); 
				if (strlen($result["text"]) >=50){ 
					print("...");
				} 
				print("</a></td>\n<td>" . $result["timestamp"] . "</td><td><a class='btn-primary btn' data-contactID='".$result['contactID']."' >Verwijderen</a></td></tr>");
			}
		?>
	</table>
		</div>
	</body>
	<script>
		$("a[data-contactID]").on("click", loadXMLDoc);
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", "/cms/delMessage.php?contactID=" + this.dataset.contactid, true);
  xhttp.addEventListener("load", function(r) {
  	console.log(this.responseText);
  });
  xhttp.send();
  var x = this.parentNode.parentNode;
  x.parentNode.removeChild(x);
}
</script>

</html>
<?php
	$dbh = null;
	$stmt = null;