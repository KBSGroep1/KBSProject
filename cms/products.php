<?php
include 'include/init.php';
include 'include/topBar.php'; 
?>
  <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="products.php">Producten</a></li>        
        <li ><a href="sites.php">Website</a></li>        
        <li ><a href="users.php">Gebruikers</a></li>
        <li ><a href="messages.php">Berichten</a></li>
      </ul>
    </div>
  </div>
</nav>
<table class="table table-hover">
  <thead>
    <th>Product</th>
    <th>Beschrijving</th>
    <th>Prijs</th>
  </thead>
    <?php
      $stmt = $dbh->prepare("SELECT productID, name, price, description FROM product");
      $stmt->execute();
      while ($result = $stmt->fetch()) {
          print("<tr><td><a href='editProduct.php?product=" . $result["productID"] . "'>" . $result["name"] . "</td><td>" . $result["description"] . "</td><td>&euro;" . $result["price"] / 100 . "</td></tr>");
      }
    ?>
</table>
</body>
</html>
<?php
	$dbh = null;
	$stmt = null;