<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>

<?php
  if(isset($_POST["submit"]))
  {
    $uname=mysqli_real_escape_string($conn,$_POST["uname"]);
    $email = mysqli_real_escape_string($conn,$_POST["email"]);
    $comment = mysqli_real_escape_string($conn,$_POST["comment"]);
    $currentTime=time();
    $dateTime=strftime("%d-%B-%Y : %H:%M:%S",$currentTime);
    $dateTime;   
    $postid = @$_GET["id"];
    if(empty($uname) || empty($email) || empty($comment))
    {
      // echo "it's empty";   
      $_SESSION["ErrorMessage"]="All fields must be filled out";
      // header("Location:fullpost.php");
      // exit;
    }
    elseif(strlen($uname)>20 || strlen($comment)>500)   
    {
      $_SESSION["ErrorMessage"]="Name/comment  is too long";
      // header("Location:fullpost.php");
      // exit;
    }
    else
    {
      global $conn;
      $searchid = $_GET["id"];

      $query = "INSERT INTO comments(datetime,uname,email,comment,approvedby,status,admin_panel_id) 
        VALUES('$dateTime','$uname','$email','$comment','pending','OFF', '$searchid')";
      $execute = mysqli_query($conn,$query) or die('Error');

      if($execute){
        $_SESSION["SuccessMessage"] = " Comment added successfully...";
        header("Location:fullpost.php?id={$postid}");
        exit;
      }
      else{
        $_SESSION["ErrorMessage"] = "Something went wrong...";
        header("Location:fullpost.php?id={$postid}");
        exit;
      }

    }

  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>fullpost Post</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/publicstyle.css">
  <style>
    .col-sm-8{
      background-color: lightgrey;
      opacity: ;
    }
    .col-sm-3{
      background-color: mediumSeaGreen;
      opacity: .9;
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
      <li class="nav-item active">
        <a class="nav-link" href="Blog.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="Blog.php">Blog <span class="sr-only">(current)</span></a>
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
  </div> Me
</nav>
<!-- navbar ended -->
<!-- ================================================================================================================================-->
<!-- main area started -->
<div class="container">

    <div class="blog-header">
        <h1>The</h1>
        <h1> Welcome in My Blog...!</h1>

        <p class="">This blog is created by Khole Rohan for study and Practice....  </p>
    </div>

    <div class="row">
        <div class="col-sm-8">
          <h2>Right8  </h2>
          <?php
          echo Message();
          echo SuccessMessage();
          ?>
          <?php 

          global $conn;
          if(isset($_GET["search_button"]))  
          {
            $search = mysqli_real_escape_string($conn, $_GET["search"]);
            $query = "SELECT * FROM admin_panel WHERE datetime LIKE '%$search%' OR category LIKE '%$search%'  OR post LIKE '%$search%'";

          }
          else{
            $post_id = @$_GET["id"];    
            $query = "SELECT * FROM admin_panel WHERE id='$post_id' ORDER BY datetime desc";
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
            <img class="img-responsive img-fluid" src="upload/<?php echo $image ;?>"> 
            <div class="caption">
                <h1 id="heading"><?php echo htmlentities($title) ;?></h1>
                <p class="description">Category:<?php echo htmlentities($categoryname) ;?> Published on 
                <?php echo htmlentities($dateTime);?>  
                </p>

                <p class="post">
                <?php 
                echo nl2br($post) ;?>
                </p>
            </div>
          </div>
         <?php } ?>

         <br><br>
         <br><br>


            <div>
              <span class="fieldinfo">Comments...</span><br><br>
              <?php 

                global $conn;
                $pid = @$_GET["id"];

                $query = "SELECT * FROM comments WHERE admin_panel_id='$pid' AND status='ON'";  
                $execute = mysqli_query($conn,$query) or die('Error');

                while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
                {     

                $id = $row["id"];
                $dateTime = $row["datetime"];
                $uname = $row["uname"];
                $comment = $row["comment"];
                ?>
                <div class="cblog">
                  <img style=" float: left; margin-left: 10px; margin-top: 10px" class="pull-left" src="#" width="60px" height="50px">
                  <p style="margin-left: 90px;" class="description"><?php echo  htmlentities($dateTime) ;?></p>
                  <p style="margin-left: 90px;" class="comment-info"><?php echo  htmlentities($uname) ;?></p>
                  <p style="margin-left: 90px;"><?php echo  nl2br($comment) ;?></p>
                </div>
                <br><hr>  
                <?php } ;?>

              <span class="fieldinfo">Add your Comment</span>
              <form action="fullpost.php?id=<?php echo @$post_id ;?>" method="POST"  enctype="multipart/form-data">
                <fieldset>
                <div class="form-group"> 
                  <label class="fieldinform" for="uname">Name:</label>
                  <input class="form-control" type="text" name="uname"  placeholder="Name">
                </div>
                <div class="form-group"> 
                  <label class="fieldinform" for="email">Email:</label>
                  <input class="form-control" type="text" name="email"  placeholder="Email">
                </div>         
                <div class="form-group"> 
                  <label class="fieldinform" for="post_area">Comment:</label>
                  <textarea class="form-control" name="comment" ></textarea> 
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="submit">
                </fieldset> 
              </form>
            </div><br>


        </div>  

        <!-- right bar endede -->
        <!-- ============================== -->
        <div class="col-sm-1">   
        </div>
        <div class=" col-sm-3">
          <h2>left3</h2>
          <br>
          <div class="panel-group ">
          <div class="panel panel-primary cblog">
              <div class="heading">
                <h2 id="heading3" class="title"><center>Categories</center></h2>
              </div> 
              <div class="panel-body">
              <?php 
                global $conn;
              
          $query = "SELECT * FROM category ORDER BY datetime desc";
          $execute = mysqli_query($conn,$query) or die('Error');

          while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
          {     

          $id = $row["id"];
          $categoryname = $row["name"];
          
          ?>

          <a class="left3_1" href="Blog.php?category=<?php echo $categoryname ?>">
          <span ><?php  echo "<hr><center><em>".$categoryname."<em><center>" ;?></span>
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
              
          $query = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
          $execute = mysqli_query($conn,$query) or die('Error');

          while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
          {     

          $id = $row["id"];
          $title = ucwords($row["title"]);
          $dateTime = $row["datetime"];
          $image = $row["image"];
          ?>
          <hr>
          <div>
          <img style="float: left; width: 70px; height: 70px;" src="upload/<?php echo $image;?>">
            <a href="fullpost.php?id=<?php echo $id ;?>">
              <p id="big_title" class="left3_1 " style="margin-left: 90px "><?php echo htmlentities($title) ;?></p>
           
            <p id="" class="left3_1" style="margin-left: 90px "><?php if(strlen($dateTime) > 11){ $dateTime = substr($dateTime, 0, 11) ;} echo htmlentities($dateTime) ;?>
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
