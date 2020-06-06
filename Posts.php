<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php

$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
//echo $_SESSION["TrackingURL"];
Confirm_Login(); ?>

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
	<title>Post</title>
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
				<h1><i class="fas fa-blog" style="color: #27aae1"></i> Blog Posts</h1>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="AddNewPost.php" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Add New Post
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Categories.php" class="btn btn-info btn-block">
                    <i class="fas fa-folder-plus"></i> Add New Category
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Admins.php" class="btn btn-warning btn-block">
                    <i class="fas fa-user-plus"></i> Add New Admin
                </a>
            </div>
            <div class="col-lg-3 mb-2">
                <a href="Comments.php" class="btn btn-success btn-block">
                    <i class="fas fa-check"></i> Approve Comments
                </a>
            </div>
		</div>	
	</div>
</header>
<!-----Header END---->

<!-----Main area start---->

<section class="container py-2 mb-4">
    <div class="row">
        <div class="col-lg-12">
        <?php 
		
		echo ErrorMessage();
		echo SuccessMessage();

		?>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date&Time</th>
                        <th>Author</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Live Preview</th>
                    </tr>
                </thead>
                <?php
                
                global $ConnectingDB;
                $sql = "SELECT * FROM posts";
                $stmt = $ConnectingDB->query($sql);
                $Sr = 0;
                while($DataRows = $stmt->fetch()){
                    $Id       = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin    = $DataRows["author"];
                    $Image    = $DataRows["image"];
                    $PostText = $DataRows["post"];    
                    $Sr++;   
                ?>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $Sr; ?>
                        </td>
                        <td> 
                            <?php 
                                if (strlen($PostTitle)>15)
                                    {
                                        $PostTitle = substr($PostTitle,0,15).'...';
                                    }
                                echo $PostTitle;
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (strlen($Category)>10)
                                    {
                                        $Category = substr($Category,0,10).'...';
                                    }
                                echo $Category;
                            ?>
                        </td>
                        <td>
                            <?php 

                                echo $DateTime;
                            ?>
                        </td>
                        <td>
                            <?php 
                                if (strlen($Admin)>6)
                                    {
                                        $Admin = substr($Admin,0,6).'...';
                                    }
                                echo $Admin;
                            ?>
                        </td>
                        <td>
                            <img src="uploads/<?php echo $Image; ?>" width="170px;" height="80px;">
                        </td>
                        <td>
                            <?php 
                            
                            $Total  = ApproveCommetnsAccordingToPost($Id);
                            if($Total>0){
                                ?>
                                <span class="badge badge-success">
                                <?php
                                echo $Total;
                                ?>
                                </span>
                           <?php } ?>
                            
                           <?php 
                            
                            $Total  = DisApproveCommetnsAccordingToPost($Id);
                            if($Total>0){
                                ?>
                                <span class="badge badge-danger">
                                <?php
                                echo $Total;
                                ?>
                                </span>
                           <?php } ?>
                    </td>
                        <td>
                            <a href="EditPost.php?id=<?php echo $Id; ?>" ><span class="btn btn-warning mb-1">Edit</span><br></a>
                            <a href="DeletePost.php?id=<?php echo $Id; ?>" ><span class="btn btn-danger">Delete</span></a>
                        </td>
                        <td><a href="FullPost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
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