<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
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
	<title>Comments </title>
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
				<h1><i class="fas fa-comments" style="color: #27aae1"></i> Manage Comments</h1>
			</div>
		</div>	
	</div>
</header>
<!-----Header END---->
<!-----Main Area start---->
<section class="container py-2 mb-4">
    <div class="row" style="min-height:30px;">
        <div class="col-lg-12" style="min-height:400px;" >
        <?php 
		
		echo ErrorMessage();
		echo SuccessMessage();

		?>
            <h2>Un-Approved Comments</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
               
            <?php 
            
            $ConnectingDB;
            $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
            $Execute = $ConnectingDB->query($sql);
            $Srno = 0;
            while ($DataRows = $Execute->fetch()) {
                $CommentId  = $DataRows["id"];
                $DateTimeOfComments  = $DataRows["datetime"];
                $CommenterName  = $DataRows["name"];
                $CommentContent  = $DataRows["comment"];
                $CommentPostId  = $DataRows["post_id"];
                $Srno++;
            ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($Srno); ?></td>
                        <td><?php echo htmlentities($DateTimeOfComments); ?></td>
                        <td><?php echo htmlentities($CommenterName); ?></td>
                        <td><?php echo htmlentities($CommentContent); ?></td>
                        <td style="min-width:140px;"><a href="ApproveComment.php?id=<?php echo $CommentId; ?>" class="btn btn-success">Approve</a></td>
                        <td><a href="DeleteComment.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                        <td style="min-width:140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                    </tr>

                </tbody>
            <?php } ?>
			</table>
			
			<h2>Approved Comments</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
               
            <?php 
            
            $ConnectingDB;
            $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
            $Execute = $ConnectingDB->query($sql);
            $Srno = 0;
            while ($DataRows = $Execute->fetch()) {
                $CommentId  = $DataRows["id"];
                $DateTimeOfComments  = $DataRows["datetime"];
                $CommenterName  = $DataRows["name"];
                $CommentContent  = $DataRows["comment"];
                $CommentPostId  = $DataRows["post_id"];
                $Srno++;
            ?>
                <tbody>
                    <tr>
                        <td><?php echo htmlentities($Srno); ?></td>
                        <td><?php echo htmlentities($DateTimeOfComments); ?></td>
                        <td><?php echo htmlentities($CommenterName); ?></td>
                        <td><?php echo htmlentities($CommentContent); ?></td>
                        <td style="min-width:140px;"><a href="DisApproveComment.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">Dis-Approve</a></td>
                        <td><a href="DeleteComment.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                        <td style="min-width:140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>" target="_blank">Live Preview</a></td>
                    </tr>

                </tbody>
            <?php } ?>
            </table>
        </div>
    </div>
</section>
<!-----Main Area end---->
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