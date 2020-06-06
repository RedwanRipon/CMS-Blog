<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 

if (isset($_SESSION["UserId"])) {
    Redirect_to("Dashboard.php");
}

if (isset($_POST["Submit"])) {
    $UserName  = $_POST["Username"];
    $Password  = $_POST["Password"];
    if (empty($UserName)||empty($Password)) {
        $_SESSION["ErrorMessage"] = "All the fileds must filled out";
		Redirect_to("Login.php"); 
    }
    else{
        //checkig username or PASSWORD from database
        $Found_Account = Login_Attemp($UserName, $Password);
        if ($Found_Account) {
            $_SESSION["UserId"] = $Found_Account["id"];
            $_SESSION["UserName"] = $Found_Account["username"];
            $_SESSION["UserEmail"] = $Found_Account["email"];
            $_SESSION["AdminName"] = $Found_Account["aname"];
            
            $_SESSION["SuccessMessage"] = "WellCome ".$_SESSION["UserName"];
            if (isset($_SESSION["TrackingURL"])) {
                Redirect_to($_SESSION["TrackingURL"]);
            }else{
           Redirect_to("Dashboard.php");
        }
        }else{
            $_SESSION["ErrorMessage"] = "Incorrect Username/Password!";
            Redirect_to("Login.php");
        }
    }
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!------fontawesome css------>
	<link rel="stylesheet" type="text/css" href="css/all.css">
	<!------bootstrap css------>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<!------custom css------>
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Login</title>
</head>
<body>

<!-----Navbar start---->
<div style="height:10px; background: #27aae1"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a href="#" class="navbar-brand"><strong>REDWAN.COM</strong></a>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarcollapseCMS">
			
	    </div>
	</div>
</nav>
<div style="height:10px; background: #27aae1"></div>
<!-----Navbar END---->

<!-----Header Start---->
<header class="bg-dark text-white py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
			</div>
		</div>	
	</div>
</header>
<!-----Header END---->
<!-----Main area---->
<section class="container py-2 pt-3 mb-4">
    <div class="row">
        <div class="offset-sm-3 col-sm-6" style="min-height: 390px;" >
        <?php 		
            echo ErrorMessage();
            echo SuccessMessage();
        ?>
            <div class="card bg-secondary text-light">
                <div class="card-header pt-3">
                    <h4 class="text-center">WELCOME to REDWAN.COM</h4>
                </div>
                    <div class="card-body  bg-dark">
                        <form action="Login.php" method="post">
                            <div class="form-group">
                                <label for="username"><span style="
                                color: rgb(252, 174, 44);
                                font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
                                font-size: 1.2rem;" >Username: </span></label>
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="Username" id="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"><span style="
                                color: rgb(252, 174, 44);
                                font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
                                font-size: 1.2rem;" >Password: </span></label>
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" name="Password" id="password">
                                </div>
                            </div>
                            <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                        </form>
                </div>

            </div>

        </div>
    </div>

</section>
<!-----Main area END---->

<!-----Footer Start---->
<footer class="bg-dark text-white">
<div class="container">
	<div class="row">
		<div class="col">
			<p class="lead text-center">
                <strong>REDWAN.COM</strong> | Designed By | REDWAN HOSSAIN | <span id="year"></span> &copy; All Right Reserved
			</p>
			<p class="text-center small">
				This Website Made for learning purpose the author have all right to use it<br>no one is allow to distribute copies other than 
				<a style="color:rgb(17, 163, 156); text-decoration:none; " href="www.redwan.com" target="_blank">&trade; redwan.com</a>
		    </p>
		</div>
	</div>
</div>
</footer>
<div style="height:10px; background: #27aae1"></div>
<!-----Footer END---->


<!------jquery js file------>
<script type="text/javascript" src="js/jquery.3.4.1.js"></script>
<!------bootstrap js file------>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!------font icon js file------>
<script type="text/javascript" src="js/all.js"></script>
<!------custom js file------>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>