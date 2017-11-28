<?php
include 'include/init.php';
include 'include/topBar.php'; 
?>
  <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="products.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Producten</a></li>        
        <li ><a href="sites.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Website</a></li>        
        <li ><a href="users.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Gebruikers</a></li>
        <li ><a href="messages.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Berichten</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="list-group">
    <?php
      $stmt = $dbh->prepare("SELECT productID, name, price, description FROM product");
      $stmt->execute();
      while ($result = $stmt->fetch()) {
          print("<a class='list-group-item' href='editProduct.php?site=" . $_GET['site'] . "&product=" . $result["productID"] . "'>" . $result["name"] . "</a>");
      }
    ?>
</div>
</body>
</html>
<?php
	$dbh = null;
	$stmt = null;