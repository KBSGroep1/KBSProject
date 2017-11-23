<?php
session_start();

$loginFailed = false;

if(isset($_POST['username']) && isset($_POST['password'])) {
	$config = parse_ini_file("config/config.ini");

	try {
		$dbh = new PDO("mysql:host=" . $config["host"] . ";port=" . $config["port"] . ";dbname=" . $config["db"], $config["username"], $config["password"]);
	}
	catch(PDOException $e) {
		echo "Failed to connect to database";
		exit;
	}

	$dbh->query("DELETE FROM failedLogin WHERE timestamp < CURRENT_TIMESTAMP - 3600");

	$antibruteforceStmt = $dbh->prepare("SELECT COUNT(*) FROM failedLogin WHERE ip = :ip");
	$antibruteforceStmt->bindParam(":ip", $_SERVER["REMOTE_ADDR"]);
	$antibruteforceStmt->execute();

	$antibruteforceResult = $antibruteforceStmt->fetch();
	if($antibruteforceResult["COUNT(*)"] > 5) {
		echo "You are doing this too much.";
		exit;
	}

	$submittedUsername = trim($_POST["username"]);
	$submittedPassword = $_POST["password"];

	// Is this save?
	$stmt = $dbh->prepare("SELECT userID, username, role FROM user WHERE username = :username AND password = SHA2(CONCAT(:password, salt), 512)");
	$stmt->bindParam(":username", $submittedUsername);
	$stmt->bindParam(":password", $submittedPassword);
	$stmt->execute();

	if($stmt->rowCount() === 1) {
		$result = $stmt->fetch();

		$_SESSION["loggedIn"] = true;
		$_SESSION["userID"] = intval($result["userID"]);
		$_SESSION["username"] = $result["username"];
		$_SESSION["userRole"] = intval($result["role"]);

		$dbh = null;
		$stmt = null;

		header("Location: /cms.php");
		exit;
	}
	else {
		$updateStatement = $dbh->prepare("INSERT INTO failedLogin (username, ip) VALUES (:username, :ip)");
		$updateStatement->bindParam(":username", $submittedUsername);
		$updateStatement->bindParam(":ip", $_SERVER["REMOTE_ADDR"]);
		$updateStatement->execute();
	}

	$dbh = null;
	$stmt = null;
	$updateStatement = null;
	$loginFailed = true;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
		<meta charset="UTF-8" />

		<style>

			*, *:before, *:after {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: Arial; /* todo */
				padding: 64px;
			}

			h1 {
				margin-bottom: 8px;
			}

			input {
				padding: 4px;
				margin-bottom: 8px;
			}

			.error {
				background-color: red;
				padding: 8px;
				max-width: 250px;
				color: white;
				font-weight: bold;
				margin-bottom: 8px;
			}

		</style>
	</head>
	<body>
		<h1>Log in to CMS</h1>
		<form method="POST">
<?php
if($loginFailed) {
?>
			<div class="error">Incorrect username/password</div>
<?php
}
?>
			<label for="username">
				Username: <br />
				<input type="text" id="username" name="username" autofocus required />
			</label>
			<br />
			<label for="password">
				Password: <br />
				<input type="password" id="password" name="password" required />
			</label>
			<br />
			<input type="submit" value="Login" />
		</form>
		<br />
		Forgotten your password? Sucks to be you.
	</body>
</html>
