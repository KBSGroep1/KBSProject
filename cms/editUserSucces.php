<?php
include 'include/init.php';
include 'include/topBar.php'; 
include 'include/sideBar.php';
?>
<?php 
function generateRandomString($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
if ($_SESSION["userRole"] == 3) {
	$stmt = $dbh->prepare("SELECT userID, username, role, active FROM user WHERE userID=:iduser");
	$stmt->bindParam("iduser", $_GET["userID"]);
	$stmt->execute();
	$result = $stmt->fetch();
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
	if (empty($_POST["username"])) {
		$showUsername = $result["username"];
	}else{
		$stmt = $dbh->prepare("UPDATE user SET username=:id4 WHERE userID=:iduser ");
		$stmt->bindParam(":id4", $_POST["username"]);
		$stmt->bindParam(":iduser", $_GET["userID"]);
		$stmt->execute(); 
		$showUsername = $_POST["username"];
	}
	if (empty($_POST["addRole"])){
		$showRole = $result["role"];
		if ($_POST["addRole"] === 0) {
			if (isset($_POST["addRole"])) {
				$stmt = $dbh->prepare("UPDATE user SET role=:id5 WHERE userID=:iduser ");
				$stmt->bindParam(":id5", $_POST["addRole"]);
				$stmt->bindParam(":iduser", $_GET["userID"]);
				$stmt->execute();  
				$showRole = $_POST["addRole"];
			}
		}
	}else{
		$stmt = $dbh->prepare("UPDATE user SET role=:id5 WHERE userID=:iduser ");
		$stmt->bindParam(":id5", $_POST["addRole"]);
		$stmt->bindParam(":iduser", $_GET["userID"]);
		$stmt->execute(); 
		$showRole = $_POST["addRole"]; 
	}
	if (empty(($_POST["active"]))) {
		$stmt = $dbh->prepare("UPDATE user SET active=0 WHERE userID=:iduser ");
		$stmt->bindParam(":iduser", $_GET["userID"]);
		$stmt->execute();
		$showActive = "off";
	}elseif ($_POST["active"] == "on") {
		$stmt = $dbh->prepare("UPDATE user SET active=1 WHERE userID=:iduser ");
		$stmt->bindParam(":iduser", $_GET["userID"]);
		$stmt->execute();
		$showActive = $_POST["active"];
	}
}
print("Gebruiker gewijzigd: <br>Gebruikersnaam: " . $showUsername . "<br>Rol: " . $showRole . "<br>Actief: " . $showActive);
?>
	</body>
</html>
<?php
	$dbh = null;
	$stmt = null;