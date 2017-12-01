<?php
session_start();

$_SESSION["userID"] = -1;
$_SESSION["username"] = null;
$_SESSION["role"] = 0;
$_SESSION["loggedIn"] = false;
$_SESSION["site"] = null;

header("Location: /");
