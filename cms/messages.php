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
			print("<table class='table table-hover'><thead><tr><th>Naam</th><th>Bericht</th><th>Datum</th></tr></thead>");
			while ($result = $stmt->fetch()) {
				print("<tr><td class='tableNaam'>" . substr($result['customerName'],0,15) . "</td>\n<td class='tableBericht'><a href='viewMessage.php?&message=" . $result['contactID'] . "'>" . substr($result["text"],0,50)); 
				if (strlen($result["text"]) >=50){ 
					print("...");
				} 
				print("</a></td>\n<td>" . $result["timestamp"] . "</td></tr>");
			}
		?>
	</div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;