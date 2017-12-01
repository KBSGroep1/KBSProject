<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';
?>
<div class="message">
 <?php
	$stmt = $dbh->prepare("SELECT customerName, timestamp, email, C.websiteID, name, text FROM contact C JOIN website W on W.websiteID = C.websiteID WHERE C.contactID = :id ");
	$stmt->bindParam(":id", $_GET["message"]);
	$stmt->execute();
	while ($result = $stmt->fetch()) {
			print("<h3>" . $result["customerName"] . "\n" . $result["timestamp"] . "</h3> <p> <a href='mailto:" . $result['email'] . "?Subject=". $result['name'] ."'>". $result["email"] . "</a><br>" . $result["text"] . "\n" .  "</p>");
	}
 ?>
</div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;