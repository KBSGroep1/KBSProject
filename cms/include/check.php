<?php
print("test");
if(empty($_POST["websiteName"])){
	print("niets om te checken");
}else{
$TLD1 = array(
  "asia","biz","com","nl","be","amsterdam","coop","info","int","jobs","mobi","name","net","org","post");
$TLD2 = array(  
  "xxx","ae","pro","br","ca","ch","cn","cz","de","dk","es","eu","fr","gb","gr");
$TLD3 = array(
  "hu","ie","it","jp","li","lu","no","pl","pt","qa","ro","ru","se","uk","us");
?>
<table class='table table-hover domainTable'>
	<tr>
		<thead><th>Domein</th>
		<th>Beschikbaar</th></thead>
	</tr>
<?php
 foreach ($TLD1 as $key => $value) {
 $domainCheck = ($_POST["websiteName"] . "." . $value);
 print ("<tr><td>" . $domainCheck . "</td>");
 if (gethostbyname($domainCheck) != $domainCheck ) {
 	print ("<td> nee</td></tr>");
 }else{
 	print("<td> ja</td></tr>");
 }
}
?>
</table>
<table class='table table-hover domainTable wrapTableDomain'>
	<tr>
		<thead><th>Domein</th>
		<th>Beschikbaar</th></thead>
	</tr>
<?php
 foreach ($TLD2 as $key => $value) {
 $domainCheck = ($_POST["websiteName"] . "." . $value);
 print ("<tr><td>" . $domainCheck . "</td>");
 if (gethostbyname($domainCheck) != $domainCheck ) {
 	print ("<td> nee</td></tr>");
 }else{
 	print("<td> ja</td></tr>");
 }
}
?>
</table>
<table class='table table-hover domainTable wrapTableDomain'>
	<tr>
		<thead><th>Domein</th>
		<th>Beschikbaar</th></thead>
	</tr>
<?php
 foreach ($TLD3 as $key => $value) {
 $domainCheck = ($_POST["websiteName"] . "." . $value);
 print ("<tr><td>" . $domainCheck . "</td>");
 if (gethostbyname($domainCheck) != $domainCheck ) {
 	print ("<td> nee</td></tr>");
 }else{
 	print("<td> ja</td></tr>");
 }
}}
?>
</table>