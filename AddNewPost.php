<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php 

if(isset($_POST["Submit"])){
    $PostTitle = $_POST["PostTitle"];
    $Category  = $_POST["Category"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "uploads/".basename($_FILES["Image"]["name"]);
    $PostText  = $_POST["PostDescription"];
	$Admin     = $_SESSION["UserName"];
	date_default_timezone_set("Asia/Dhaka");
	$CurrentTime = time();
	$DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

	if(empty($PostTitle)){
		$_SESSION["ErrorMessage"] = "Title cann't be empty";
		Redirect_to("AddNewPost.php"); 
	}elseif(strlen($PostTitle)<5){
		$_SESSION["ErrorMessage"] = "Post title should be grater than 5 characters";
		Redirect_to("AddNewPost.php"); 
	}
	elseif(strlen($PostText)>4999){
		$_SESSION["ErrorMessage"] = "Post should be less than 5000 characters";
		Redirect_to("AddNewPost.php"); 
	}else{
		//Query to insert post in DB when everything is fine
		$sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
		$sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':postTitle',$PostTitle);
		$stmt->bindValue(':categoryName',$Category);
		$stmt->bindValue(':adminName',$Admin);
		$stmt->bindValue(':imageName',$Image);
		$stmt->bindValue(':postDescription',$PostText);
		
        $Execute = $stmt->execute();
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
		if($Execute){
			$_SESSION["SuccessMessage"]="Post with id : ".$ConnectingDB->lastInsertId()." Added successfully";
			Redirect_to("AddNewPost.php");
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong try again!";
			Redirect_to("AddNewPost.php"); 
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
	<title>Add Posts</title>
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
				<h1><i class="fas fa-edit" style="color: #27aae1"></i> Add New Post</h1>
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
			<form action="AddNewPost.php" method="post" enctype="multipart/form-data">
				<div class="card bg-secondary text-light mb-3">
					<div class="card-body bg-dark">
						<div class="form-group">
							<label for="title"><span class="FieldInfo" style="
							color: rgb(252, 174, 44);
							font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
							font-size: 1.2rem;"> Post Title: </span></label>
							<input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type Title Here" value="">
                        </div>
                        <div class="form-group">
							<label for="CategoryTitle"><span class="FieldInfo" style="
							color: rgb(252, 174, 44);
							font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
							font-size: 1.2rem;"> Choose Category: </span></label>
							<select name="Category" id="CategoryTitle" class="form-control">
                                <?php 
                                //fetching all the categories from category table
                                global $ConnectingDB; 
                                $sql = "SELECT id,title FROM category";
                                $stmt = $ConnectingDB->query($sql);
                                while($DataRows = $stmt->fetch()){

                                    $Id = $DataRows["id"];
                                    $CategoryName = $DataRows["title"];

                                ?>
                                <option><?php echo $CategoryName; ?></option>
                            <?php } ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image:</label>
                            </div>
                        </div>
                        <div class="form-group">
							<label for="Post"><span class="FieldInfo" style="
							color: rgb(252, 174, 44);
							font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
							font-size: 1.2rem;"> Post: </span></label>
                            <textarea class="form-control" name="PostDescription" id="Post" cols="80" rows="8"></textarea>
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