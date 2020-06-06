<!-----Side area Start---->
<div class="col-sm-4">
            <div class="card mt-4">
                <div class="card-body">
                    <img src="images/image1.png" class="d-block img-fluid mb-3" alt="image">
                    <div class="text-center" style="font-family: Roboto; font-weight:600;background-color:lavenderblush">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio, numquam! Quas nisi distinctio amet reprehenderit pariatur expedita hic necessitatibus ab. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, quam?
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header text-light bg-dark">
                    <h2 class="lead text-center font-weight-bold">Signup</h2>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="" value="">Join The Forum</button>
                    <h5 class="lead font-weight-bold mb-3">Already Join? Then login from here</h5>
                    <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="" value="">Login</button>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="" placeholder="Enter Your Email" value="">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card postCategories">
                <div class="card-header bg-primary text-light">
                    <h2 class="lead font-weight-bold">Post Categories</h2>
                </div>
                    <div class="card-body">
                        <?php 
                        
                        $ConnectingDB;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>
                        <a style="text-decoration: none;" href="Blog.php?category=<?php echo htmlentities($CategoryName); ?>"><span class="heading" style="color:honeydew;"><?php echo htmlentities($CategoryName); ?></span></a><br>
                        <?php } ?>

                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h2 class="lead font-weight-bold">Recent Posts</h2>
                </div>
                <div class="card-body recentPost">
                    <?php 
                    
                    $ConnectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $ConnectingDB->query($sql);
                    while ($DataRows = $stmt->fetch()) {
                        $Id = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $Title = $DataRows["title"];
                        $Image = $DataRows["image"];
                    ?>
                    <div class="media">
                        <img src="uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="image">
                        <div class="media-body ml-2">
                            <a style="text-decoration: none; color:ghostwhite;" href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><h2 class="lead title"><?php echo htmlentities($Title); ?></h2></a>
                            <p class="small"><?php echo htmlentities($DateTime); ?></p>
                        </div>
                    </div>
                    <hr>
                    <?php } ?>
                </div>
                <p class="lead recentFooter text-center text-white mb-0"> Share Your Idea with us,click <a style="text-decoration: none; color:aqua;" href="#">here</a></p>
            </div>
			
        </div>
<!-----Side area End---->
	</div>

</div>
<!-----Header END---->
<br>
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