<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 

$SearchQueryParameter = $_GET["username"];
global $ConnectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName ";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName',$SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowCount();
if($Result==1){
    while ($DataRows = $stmt->fetch()) {
        $ExistingName = $DataRows["aname"];
        $ExistingBio = $DataRows["abio"];
        $ExistingImage = $DataRows["aimage"];
        $ExistingHeadline = $DataRows["aheadline"];
    }
}else{
    $_SESSION["ErrorMessage"] = "Not found your Request!";
	Redirect_to("Blog.php?page=1");
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
	<link rel="stylesheet" href="text/css" href="css/style.css">
	<title>Profile</title>
</head>
<body>


<!-----Navbar start---->
<div style="height:10px; background: #27aae1"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a href="Blog.php" class="navbar-brand"><strong>REDWAN.COM</strong></a>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarcollapseCMS">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="Blog.php" class="nav-link">Home</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">About Us</a>
				</li>
				<li class="nav-item">
					<a href="Blog.php" class="nav-link">Blog</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Contact Us</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Features</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<form class="form-inline d-none d-sm-block" action="Blog.php">
                    <div class="form-group">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Search" value="">
                        <button class="btn btn-primary" name="SearchButton">Search</button>
                    </div>
                </form>
			</ul>
	    </div>
	</div>
</nav>
<div style="height:10px; background: #27aae1"></div>
<!-----Navbar END---->

<!-----Header Start---->
<header class="bg-dark text-white py-3">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
                <h1><i class="fas fa-user text-success mr-2" style="color: #27aae1"></i><?php echo $ExistingName; ?></h1>
                <h3><?php echo $ExistingHeadline; ?> </h3>
			</div>
		</div>	
	</div>
</header>
<!-----Header END---->
<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-md-3">
            <img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt="image">
        </div>
        <div class="col-md-9" style="min-height: 300px;">
            <div class="card">
                <div class="card-body">
                    <p class="lead"> <?php echo $ExistingBio; ?></p>
                </div>
            </div>
        </div>

    </div>

</section>
<!-----Footer Start---->
<footer class="bg-dark text-white">
<div class="container">
	<div class="row">
		<div class="col">
			<p class="lead text-center">
				REDWAN.COM Designed By | REDWAN HOSSAIN | <span id="year"></span> &copy; All Right Reserved
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