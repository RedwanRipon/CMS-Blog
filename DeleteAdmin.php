<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php 

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    $ConnectingDB;
    $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter' ";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Admin Deleted Successfully"; 
		Redirect_to("Admins.php"); 
    }else{
        $_SESSION["ErrorMessage"] = "Something went wrong,try again!"; 
		Redirect_to("Admins.php"); 
    }
}

?>