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
<div>
  <?php
  if($_SESSION["userRole"] == 3){
    $stmt = $dbh->prepare("SELECT userID, username, role, active FROM user ");
    print("<table class='table table-hover tableUser'><thead><tr><th class='tableUserID'>Gebruikersnummer</th><th class='tableUsername'>Gebruikersnaam</th><th>Rol</th><th>Actief</th></tr></thead>");
    $stmt->execute();
    $roleName = "Unkown";
    while ($result = $stmt->fetch()) {
      if($result['role'] == 1){
        $result['role'] = "Grafisch ontwerper";
      }elseif($result['role'] == 2){
        $result['role'] = "Contentbeheerder";
      }elseif($result['role'] == 3){
        $result['role'] = "Beheerder";
      }else{
        $result['role'] = "";
      }
      print("<tr><td>" . $result["userID"]. "</td>\n<td class=\"tableUsername\"><a href='editUser.php?userID=" . $result['userID'] . "'>" . $result["username"]."</td>\n<td>" . $result['role'] . "</td></a>");
      if ($result["active"] == 1) {
        $active = "ja";
      }elseif ($result["active"] == 0) {
        $active = "nee";
      }else {
        $active = $result["active"];
      }
      print("<td>" . $active . "</td></tr>");
    }
    print("</table>");
  ?>

</div>
<div class="addUser">
  <form action='addUser.php'>
    <button class='buttonOpslaan btn-primary' type="submit" value="Submit">Gebruiker toevoegen</button>
  </form>
<?php 
  }
?>
</div>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;