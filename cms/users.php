<?php include 'topBar.php'; ?>
  <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="products.php">Producten</a></li>        
        <li ><a href="sites.php">Website</a></li>        
        <li class="active"><a href="users.php">Gebruikers</a></li>
        <li ><a href="messages.php">Berichten</a></li>
      </ul>
    </div>
  </div>
</nav>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;