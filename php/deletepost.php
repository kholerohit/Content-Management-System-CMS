<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/function.php"); ?>
<?php login_confirm() ;?> 

<?php
	if(isset($_POST["submit"]))
	{
		$Title=$_POST["Title"];
		$Category = mysqli_real_escape_string($conn,$_POST["Category"]);
		$Post = $_POST["Post"];
		$currentTime=time();
		$dateTime=strftime("%d-%B-%Y : %H:%M:%S",$currentTime);
		$dateTime;
		$admin = $_SESSION["Username"];
		$Image=$_FILES["Image"]["name"];   
		$Target="upload/".basename($_FILES["Image"]["name"]);       	
		if(empty($Title) || empty($Post))
		{
			// echo "it's empty";		
			$_SESSION["ErrorMessage"]="can't delete ";
			header("Location:dashboard.php");
			exit;
		}
		elseif(strlen($Title)<3)	
		{
			$_SESSION["ErrorMessage"]="can't delete";
			header("Location:dashboard.php");
			exit;
		}
		else
		{
			global $conn;
			$deleteid = @$_GET['delete'];
			$query = "DELETE FROM admin_panel WHERE id='$deleteid'";
			$execute = mysqli_query($conn,$query) or die('Error');
			move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
			if($execute){
				$_SESSION["SuccessMessage"] = " Post deleted successfully...";
				header("Location:dashboard.php");
				exit;
			}
			else{
				$_SESSION["ErrorMessage"] = "Post not deleted try again...";
				header("Location:dashboard.php");
				exit;
			}

		}

	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete Post</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/dashboardstyle.css">
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
<div class="container-fluid">
	<div class="row">

		<div class="col-sm-2">
		<h1 class="sidebar-brand">The<br>Khole Rohit</h1>	
						<div class="sidebar-nav">
						  <nav class="sidebar-nav">
						    <ul class="">
						      <li class="nav-item">
						        <a class="nav-link" href="dashboard.php">
						          <i class=""></i> Dashboard
						        </a>	
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="addNewPost.php">
						          <i class="nav-icon cui-speedometer"></i> Add New Post
						          <span class="badge badge-primary">NEW</span>
						        </a>
						      </li>
						      <li class="nav-item nav-dropdown">
						        <a class="nav-link nav-dropdown-toggle" href="categories.php">
						          <i class="nav-icon cui-puzzle"></i> Categories
						        </a>
						      </li>
						      <li class="nav-item mt-auto">
						        <a class="nav-link nav-link-success" href="admin.php">
						          <i class="nav-icon cui-cloud-download"></i>Manage Admin</a>
						      </li>
						      <li class="nav-item mt-auto">
						        <a class="nav-link nav-link-success" href="Blog.php">
						          <i class="nav-icon cui-cloud-download"></i>Live Blog</a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link nav-link-danger" href="mcomments.php">
						          <i class="nav-icon cui-layers"></i>Comments
						          <strong></strong>
						          <td>
									<?php 
									global $conn;
									$query_total = "SELECT COUNT(*) FROM comments WHERE status='ON'";
									$execute_total = mysqli_query($conn, $query_total);
									$row_total = mysqli_fetch_array($execute_total, MYSQLI_ASSOC);	
									$total_total = array_shift($row_total);

									if($total_total > 0)
									{
									?>
										<span class="btn btn-success">
										<?php  echo $total_total ;?>
										</span>
									<?php } ;?>

									</td>
						        </a>
						      </li>
						      <li class="nav-item mt-auto">
						        <a class="nav-link nav-link-success" href="logout.php">
						          <i class="nav-icon cui-cloud-download"></i>Logout &nbsp</a>
						      </li>
						      
						    </ul>
						  </nav>
						</div>
			
		</div> <!-- ending of side bar -->

		<div class="col-sm-10">
			<h1>Delete Post</h1>
			
				<?php
					// echo "it is empty field";
					echo Message();
					echo SuccessMessage();
				 ?>

			<div>
				<?php 
					global $conn;
					$search = @$_GET['delete'];
					$query = "SELECT * FROM admin_panel 
					WHERE id='$search'";
					$execute = mysqli_query($conn,$query) or die('Error');
					while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
			        {     

			          $id = $row["id"];
			          $dateTime = $row["datetime"];
			          $title = $row["title"];
			          $category = $row["category"];
			          $admin = $row["auther"];
			          $image = $row["image"];
			          $post = $row["post"];
			      	}

			          ?>
				<form action="deletepost.php?delete=<?php echo $search;?>" method="POST"  enctype="multipart/form-data">
					<fieldset>
					<div class="form-group"> 
						<label for="title">Title:</label>
						<input value="<?php echo @$title ;?>"
						class="form-control" type="text" name="Title" id="title" placeholder="Title">
					</div>
					<div class="form-group"> 
						<label for="category_select">Category:</label>
						<select class="form-control" id="category_select" name="Category">
							<?php
							global $conn;
							$query = "SELECT * FROM category ORDER BY datetime desc";
							$execute = mysqli_query($conn,$query) or die('Error');
							// $sr_no = 0;

							while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
							{			

							$id = $row["id"];
							$categoryname = $row["name"];
							// $sr_no++;
							?>
							<option><?php echo $categoryname ;?></option>
							<?php } ;?>
						</select> 	
					</div>
					<div class="form-group"> 
						<label for="image_select">Select Image:</label>
						<input value="<?php echo $image ;?>" type="File" class="form-control" id="image_select" name="Image">
					</div>
					<div class="form-group"> 
						<label for="post_area">Post:</label>
						<textarea  class="form-control" name="Post" id="post_area"><?php echo @$post ;?></textarea> 
					</div>
					<input class="btn btn-danger" type="submit" name="submit" value="Delete Post">
					</fieldset>	
				</form>
			</div>
			<br>

			</div>
			

		</div> <!-- ending of main area -->					
 	</div><!-- ending of main row -->
</div><!-- ending of main container -->
<br>
<div class="footer" style="background: black;color: grey;opacity: .8; text-decoration: none;font-weight:bold;text-align: center;
height: 0px auto">
<span>Developed BY | Khole Rohit | &copy;2018-2023 --All right reserved.</span><br>
<span>This site is for study purose only</span>
</div>


</body>
</html>
