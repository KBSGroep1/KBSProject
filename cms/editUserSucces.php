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
if (empty(($_POST["active"]))) {
  $postactive = "nee";
  }else{
  $postactive = "ja";  
  }
print($_POST["userID"] . $_POST["username"] . $_POST["role"] . $postactive);
if (empty($_POST["username"])) {
}else{
  $stmt = $dbh->prepare("UPDATE user SET username=:id4 WHERE userID=:iduser ");
  $stmt->bindParam(":id4", $_POST["username"]);
  $stmt->bindParam(":iduser", $_GET["userID"]);
  $stmt->execute(); 
}

if (empty($_POST["role"])){
  if ($_POST["role"] === 0) {
  if (isset($_POST["role"])) {
  $stmt = $dbh->prepare("UPDATE user SET role=:id5 WHERE userID=:iduser ");
  $stmt->bindParam(":id5", $_POST["role"]);
  $stmt->bindParam(":iduser", $_GET["userID"]);
  $stmt->execute();  
}}}else{
  $stmt = $dbh->prepare("UPDATE user SET role=:id5 WHERE userID=:iduser ");
  $stmt->bindParam(":id5", $_POST["role"]);
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
if (empty($_POST["userID"])) {
}else{
$stmt = $dbh->prepare("UPDATE user SET userID=:id7 WHERE userID=:iduser ");
$stmt->bindParam(":id7", $_POST["userID"]);
$stmt->bindParam(":iduser", $_GET["userID"]);
$stmt->execute();  
}
?>
  </body>
</html>
<?php
  $dbh = null;
  $stmt = null;