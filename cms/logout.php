<?php
session_start();

$_SESSION["userID"] = -1;
$_SESSION["username"] = null;
$_SESSION["role"] = 0;
$_SESSION["userRole"] = 0;
$_SESSION["loggedIn"] = false;

header("Location: /");
