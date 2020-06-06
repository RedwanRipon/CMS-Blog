<?php require_once("includes/DB.php"); ?>
<?php
function Redirect_to($New_Location){

    header("Location:". $New_Location);
    exit;
}
function CheckUserNameDuplicateOrNot($UserName){
    global $ConnectingDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if($Result==1){
        return true;
    }else{
        return false;
    }
}
function DuplicateEmailOrNot($Email){
    global $ConnectingDB;
    $sql = "SELECT email FROM admins WHERE email=:email";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':email',$Email);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if($Result==1){
        return true;
    }else{
        return false;
    }
}

function Login_Attemp($UserName, $Password){
        global $ConnectingDB;
        $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':userName',$UserName);
        $stmt->bindValue(':passWord',$Password);
        $stmt->execute();
        $Result = $stmt->rowCount();
        if($Result==1){
            return $Found_Account = $stmt->fetch();
        }else{
            return null;
        }
}
function Confirm_Login(){
    if (isset($_SESSION["UserId"])) {
        return true;
    }else{
        $_SESSION["ErrorMessage"] = "Login Required!";
        Redirect_to("Login.php");
    }
}

function TotlaPost(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPost = array_shift($TotalRows);
    echo $TotalPost;
}
function TotalCategories(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalCategories = array_shift($TotalRows);
    echo $TotalCategories;
}
function TotalAdmins(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalAdmins = array_shift($TotalRows);
    echo $TotalAdmins;
}
function TotalComments(){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalComments = array_shift($TotalRows);
    echo $TotalComments;
}
function  ApproveCommetnsAccordingToPost($PostId){
    global $ConnectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON' ";
    $stmtApprove = $ConnectingDB->query($sqlApprove);
    $RowTotals = $stmtApprove->fetch();
    $Total = array_shift($RowTotals);
    return $Total;
}
function  DisApproveCommetnsAccordingToPost($PostId){
    global $ConnectingDB;
    $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF' ";
    $stmtDisApprove = $ConnectingDB->query($sqlDisApprove);
    $RowTotals = $stmtDisApprove->fetch();
    $Total = array_shift($RowTotals);
    return $Total;
}

?>