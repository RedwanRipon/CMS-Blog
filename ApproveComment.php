<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php 

if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    $ConnectingDB;
    $Admin =  $_SESSION["AdminName"];
    $sql = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter' ";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Comment Approved Successfully"; 
		Redirect_to("Comments.php"); 
    }else{
        $_SESSION["ErrorMessage"] = "Something went wrong,try again!"; 
		Redirect_to("Comments.php"); 
    }
}

?>