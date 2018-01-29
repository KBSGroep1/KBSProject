<?php
if(true) {
	http_response_code(404);
	echo "404 Page Not Found";
	exit;
}

session_start();

if(isset($_GET["domain"])) {
	$_SESSION["domain"] = $_GET["domain"];
}
?>
De websites luisteren naar <code>$_SERVER["HTTP_HOST"]</code> en dat is vaak <code>localhost</code> dus hiermee kan je zelf instellen wat daar in zit.
<br /><br />
<form method="GET">
<input name="domain" placeholder="Bijvoorbeeld toolwelle.com" value="<?php echo isset($_SESSION["domain"]) ? $_SESSION["domain"] : ""; ?>" />
<input type="submit" />
</form>
