<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php

$_SESSION["UserId"] = null;
$_SESSION["UserName"] = null;
$_SESSION["UserEmail"] = null;
$_SESSION["AdminName"] = null;

session_destroy();

Redirect_to("Login.php");

?>