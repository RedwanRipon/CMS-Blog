<?php require_once("includes/DB.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/Sessions.php"); ?>

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
    <title>Blog</title>
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
            // query when pagination is active
            elseif(isset($_GET["page"])) {
                $Page = $_GET["page"];
                if($Page==0 || $Page<1){
                    $ShowPostFrom = 0;
                }else{
                    $ShowPostFrom = ($Page*5)-5;
                }
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,5";
                $stmt = $ConnectingDB->query($sql);
            }
            //when category is active in url
            elseif(isset($_GET["category"])){
                $Category = $_GET["category"];
                $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc ";
                $stmt = $ConnectingDB->query($sql);
            }
            // default sql query
            else{
                $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                $stmt = $ConnectingDB->query($sql);
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
                    <span class="badge badge-dark text-light" style="float: right">Comments 
                    <?php 
                    
                    echo ApproveCommetnsAccordingToPost($PostId);
                    
                    ?>
                    </span>
                    <hr>
                    <p class="card-text"> 
                        <?php 
                            if(strlen($PostDescription)>150){
                                $PostDescription = substr($PostDescription,0,150)."...";
                            }
                            echo htmlentities($PostDescription); 
                        ?> 
                    </p>
                    <a target="_blank" href="FullPost.php?id=<?php echo htmlentities($PostId); ?>" style="float:right;">
                        <span class="btn btn-info">Read More >> </span>
                    </a>
                </div>
            </div>
     <?php } ?>

     <!---Pagination--->
     <nav>
         <ul class="pagination pagination-md">

         <!---Creating Backward button--->
         <?php
             if(isset($Page)){
                 if($Page>1){
             ?>
                <li class="page-item pr-1">
                    <a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>  
                </li> 
             <?php } }?>

            <?php 
            
            $ConnectingDB;
            $sql = "SELECT COUNT(*) FROM posts ";
            $stmt = $ConnectingDB->query($sql);
            $RowPagination = $stmt->fetch();
            $TotlaPosts = array_shift($RowPagination);
            //echo  $TotlaPosts."<br>";
            $PostPagination = $TotlaPosts/5;
            $PostPagination = ceil($PostPagination); 
            //echo $PostPagination;
            for ($i=1; $i <= $PostPagination; $i++) { 

               // if(isset($Page)){
                   // if ($i==$Page)
                      if($i) { ?>
                <li class="page-item pr-1 active">
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>  
                </li>             
                <?php 
                }else {
                ?>  <li class="page-item pr-1">
                    <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>  
                </li>            
                <?php }   
            // }          
             } ?>

             <!---Creating forward button--->
             <?php
             if(isset($Page)&&!empty($Page)){
                 if($Page+1<=$PostPagination){
             ?>
                <li class="page-item pr-1">
                    <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>  
                </li> 
             <?php } }?>

         </ul>
     </nav>

        </div>
<!-----Main area End---->

<?php require_once("Footer.php"); ?>