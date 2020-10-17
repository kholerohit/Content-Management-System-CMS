<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Blog Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/publicstyle.css">
  <style>
    
    .col-sm-8{
      background-color: lightgrey;
      opacity: 1;
    }
    .col-sm-3{
      background-color: mediumSeaGreen;
      opacity: .9;
      font-weight: bold;
    }
  </style>

</head>
<body>
 <!-- Navbar starting -->
<nav class="navbar navbar-expand-lg nav-item fixed-top navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls=" navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link" href="Blog.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="Blog.php">Blog<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="squadfree/index.html">About Us</a>
      </li>
        <li class="nav-item">
        <a class="nav-link" href="squadfree/index.html">Contact Us</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="squadfree/index.html">Services</a>
          <a class="dropdown-item" href="squadfree/index.html">Feature</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="squadfree/index.html">About site</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form action="Blog.php" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search"  name="search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0"  name="search_button" type="submit">Search</button>
    </form>
  </div>
</nav>
<!-- navbar ended -->
<!-- ================================================================================================================================-->
<!-- main area started -->
<div class="container">

    <div class="blog-header">
         <h1>The</h1>
         <h1>The Complete Responsive CMS Blog</h1>

        <p class="">This blog is created by Khole Rohan for study and Practice....  </p>
    </div>

    <div class="row">
        <div class="col-sm-8">
          <h2>Right8  </h2>
          <?php 

          global $conn;
          if(isset($_GET["search_button"]))  
          {
            $search = $_GET["search"];
            $query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR category LIKE '%$search%'  OR post LIKE '%$search%'";
          }
          elseif(isset($_GET["page"]))  
          {
            $page = $_GET["page"];
            if ($page<=0) 
            {
              $showPostFrom = 0;
            }
            else 
            {
              $showPostFrom = ($page*5)-5; 
            }
            $query = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT   $showPostFrom ,5";
          }
          elseif(@$_GET["category"])
          {
            $Category =  $_GET["category"];
             $query = "SELECT * FROM admin_panel WHERE category='$Category' ORDER BY datetime desc";

          }
          else
          {
            $query = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
          }
          $execute = mysqli_query($conn,$query) or die('Error');

          while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
          {     

          $id = $row["id"];
          $dateTime = $row["datetime"];
          $title = $row["title"];
          $categoryname = $row["category"];
          $creator_name = $row["auther"];
          $image = $row["image"];
          $post = $row["post"];
          ?>
          <br>
          <div class="blogpost thumbnail cblog">
            <img class="img-fluid " src="upload/<?php echo $image ;?>"> 
            <div class="caption">
                <h1 id="heading3"><?php echo htmlentities($title) ;?></h1>
                <p class="description">Category:<?php echo htmlentities($categoryname) ;?> Published on 
                <?php echo htmlentities($dateTime);?>  
                </p>

                <p class="post">
                <?php 
                if(strlen($post)>160)
                {
                  $post = substr($post,0,160).'...'; 
                }
                echo nl2br($post) ;?>
                </p>
                <a href="fullpost.php?id=<?php echo $id ;?>"><span class="btn btn-info">Read More &rsaquo; &rsaquo;</span> </a>
            </div><br><br><hr>  
          </div>
          <?php } ?>

          <nav>
            <ul class="pagination pagination-design">
              <!-- CBB -->
              <?php if(@$page > 1){ ?>
                <li class="btn  btn-outline-success pagination-design-li">
                <a class="btn  btn-info pagination-design-li" href="Blog.php?page=<?php echo $page-1 ;?>">&laquo</a>
              </li>
              <?php } ?>
            <?php 

              global $conn;
              $query_page = "SELECT COUNT(*) FROM admin_panel";
              $execute = mysqli_query($conn,$query_page) or die("Error");
              $row_pagination = mysqli_fetch_array($execute);
              $total_post = array_shift($row_pagination);
              $postPagination = $total_post/5;  // total pages of pagianation 
              $postPagination = ceil($total_post/5); 
              // echo $total_post;
              // echo $postPerPage ;
            for($i=1;$i<=$postPagination;$i++){
            if(!isset($page)){$page = 1;} // default set to page 1
            if($i == @$page){


            ?>
              <li class="btn  btn-outline-success pagination-design-li active">
                <a class="btn  btn-info pagination-design-li" href="Blog.php?page=<?php echo $i ;?>"><?php echo $i ;?></a>
              </li>
            <?php }else{ ;?>
              <li class="btn  btn-outline-success pagination-design-li">
                <a class="btn  btn-info pagination-design-li" href="Blog.php?page=<?php echo $i ;?>"><?php echo $i ;?></a>
              </li>
            <?php 
                }
              }
             ?>
              <!-- CFB -->
              <?php if(@$page+1 <= $postPagination ){ ?>
                <li class="btn  btn-outline-success pagination-design-li">
                <a class="btn  btn-info pagination-design-li" href="Blog.php?page=<?php echo $page+1 ;?>">&raquo</a>
              </li>
              <?php } ?>

          </ul>
          </nav>
            
        </div>  
        <!-- right bar endede -->
        <!-- ============================== -->
        <div class="col-sm-1">   
        </div>
        <div class=" col-sm-3">


          <h2>left3</h2>
          <!-- <p class="blogpost thumbnail cblog"> 
            
            lorem ipsum is dummy text 
          </p> -->
          <div class="panel-group ">
          <div class="panel panel-primary cblog">
              <div class="heading">
                <h2 id="heading3" class="title"><center>Categories</center></h2>
              </div> 
              <div class="panel-body">
              <?php 
                global $conn;
                global $conn;
          $query = "SELECT * FROM category ORDER BY datetime desc";
          $execute = mysqli_query($conn,$query) or die('Error');

          while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
          {     

          $id = $row["id"];
          $categoryname = $row["name"];
          
          ?>
          <a class="left3_1" href="Blog.php?category=<?php echo $categoryname ?>">
          <span class="heading left3_1"><?php  echo "<hr><center><em>".$categoryname."<em><center>" ;?></span>
          </a>
          <?php } ?>
              </div>
              <div class="panel-footer">
                
              </div>
          </div><br>

          </div>
           <div class="panel-group ">
          <div class="panel panel-primary cblog">
              <div class="heading">
                <h2 id="heading3" class="title"><center>Recent Posts</center></h2>
              </div> 
              <div class="panel-body">
              <?php 
                global $conn;
                global $conn;
          $query = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
          $execute = mysqli_query($conn,$query) or die('Error');

          while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
          {     

          $id = $row["id"];
          $title = $row["title"];
          $dateTime = $row["datetime"];
          $image = $row["image"];
          ?>
          <hr>
          <div>
            <img style="float:left" src="upload/<?php echo $image ;?>" width=70; height=70;>
            <a href="fullpost.php?id=<?php echo $id ;?>">
              <p id="big_title" class="left3_1" style="margin-left: 90px "><?php echo htmlentities($title) ;?></p>
            <p id="heading3" class="left3_1" style="margin-left: 90px "><?php if(strlen($dateTime) > 11){ $dateTime = substr($dateTime, 0, 11) ;} echo htmlentities($dateTime) ;?>
            </p>
            </a>
          </div>
          <?php } ?>
              </div>
              <div class="panel-footer">
                
              </div>
          </div>
          </div><br>


        </div>  
        <!-- left bar endede -->
        <!-- <====================== -->
    </div>

</div>
<!-- main area ended here -->
<!-- ================================================================================================================================-->
<!-- footer started -->
<br>
<div class="footer" style="background: black;color: grey;text-decoration: none;opacity:.8; font-weight:bold;text-align: center;
height: 0px auto">
<span>Developed BY | Khole Rohit | &copy;2018-2023 --All right reserved.</span><br>
<span>This site is for study purose only</span>
</div>


</body>
</html>
