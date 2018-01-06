<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php';

if($_SESSION["userRole"] == 1) {
	// Product managers can only manage products
	header("Location: products.php");
	exit;
}

echo "<style> p {max-width: 900px}</style>";
echo "<h1>Wilpe CMS</h1>";
if($_SESSION["userRole"] == 3){
	echo "<p>Welkom op de website-editor van Wilpe.</p>
	<p>Om te beginnen met het editen van uw website selecteert u eerst de betreffende site.
	Klik hiervoor op de tekst ‘Alle websites’ in de bovenste menubalk.
	Er zal een dropdown menu verschijnen waarin u kunt kiezen uit alle bestaande websites.
	Nu bent u klaar om de betreffende site te bewerken.</p>
	<p>Onder de knop ‘Producten’ kunt nieuwe producten toevoegen en bestaande producten aanpassen.
	Let op! Heeft u geen website geselecteerd, dan zal u alle producten van alle sites voor u krijgen.
	Onder ‘Websites’ kunt u een nieuwe website aanmaken. Deze komt dan in de lijst te staan. Selecteer een website om deze te bewerken.</p>
	<p>In het menu ‘Gebruikers’ kunt u alle gebruikers beheren.</p>
	<p>Bij ‘Berichten’ komen alle verstuurde contactformulieren binnen.
	Als het goed is komen die ook gewoon in uw mailbox, maar het is altijd handig om ze ook in het cms te kunnen zien.</p>";
}
if($_SESSION["userRole"] == 2){
	echo "<p>Om te beginnen met het editen van uw website selecteert u eerst de betreffende site. Klik hiervoor op de tekst ‘Alle websites’ in de bovenste menubalk.
	Er zal een dropdown menu verschijnen waarin u kunt kiezen uit alle bestaande websites.
	Nu bent u klaar om de betreffende site te bewerken.</p>
	<p>Onder de knop ‘Producten’ kunt nieuwe producten toevoegen en bestaande producten aanpassen.
	Let op! Heeft u geen website geselecteerd, dan zal u alle producten van alle sites voor u krijgen.</p>
	<p>Onder ‘Websites’ kunt u een nieuw domein aanmaken. Deze komt dan in de lijst te staan. Selecteer een website om deze te bewerken.</p>
	<p>Bij ‘Berichten’ komen alle verstuurde contactformulieren binnen.
	Als het goed is komen die ook gewoon in uw mailbox, maar het is altijd handig om ze ook in het cms te kunnen zien.</p>";
}
if($_SESSION["userRole"] == 1){
	echo "<p>U bent ingelogd als Productbeheerder. Dit betekent dat u alleen toegang heeft om producten te uploaden en beheren.  
	Selecteer de juiste website in het dropdown-menu hierboven. Vervolgens klikt u op het menu 'Producten' in de linkerbalk. Nu bent u klaar om de producten te beheren.</p>";    
}

$dbh = null;
$stmt = null;
?>
	</body>
</html>
