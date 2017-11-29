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
<?php
  $stmt = $dbh->prepare("INSERT INTO user (userID,username,password,salt,role,active) VALUES (:id1,:id2,:id3,:id4,:id5,:id6)");
  $stmt->bindParam("id1", $_POST["addUserID"]);
  $stmt->bindParam("id2", $_POST["addUsername"]);
  $stmt->bindParam("id3", $_POST["addPassword"]);
  $stmt->bindParam("id4", $_POST["addSalt"]);
  $stmt->bindParam("id5", $_POST["addRole"]);
  if(empty($_POST["addActive"])){  
    $active = 0;
  }else{
  if($_POST["addActive"] == "on"){
  $active = 1;
  }}
  $stmt->bindParam("id6", $active);
  $stmt->execute();  
?>
  </body>
</html>
<?php
  $dbh = null;
  $stmt = null;