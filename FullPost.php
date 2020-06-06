<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

<?php $SearchQueryParameter = $_GET["id"]; ?>
<?php 

if(isset($_POST["Submit"])){
	$Name    = $_POST["CommenterName"];
	$Email   = $_POST["CommenterEmail"];
	$Comment = $_POST["CommenterThoughts"];
	date_default_timezone_set("Asia/Dhaka");
	$CurrentTime = time();
	$DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

	if(empty($Name) || empty($Email) || empty($Comment)){
		$_SESSION["ErrorMessage"] = "All field must be filled out";
		Redirect_to("FullPost.php?id=$SearchQueryParameter"); 
	}elseif(strlen($Comment)>999){
		$_SESSION["ErrorMessage"] = "Comment Length should be less than 1000 characters";
		Redirect_to("FullPost.php?id=$SearchQueryParameter");  
	}
	else{
        //Query to insert comment in DB when everything is fine
        $ConnectingDB;
		$sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
		$sql .= "VALUES(:dateTime, :name, :email, :comment, 'pending', 'OFF',:postIdFromURL)";
		$stmt = $ConnectingDB->prepare($sql);
		$stmt->bindValue(':dateTime',$DateTime);
		$stmt->bindValue(':name',$Name);
		$stmt->bindValue(':email',$Email);
		$stmt->bindValue(':comment',$Comment);
		$stmt->bindValue(':postIdFromURL',$SearchQueryParameter);
        $Execute = $stmt->execute();
       // var_dump($Execute);
		 if($Execute){
		 	$_SESSION["SuccessMessage"]="Comment Submitted successfully wait for the admin approval";
		 	Redirect_to("FullPost.php?id=$SearchQueryParameter");
		 }else{
		 	$_SESSION["ErrorMessage"] = "Something went wrong try again!";
		 	Redirect_to("FullPost.php?id=$SearchQueryParameter");
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
	<link rel="stylesheet" href="text/css" href="css/style.css">
    <title>Full Post</title>
    <style media="screen">
        .heading{
            font-family: Bitter,Georgia, 'Times New Roman', Times, serif;
            font-weight: bold;
            color: #005E90;
        }
        .heading:hover{
            color: #0090DB;
        }
        .title{
            font-weight: 500;
        }
        .recentPost{
            background-color: rgb(141, 119, 119);
        }
        .postCategories{
            background-color: #3D4F4C;
        }
        .recentFooter{
            background-color: rgb(103, 103, 129);
        }

    </style>
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
<div class="container ">
    <div class="row mt-4">
<!-----Main area Start---->
		<div class="col-sm-8">
			<h1>The Complete Responsive CMS Blog</h1>
            <h1 class="lead">The Complete CMS Blog Using PHP designed by Redwan</h1>
            <?php 
		
                echo ErrorMessage();
                echo SuccessMessage();

		    ?>
            <?php

            $ConnectingDB;
            if(isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];
                $sql = "SELECT * FROM posts 
                WHERE datetime LIKE :search 
                OR title LIKE :search 
                OR category LIKE :search 
                OR post LIKE :search";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':search','%'.$Search.'%');
                $stmt->execute();
            }
            // default sql query
            else{
                $PostIdFromUrl = $_GET["id"];
                if(!isset($PostIdFromUrl)){
                    $_SESSION["ErrorMessage"] = "Bad Request! Give the correct Url to see the post.";
                    Redirect_to("Blog.php");
                }
                $sql = "SELECT * FROM posts WHERE id= '$PostIdFromUrl'";
                $stmt = $ConnectingDB->query($sql);
                $Result = $stmt->rowCount();
                if ($Result!==1) {
                    $_SESSION["ErrorMessage"] = "Bad Request! Give the correct Url to see the post.";
                    Redirect_to("Blog.php?page=1");
                }
            }
            while($DataRows = $stmt->fetch()){
                $PostId = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $PostTitle = $DataRows["title"];
                $Category = $DataRows["category"];
                $Admin = $DataRows["author"];
                $Image = $DataRows["image"];
                $PostDescription = $DataRows["post"];
         
            ?>
            <div class="card mb-4 mt-4">
                <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px; " class="img-fluid card-img-top" alt="Image">
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                    <small class="text-muted">Category: <span class="text-dark"><a style="text-decoration: none;" href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a></span> & Written By <span class="text-dark"><a style="text-decoration: none;" href="Profile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin); ?></a></span> On <?php echo htmlentities($DateTime); ?> </small>
                    <span class="badge badge-dark text-light" style="float: right"> Comments 
                    <?php 
                    
                    echo ApproveCommetnsAccordingToPost($PostId);
                    
                    ?>
                    </span>
                    <hr>
                    <p class="card-text"> 
                        <?php                             
                            echo nl2br($PostDescription); 
                        ?> 
                    </p>
                </div>
            </div>
     <?php } ?>

<!-----Comment area Start---->

<!-----fetching existing Comment area Start---->
<span style="color: rgb(252, 174, 44);font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
            font-size: 1.2rem;">Comments</span>
            <br>
            <hr>
        <?php 

        $ConnectingDB; 
        $sql = "SELECT * FROM comments 
        WHERE post_id='$SearchQueryParameter'
        AND status='ON'";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()){
            $CommentDate = $DataRows['datetime'];
            $CommenterName = $DataRows['name'];
            $CommentContent = $DataRows['comment'];

        ?>
        <div>
            <div class="media bg-light">
                <img class="d-block img-fluid align-self-start" style="max-height: 100px;" src="images/avatar.png" alt="avatar image">
                    <div class="media-body ml-2">
                        <h6 class="lead"><?php echo $CommenterName; ?></h6>
                        <p class="small"><?php echo $CommentDate; ?></p>
                        <p><?php echo $CommentContent; ?></p>
                    </div>
            </div>
        </div>
        <hr>
        <?php } ?>
<!-----fetching existing Comment area End---->

        <div class="">
            <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 style="color: rgb(252, 174, 44);font-family: Bitter, Georgia, 'Times New Roman', Times, serif;
                            font-size: 1.2rem;">
                            Share Your Comment about this post
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="" id="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input class="form-control" type="email" name="CommenterEmail" placeholder="Email" value="" id="">
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea name="CommenterThoughts" class="form-control" id="" cols="80" rows="6"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="Submit" class="btn btn-primary">Submit</button>

                        </div>
                    </div>
                </div>

            </form>

        </div>

<!-----Comment area End---->


        </div>
<!-----Main area End---->

<?php require_once("Footer.php"); ?>