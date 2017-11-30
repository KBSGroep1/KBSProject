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
  function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  } 
  if ($_POST["addPassword"] === $_POST["addPassword1"]){
  $stmt = $dbh->prepare("INSERT INTO user (username,password,role,active,salt) VALUES (:id2,:id3,:id5,:id6,:id7)");
  $salt = generateRandomString(254);
  $password = ($_POST["addPassword"] . $salt);
  $hashedPasword = (openssl_digest($password, 'sha512'));
  $stmt->bindParam("id2", $_POST["addUsername"]);
  $stmt->bindParam("id3", $hashedPasword);
  $stmt->bindParam("id5", $_POST["addRole"]);
  $stmt->bindParam("id7", $salt);
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