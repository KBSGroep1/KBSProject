<?php
include 'include/init.php';
include 'include/topBar.php'; 
?>
  <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="products.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Producten</a></li>        
        <li ><a href="sites.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Website</a></li>        
        <li ><a href="users.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Gebruikers</a></li>
        <li class="active"><a href="messages.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Berichten</a></li>
      </ul>
    </div>
  </div>
</nav>
<div>
 <?php
  $stmt = $dbh->prepare("SELECT contactID, customerName, text, timestamp, C.websiteID FROM contact C WHERE C.websiteID = :id ORDER BY timestamp DESC");
  $stmt->bindParam(":id", $_GET["site"]);
  $stmt->execute();
  while ($result = $stmt->fetch()) {
      print("<li><a href='?message=" . $result['contactID'] . "'>" . $result["customerName"] . ":\n" . substr($result["text"],0,100) . "\n" . $result["timestamp"] . "</a></li>");
  }
 ?>
</div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;