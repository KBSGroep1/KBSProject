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
 <?php

  $stmt = $dbh->prepare("SELECT userID, username, role, active FROM user WHERE userID = :id ");
  $stmt->bindParam(":id", $_GET["userID"]);
  print("
            <table> 
                <tr><th>Gebruikersnummer</th><th>Gebruikersnaam</th><th>Rol</th><th>Actief</th></tr>");  
  $stmt->execute();
  while ($result = $stmt->fetch()) {
      print("<tr><td>" . $result["userID"] . "</td>\n<td>" . $result["username"] . "</td>\n<td>" . $result["role"] ."</td>\n<td>");
      if ($result["active"] == 1) {
        $active = "ja";
      }else{
        $active = "nee";
      }
      print($active . "</td></tr></table>");
  }
 ?>
</div>
<div>
	<form method="post" action="editUserSucces.php?userID=<?php print($_GET['userID'])?>">
		<input type="text" name="userID" placeholder="Gebruikersnummer">
		<input type="text" name="username" placeholder="Gebruikersnaam">
		<input type="number" name="role" placeholder="Rol">
		<input type="checkbox" name="active">
		<button type="submit" value="Submit">Opslaan</button>
	</form>
</div>
  </body>
</html>
<?php
  $dbh = null;
  $stmt = null;