<?php
// TODO: use correct websiteID
// TODO: actually send emails

session_start();

if(isset($_SERVER["HTTP_HOST"]))
	$requestedDomain = $_SERVER["HTTP_HOST"];
if(isset($_SESSION["domain"]))
	$requestedDomain = $_SESSION["domain"];
if(!isset($requestedDomain)) {
	http_response_code(404);
	echo "404 Page Not Found";

	// TODO: remove
	echo "<br />Waarschijnlijk staat de HTTP_HOST niet goed, dat kan je oplossen op /changeDomain.php";
	exit;
}

if(!isset($_POST["fullname"]) || !isset($_POST["message"])) {
	header("Location: /#pageContact");
	$_SESSION["contactError"] = "Name and message are required fields";
	exit;
}
$config = parse_ini_file("config/config.ini");
$dbh = new PDO("mysql:"
	. "host=" . $config["host"]
	. ";port=" . $config["port"]
	. ";dbname=" . $config["db"],
	$config["username"], $config["password"]);
$stmt = $dbh->prepare("SELECT websiteID, name FROM website WHERE name = :name ");
$stmt->bindParam("name", $requestedDomain);
$stmt->execute();
$result = $stmt->fetch();

$submittedName = trim($_POST["fullname"]);
$submittedEmail = trim($_POST["email"]);
$submittedMessage = trim($_POST["message"]);
$submittedSite = $result["websiteID"];

if(isset($_SERVER["HTTP_HOST"]))
	$requestedWebsite = $_SERVER["HTTP_HOST"];
if(isset($_SESSION["domain"]))
	$requestedWebsite = $_SESSION["domain"];
else{
$requestedWebsite = 'sb1.ictm1l.nl';
}

if(strlen($submittedName) < 1
|| strlen($submittedMessage) < 1
|| (strlen($submittedEmail) > 0 && !filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)))
{
	header("Location: /#pageContact");
	$_SESSION["contactError"] = "Invalid data entered";
	exit;
}

$stmt = $dbh->prepare("SELECT text FROM text WHERE websiteID = :site AND textName = 'contactEmail' ");
$stmt->bindParam("site", $submittedSite);
$stmt->execute();
$result2 = $stmt->fetch();

$to = $submittedEmail;
$subject = 'Contact opname bevestiging';
$message = "Beste " . $submittedName . ", \r\n\r\nBij deze een bevestiging van uw verzonden bericht. \r\nWe zullen zo spoedig mogelijk reageren. \r\nMet vriendelijke groet, de crew van " . $requestedWebsite. ". \r\n\r\nUw bericht: ". $submittedMessage;
$headers = 'From: ' . $result2["text"];
mail($to, $subject, $message, $headers);

$to1 = $result2["text"];
$subject1 = 'Contact opname ' . $requestedWebsite . ' van ' . $submittedName;
$message1 = $submittedMessage;
$headers1 = 'From: ' . $submittedEmail;
mail($to1, $subject1, $message1, $headers1);

$statement = $dbh->prepare("INSERT INTO contact (customerName, email, text, websiteID) VALUES (:name, :email, :text, :site)");
$statement->bindParam("name", $submittedName);
$statement->bindParam("email", $submittedEmail);
$statement->bindParam("text", $submittedMessage);
$statement->bindParam("site", $submittedSite);
// $statement->bindParam("websiteID", );
$statement->execute();

header("Location: thankyou.php");
