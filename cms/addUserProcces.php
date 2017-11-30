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
  if ($_POST["addPassword"] === $_POST["addPassword1"]){
  $stmt = $dbh->prepare("INSERT INTO user (username,password,role,active) VALUES (:id2,:id3,:id5,:id6)");
  $stmt->bindParam("id2", $_POST["addUsername"]);
  $stmt->bindParam("id3", $_POST["addPassword"]);
  $stmt->bindParam("id5", $_POST["addRole"]);
  if(empty($_POST["addActive"])){  
    $active = 0;
  }else{
  if($_POST["addActive"] == "on"){
  $active = 1;
  }}
  $stmt->bindParam("id6", $active);
  $stmt->execute();
  print("Gebruiker toegevoegd: <br>Gebruikersnaam: " . $_POST["addUsername"] . "<br>Rol: " . $_POST["addRole"] . "<br>Actief: " . $_POST["addActive"]);
  }else {
    print("Wachtwoord komt niet overeen");
  }


?>
<br><a href="users.php?userID=">Doorgaan</a>	
</div>
  </body>
</html>
<?php 
  $dbh = null;
  $stmt = null;