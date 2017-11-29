<?php
include 'include/init.php';
include 'include/topBar.php'; 
?>
  <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="products.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Producten</a></li>        
        <li ><a href="sites.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Website</a></li>        
        <li class="active"><a href="users.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Gebruikers</a></li>
        <li ><a href="messages.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Berichten</a></li>
      </ul>
    </div>
  </div>
</nav>
<div>
	<form method="post" action="addUserSucces.php?userID=">
		<input type="text" name="addUserID" placeholder="Gebruikersnummer">
		<input type="text" name="addUsername" placeholder="Gebruikersnaam">
		<input type="password" name="addPassword" placeholder="Wachtwoord">
		<input type="text" name="addSalt" placeholder="Salt?">
		<input type="number" name="addRole" placeholder="Rol">
		<input type="checkbox" name="addActive">
		<button type="submit" value="Submit">Opslaan</button>
	</form>
</div>
  </body>
</html>
<?php
  $dbh = null;
  $stmt = null;