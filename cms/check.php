<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php';
 $domain = $_POST["domein"];
 if (gethostbyname($domain) != $domain ) {
 	print ("Domein is al bezet");
 }else{
 	print("Jahoor die kan");
 }
?>
	<form method="post" action="#">
		<input type="text" name="domein">
		<input type="submit" value="Submit">
	</form>
</body>
</html>
<?php
	$dbh = null;
	$stmt = null;