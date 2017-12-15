<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php';	
include 'include/arrayDomain.php';	
?>
<h1></h1>
<br>
<form method="post" action="#">
		www.<input type="text" name="domein" placeholder="<?php
if(empty($_POST["domein"])){ print("voorbeeld: toolwelle");}else{print($_POST["domein"]);}?>">.nl/.com enzovoort
		<br><input type="submit" value="Submit">
</form>
<table>
	<tr>
		<th>Domein</th>
		<th>Beschikbaar</th>
	</tr>
<?php
if(empty($_POST["domein"])){
}else{
 foreach ($TLD as $key => $value) {
 $domainCheck = ($_POST["domein"] . "." . $value . ".");
 print ("<tr><td>" . $domainCheck . "</td>");
 if (gethostbyname($domainCheck) != $domainCheck ) {
 	print ("<td> nee</td></tr>");
 }else{
 	print("<td> ja</td></tr>");
 }
}}
?>
</table>
</body>
</html>
<?php
	$dbh = null;
	$stmt = null;