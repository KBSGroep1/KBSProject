<?php
if(!isset($_GET["domain"]) || empty($_GET["domain"]))
	exit;

$domain = $_GET["domain"];

$tlds = ["com","fr","es","nl","xxx","ru","de","co.uk","com.br","be","ch","cz","net","eu","jp","org","info","dk","frl","biz","me"];

echo "<table class=\"table domainTable\">";
echo "<thead><tr><th>Domein</th><th>Vrij</th><th>Domein</th><th>Vrij</th><th>Domein</th><th>Vrij</th></tr></thead>";

$i = 0;
foreach($tlds as $tld) {
	// TODO: this sometimes returns true when it should return false
	// i mean, wtf
	$available = checkdnsrr($domain . ".$tld.", "ANY");

	if($i === 0)
		echo "<tr>";

	echo "<td><a href=\"http://$domain.$tld\">$domain.$tld</a></td>";
	echo "<td" . ($available ? " class=\"domainNee\"" : "") . ">" . ($available ? "nee" : "ja") . "</td>";

	if($i === 2)
		echo "</tr>";

	$i += 1;
	if($i > 2) $i = 0;
}

echo "</table>";
