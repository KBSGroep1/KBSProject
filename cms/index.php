<?php
session_start();

if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
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
    } catch (PDOException $e) {
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

    $stmt = $dbh->prepare("
		SELECT userID, username, role, active, password
		FROM user
		WHERE username = :username");
    $stmt->bindParam(":username", $submittedUsername);
    $stmt->execute();

    if($stmt->rowCount() === 1 ) {
        $result = $stmt->fetch();

        if($result["active"] == 1 && password_verify($submittedPassword, $result["password"])) {
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
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        *, *:before, *:after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            padding: 64px;
            padding-left: 30px;
            padding-right: 30px;
            font-color: black;
            background: url(../img/bg/stock.jpg)no-repeat center center fixed;
        }

        h1 {
            margin-bottom: 8px;
            text-align: center;
            font-size: 40px;
            font-weight: 200;
            color: #606060;
        }

        #testLogin {
            border-top: 5px solid #e00613;
            padding-top: 20px;
            position: relative;
            margin-top: 3rem;
            margin-right: auto;
            margin-left: auto;
            width: 320px;
            box-shadow: 3px 3px 32px rgba(0, 0, 0, .25);
            perspective: 1000;
            background-color: white;
        }

        input {
            display: block;
            outline: 0;
            border: 1px solid fade(white, 40%);
            background-color: fade(white, 20%);
            width: 250px;
            padding: 10px 15px;
            margin: 0 auto 10px auto;
            display: block;
            text-align: center;
            font-size: 18px;
            font-weight: 300;
        }

        button {
            border-style: hidden;
            outline: 0px;
            background-color: #e00613;
            padding: 10px 15px;
            color: #e8e8e8;
            width: 250px;
            cursor: pointer;
            font-size: 18px;
        }

        button:hover {
            background-color: #a5040e;
            color: white;
        }

        .error {
            background-color: red;
            padding: 8px;
            max-width: auto;
            color: white;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: center;
        }

        form {

            padding: 20px 0;
            position: relative;
            z-index: 2;
            text-align: center;
        }
        #blackLayer {
            background-color: #ffffff;
            opacity: 0.3;
            height: 100%;
            width: 100%;
            position: absolute;
            left: 0;
            top: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
<div id="blackLayer"></div>
<div id="testLogin">
    <h1>CMS login</h1>
    <form method="POST">
        <?php
        if($loginFailed) {
            ?>
            <div class="error">Incorrect username/password!!!</div>
            <?php
        }
        ?>

        <form class="form">
            <input type="text" placeholder="Username" id="username" name="username" autofocus required/>
            <input type="password" placeholder="Password" id="password" name="password" required/>
            <button type="submit" id="login-button">Login</button>
        </form>
</div>

</body>
</html>
