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
  <div class="messageHome">
    <?php 
      if (empty($_GET['site'])){
        $stmt = $dbh->prepare("SELECT contactID, customerName, text, timestamp, C.websiteID FROM contact C ORDER BY timestamp DESC");
        $stmt->bindParam(":id", $_GET["site"]);
      }else {
        $stmt = $dbh->prepare("SELECT contactID, customerName, text, timestamp, C.websiteID FROM contact C WHERE C.websiteID = :id ORDER BY timestamp DESC");
        $stmt->bindParam(":id", $_GET["site"]);
      }
      $stmt->execute();
      print("
            <table class='table table-hover'> 
                <thead><tr><th>Naam</th><th>Bericht</th><th>Datum</th></tr></thead>");
      while ($result = $stmt->fetch()) {
        print(" 
              <tr>
                <td class='tableNaam'>" . substr($result["customerName"],0,15). "</td>\n
                <td class='tableBericht'><a href='viewMessage.php?site=" . $_GET['site'] . "&message=" . $result['contactID'] . "'>" . substr($result["text"],0,50)); 
                    if (strlen($result["text"]) >=50){ 
                      print("...");
                  } 
        print("
                </td>\n
                <td>" . $result["timestamp"] . "
                </td></a>
              </tr>");
      }
    ?>
  </div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;