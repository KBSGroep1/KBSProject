<?php
include 'include/init.php';
include 'include/topBar.php'; 
?>
  <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li ><a href="products.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Producten</a></li>        
        <li ><a href="sites.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Website</a></li>        
        <?php
          if ($_SESSION["userRole"] == 3) {
        ?> 
          <li class="active"><a href="users.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Gebruikers</a></li>  
        <?php  
          }
        ?>
        <li ><a href="messages.php<?php if (isset($_GET["site"])) { print("?site=" . $_GET["site"]); } ?>">Berichten</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php 
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }
if ($_SESSION["userRole"] == 3) {
  if ((empty($_POST["editPassword"]))
    ||(empty($_POST["editPassword1"]))){
  }elseif($_POST["editPassword"] === $_POST["editPassword1"]){
    $stmt = $dbh->prepare("UPDATE user SET password=:id4, salt=:id5 WHERE userID=:iduser ");
    $salt = generateRandomString(254);
    $password = ($_POST["editPassword"] . $salt);
    $hashedPasword = (openssl_digest($password, 'sha512'));
    $stmt->bindParam(":id4", $hashedPasword);
    $stmt->bindParam(":iduser", $_GET["userID"]);
    $stmt->bindParam(":id5", $salt);
    $stmt->execute(); 
  }else {
    print("Wachtwoorden komen niet overeen");
  }
  if (empty(($_POST["active"]))) {
    $postactive = "nee";
    }else{
    $postactive = "ja";  
    }
  if($result['role'] == 1){
    $result['role'] = "Grafisch ontwerper";
  }elseif($result['role'] == 2){
    $result['role'] = "Contentbeheerder";
  }elseif($result['role'] == 3){
    $result['role'] = "Beheerder";
  }else{
    $result['role'] = "";
  }
  print( $_POST["username"] . $result['role'] . $postactive);
  if (empty($_POST["username"])) {
  }else{
    $stmt = $dbh->prepare("UPDATE user SET username=:id4 WHERE userID=:iduser ");
    $stmt->bindParam(":id4", $_POST["username"]);
    $stmt->bindParam(":iduser", $_GET["userID"]);
    $stmt->execute(); 
  }

  if (empty($_POST["addRole"])){
    if ($_POST["addRole"] === 0) {
      if (isset($_POST["addRole"])) {
        $stmt = $dbh->prepare("UPDATE user SET role=:id5 WHERE userID=:iduser ");
        $stmt->bindParam(":id5", $_POST["addRole"]);
        $stmt->bindParam(":iduser", $_GET["userID"]);
        $stmt->execute();  
      }
    }
  }else{
    $stmt = $dbh->prepare("UPDATE user SET role=:id5 WHERE userID=:iduser ");
    $stmt->bindParam(":id5", $_POST["addRole"]);
    $stmt->bindParam(":iduser", $_GET["userID"]);
    $stmt->execute();  
  }
  if (empty(($_POST["active"]))) {
    $stmt = $dbh->prepare("UPDATE user SET active=0 WHERE userID=:iduser ");
    $stmt->bindParam(":iduser", $_GET["userID"]);
    $stmt->execute();
  }elseif ($_POST["active"] == "on") {
    $stmt = $dbh->prepare("UPDATE user SET active=1 WHERE userID=:iduser ");
    $stmt->bindParam(":iduser", $_GET["userID"]);
    $stmt->execute();
  }
}
?>
  </body>
</html>
<?php
  $dbh = null;
  $stmt = null;