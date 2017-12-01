<?php
session_start();

if($_SESSION["loggedIn"] === true) {
	header("Location: /cms/cms.php");
}

$loginFailed = false;

if(isset($_POST['username']) && isset($_POST['password'])) {
	$config = parse_ini_file("../config/config.ini");

	try {
		$dbh = new PDO("mysql:"
			. "host=" . $config["host"]
			. ";port=" . $config["port"]
			. ";dbname=" . $config["db"],
			$config["username"], $config["password"]);
	}
	catch(PDOException $e) {
		echo "Failed to connect to database";
		exit;
	}

	/* Brute force prevention:
	1. Delete failed login attempts that are too old too matter
	2. Check how many failed attempts have been made from this IP in the last hour.
	   If this IP has tried more than 5 times, the request wil not be processed.
	3. Check if the user/password combination is correct
	4. If incorrect, add this failed attempt to the database. */

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

	$acquiredSalt = "";
	$saltyStmt = $dbh->prepare("SELECT salt FROM user WHERE username = :username");
	$saltyStmt->bindParam(":username", $submittedUsername);
	$saltyStmt->execute();
	if($saltyStmt->rowCount() === 1) {
		$acquiredSalt = $saltyStmt->fetch()["salt"];
		$hashedPassword = hash('sha512', $submittedPassword . $acquiredSalt);
	}

	$stmt = $dbh->prepare("
		SELECT userID, username, role, active
		FROM user
		WHERE username = :username AND password = :password");
	$stmt->bindParam(":username", $submittedUsername);
	$stmt->bindParam(":password", $hashedPassword);
	$stmt->execute();

	if($stmt->rowCount() === 1){
		$result = $stmt->fetch();

		if ($result["active"] == 1) {
			$_SESSION["loggedIn"] = true;
			$_SESSION["userID"] = intval($result["userID"]);
			$_SESSION["username"] = $result["username"];
			$_SESSION["userRole"] = intval($result["role"]);

			$dbh = null;
			$stmt = null;
			$saltyStmt = null;
			$antibruteforceStmt = null;

			header("Location: cms.php");
			exit;
		}
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
	$antibruteforceStmt = null;
	$saltyStmt = null;
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
