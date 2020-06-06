<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php 
//fecthing the existing admin data start
$AdminId = $_SESSION["UserId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId' ";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $ExistingName = $DataRows['aname'];
    $ExistingUserName = $DataRows['username'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
}
//fecthing the existing admin data end
if(isset($_POST["Submit"])){
    $AName = $_POST["Name"];
    $AHeadline  = $_POST["Headline"];
    $ABio  = $_POST["Bio"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "images/".basename($_FILES["Image"]["name"]);

	if(strlen($AHeadline)>30){
		$_SESSION["ErrorMessage"] = "Headline should be less than 30 characters";
		Redirect_to("MyProfile.php"); 
	}
	elseif(strlen($ABio)>3000){
		$_SESSION["ErrorMessage"] = "Bio should be less than 3000 characters";
		Redirect_to("MyProfile.php"); 
	}else{
		//Query to update data in DB when everything is fine
        global $ConnectingDB;
        if(!empty($_FILES["Image"]["name"])){

            $sql = "UPDATE admins 
                    SET aname ='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
                    WHERE id='$AdminId'";
        }else{
            $sql = "UPDATE admins 
                    SET aname ='$AName', aheadline='$AHeadline', abio='$ABio'
                    WHERE id='$AdminId'";
        }
        $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

		if($Execute){
			$_SESSION["SuccessMessage"]="Details Updated Successfully";
			Redirect_to("MyProfile.php");
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong try again!";
			Redirect_to("MyProfile.php"); 
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
	<title>My Profile</title>
	<!------bootstrap css------>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<!------fontawesome css------>
	<link rel="stylesheet" type="text/css" href="css/all.css">
	<!------custom css------>
	<link rel="stylesheet" href="text/css" href="css/style.css">
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
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
				</li>
				<li class="nav-item">
					<a href="Dashboard.php" class="nav-link">Dashboard</a>
				</li>
				<li class="nav-item">
					<a href="Posts.php" class="nav-link">Posts</a>
				</li>
				<li class="nav-item">
					<a href="Categories.php" class="nav-link">Categories</a>
				</li>
				<li class="nav-item">
					<a href="Admins.php" class="nav-link">Manage Admins</a>
				</li>
				<li class="nav-item">
					<a href="Comments.php" class="nav-link">Comments</a>
				</li>
				<li class="nav-item">
					<a href="Blog.php?page=1" class="nav-link">Live Blog</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a>
				</li>
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
			<div class="col-md-12">
                <h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $ExistingUserName; ?></h1>
                <small><?php echo $ExistingHeadline;?></small>
            </div>
		</div>	
	</div>
</header>
<!-----Header END---->
<!-----Main area start---->

<section class="container py-2 mb-4">
	<div class="row">
        <!-----Left area start---->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h3 class="text-center"><?php echo $ExistingName; ?></h3>
                </div>
                <div class="card-body">
                    <img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3" alt="image">
                    <div class="">
                      <?php echo $ExistingBio; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-----Right area start---->
		<div class="col-md-7" style="min-height:340px;"> 
		<?php 
		
		echo ErrorMessage();
		echo SuccessMessage();

		?>
			<form action="MyProfile.php" method="post" enctype="multipart/form-data">
				<div class="card bg-dark text-light">
                    <div class="card-header bg-secondary text-light ">
                        <h4>Edit Profile</h4>
                    </div>
					<div class="card-body">
						<div class="form-group">							
                            <input class="form-control" type="text" name="Name" id="title" placeholder="Your Name" value="">
                        </div>
                        <div class="form-group">							
                            <input class="form-control" type="text" name="Headline" id="title" placeholder="Headline" value="">
                            <small class="text-muted">Add a Professional headline like: Engineer,Feelencer,Developer,Architecture,Journalist. </small>
                            <span class="text-danger">Not more than 30 characters</span>
                        </div>

                        <div class="form-group">
                            <textarea placeholder="Bio" class="form-control" name="Bio" id="Post" cols="80" rows="8"></textarea>
                        </div>
                
                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image:</label>
                            </div>
                        </div>
                        
						<div class="row">
							<div class="col-lg-6 mb-2">
								<a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
							</div>
							<div class="col-lg-6 mb-2">
								<button type="submit" name="Submit" class="btn btn-success btn-block">
								<i class="fas fa-check"></i> Publish
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
	</div>

</section>
<!-----Main area start END---->

<!-----Footer Start---->
<footer class="bg-dark text-white">
<div class="container">
	<div class="row">
		<div class="col">
			<p class="lead text-center">
			<strong>REDWAN.COM</strong> | Designed By | REDWAN HOSSAIN | <span id="year"></span> &copy; All Right Reserved
			</p>
			<p class="text-center small">
				This Website Made for learning purpose the author have all right to use it<br>no one is allow to distribute or copies other than 
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