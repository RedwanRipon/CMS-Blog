<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php 

if(isset($_POST["Submit"])){
	$Category = $_POST["CategoryTitle"];
	$Admin = $_SESSION["UserName"];
	date_default_timezone_set("Asia/Dhaka");
	$CurrentTime = time();
	$DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

	if(empty($Category)){
		$_SESSION["ErrorMessage"] = "All field must be filled out";
		Redirect_to("Categories.php"); 
	}elseif(strlen($Category)<3){
		$_SESSION["ErrorMessage"] = "Category title should be grater than 3 characters";
		Redirect_to("Categories.php"); 
	}
	elseif(strlen($Category)>244){
		$_SESSION["ErrorMessage"] = "Category title should be less than 244 characters";
		Redirect_to("Categories.php"); 
	}else{
		//Query to insert category in DB when everything is fine
		$ConnectingDB;
		$sql = "INSERT INTO category(title,author,datetime)";
		$sql .= "VALUES(:categoryName, :adminName, :dateTime)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':categoryName',$Category);
		$stmt->bindValue(':adminName',$Admin);
		$stmt->bindValue(':dateTime',$DateTime);
		$Execute = $stmt->execute();
		if($Execute){
			$_SESSION["SuccessMessage"]="Category with id : ".$ConnectingDB->lastInsertId()." Added successfully";
			Redirect_to("Categories.php");
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong try again!";
			Redirect_to("Categories.php"); 
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
	<title>Add Categories</title>
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
				<h1><i class="fas fa-edit" style="color: #27aae1"></i> Manage Categories</h1>
			</div>
		</div>	
	</div>
</header>
<!-----Header END---->
<!-----Main area start---->

<section class="container py-2 mb-4">
	<div class="row">
		<div class="offset-lg-1 col-lg-10" style="min-height:340px;"> 
		<?php 
		
		echo ErrorMessage();
		echo SuccessMessage();

		?>
			<form action="Categories.php" method="post">
				<div class="card bg-secondary text-light mb-3">
					<div class="card-header">
						<h1>Add New Category</h1>
					</div>
					<div class="card-body bg-dark">
						<div class="form-group">
							<label for="title"><span class="FieldInfo" style="
							color: rgb(252, 174, 44);
							font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
							font-size: 1.2rem;"> Category Title: </span></label>
							<input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type Title Here" value="">
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

			<h2>Existing Categories</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Category Name</th>
                            <th>Creator Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
               
            <?php 
            
            $ConnectingDB;
            $sql = "SELECT * FROM category ORDER BY id desc";
            $Execute = $ConnectingDB->query($sql);
            $Srno = 0;
            while ($DataRows = $Execute->fetch()) {
                $CategoryId  = $DataRows["id"];
                $CategoryDate  = $DataRows["datetime"];
                $CategoryName  = $DataRows["title"];
                $CreatorName  = $DataRows["author"];
                $Srno++;
            ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($Srno); ?></td>
                        <td><?php echo htmlentities($CategoryDate); ?></td>
                        <td><?php echo htmlentities($CategoryName); ?></td>
                        <td><?php echo htmlentities($CreatorName); ?></td>
                        <td><a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>
                    
                    </tr>

                </tbody>
            <?php } ?>
            </table>

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