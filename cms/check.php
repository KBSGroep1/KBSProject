<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php';	
include 'include/arrayDomain.php';	
?>
<h1></h1>
<br>
<form method="post" action="#">
		www.<input type="text" name="domein" placeholder="">.nl/.com enzovoort
		<br><input type="submit" value="Submit">
</form>
<?php
if(empty($_POST["domein"])){
}else{
 foreach ($TLD as $key => $value) {
 $domainCheck = ($_POST["domein"] . "." . $value);
 if (gethostbyname($domainCheck) != $domainCheck ) {
 	print ($domainCheck . " is al bezet<br>");
 }else{
 	print($domainCheck . " is bruikbaar<br>");
 }
}}
?>

</body>
</html>
<?php
	$dbh = null;
	$stmt = null;