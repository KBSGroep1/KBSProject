<?php
include 'include/init.php';
include 'include/topBar.php';
include 'include/sideBar.php';

echo "<h1>Wilpe CMS</h1>";
if($_SESSION["userRole"] == 3){
echo "Welkom op de website-editor van Wilpe./n
Om te beginnen met het editen van uw website selecteert u eerst de betreffende site. Klik hiervoor op de tekst ‘Alle websites’ in de bovenste menubalk./n
Er zal een dropdown menu verschijnen waarin u kunt kiezen uit alle bestaande websites./n
Nu bent u klaar om de betreffende site te bewerken./n
Onder de knop ‘Producten’ kunt nieuwe producten toevoegen en bestaande producten aanpassen./n
Let op! Heeft u geen website geselecteerd, dan zal u alle producten van alle sites voor u krijgen./n
Onder ‘Websites’ kunt u een nieuw domein aanmaken. Deze komt dan in de lijst te staan. Selecteer een website om deze te bewerken./n
In het menu ‘Gebruikers’ kunt u alle gebruikers beheren./n
Bij ‘Berichten’ komen alle verstuurde contactformulieren binnen.";
}
if($_SESSION["userRole"] == 2){
echo "Om te beginnen met het editen van uw website selecteert u eerst de betreffende site. Klik hiervoor op de tekst ‘Alle websites’ in de bovenste menubalk./n
Er zal een dropdown menu verschijnen waarin u kunt kiezen uit alle bestaande websites./n
Nu bent u klaar om de betreffende site te bewerken./n
Onder de knop ‘Producten’ kunt nieuwe producten toevoegen en bestaande producten aanpassen./n
Let op! Heeft u geen website geselecteerd, dan zal u alle producten van alle sites voor u krijgen./n
Onder ‘Websites’ kunt u een nieuw domein aanmaken. Deze komt dan in de lijst te staan. Selecteer een website om deze te bewerken./n
Bij ‘Berichten’ komen alle verstuurde contactformulieren binnen.";
}
if($_SESSION["userRole"] == 1){
echo "U bent ingelogd als Productbeheerder. Dit betekent dat u alleen toegang heeft om de benodigde producten te uploaden./n    
Selecteer de juiste website in het dropdown-menu hierboven. Als u geen site selecteert, zult u alle producten te zien krijgen./n
Vervolgens klikt u op het menu 'Producten' in de linkerbalk. Nu bent u klaar om de producten te beheren./n";    
}

$dbh = null;
$stmt = null;

?>

	</body>
</html>
