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
<div class="message">
 <?php
  $stmt = $dbh->prepare("SELECT * FROM contact C WHERE C.contactID = :id ");
  $stmt->bindParam(":id", $_GET["message"]);
  $stmt->execute();
  while ($result = $stmt->fetch()) {
      print("<h3>" . $result["customerName"] . "\n" . $result["timestamp"] . "</h3> <p> <a>". $result["email"] . "</a><br>" . $result["text"] . "\n" .  "</p>");
  }
 ?>
</div>
  </body>
</html>
<?php
  $dbh = null;
  $stmt = null;