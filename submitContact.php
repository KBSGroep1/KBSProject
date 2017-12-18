<?php
// TODO: use correct websiteID
// TODO: actually send emails

session_start();

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
$stmt->bindParam("name", $_SESSION["domain"]);
$stmt->execute();
$result = $stmt->fetch();

$submittedName = trim($_POST["fullname"]);
$submittedEmail = trim($_POST["email"]);
$submittedMessage = trim($_POST["message"]);
$submittedSite = $result["websiteID"];

if(strlen($submittedName) < 1
|| strlen($submittedMessage) < 1
|| (strlen($submittedEmail) > 0 && !filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)))
{
	header("Location: /#pageContact");
	$_SESSION["contactError"] = "Invalid data entered";
	exit;
}

$to = $submittedEmail;
$subject = 'Contact opname bevestiging';
$message = 'Beste ' . $submittedName . ', bij deze een bevestiging van uw verzonden bericht. <Uw bericht> ' .$submittedMessage .' We zullen zo spoedig mogelijk reageren. Met vriendelijke groet, de crew van ' . $_SESSION["domain"];
mail($to, $subject, $message);

$statement = $dbh->prepare("INSERT INTO contact (customerName, email, text, websiteID) VALUES (:name, :email, :text, :site)");
$statement->bindParam("name", $submittedName);
$statement->bindParam("email", $submittedEmail);
$statement->bindParam("text", $submittedMessage);
$statement->bindParam("site", $submittedSite);
// $statement->bindParam("websiteID", );
$statement->execute();

header("Location: thankyou.php");
