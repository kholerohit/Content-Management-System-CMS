<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/function.php"); ?>
<?php login_confirm() ;?> 

<?php
	if(isset($_POST["submit"]))
	{
		// $category=$_POST["category"];
		$username = mysqli_real_escape_string($conn,$_POST["username"]);
		$password = mysqli_real_escape_string($conn,$_POST["password"]);
		$re_password = mysqli_real_escape_string($conn,$_POST["re_password"]);
		$hashedPasswrdInDb = md5($password);

		$currentTime=time();
		$dateTime=strftime("%B-%d-%Y : %H:%M:%S",$currentTime);
		$dateTime;
		$admin = ucwords($_SESSION["Username"]);
		if(empty($username) || empty($password) || empty(re_password))
		{
			// echo "it's empty";		
			$_SESSION["ErrorMessage"]="All fields must be filled out";
			header("Location:admin.php");
			exit;
		}
		elseif(strlen($password)<8)
		{
			$_SESSION["ErrorMessage"]="password should atleast 8 chars";
			header("Location:admin.php");
			exit;
		}
		elseif($password != $re_password)
		{
			$_SESSION["ErrorMessage"]="password didn't match";
			header("Location:admin.php");
			exit;
		}
		else
		{ 
			global $conn;
			$query = "INSERT INTO registration(datetime,username,password,addedby) 
				VALUES('$dateTime','$username','$hashedPasswrdInDb','$admin')";
			$execute = mysqli_query($conn,$query) or die('Error');

			if($execute){
				$_SESSION["SuccessMessage"] = " Admin  added successfully";
				header("Location:admin.php");
				exit;
			}
			else{
				$_SESSION["ErrorMessage"] = "Something went wrong.. try again";
				header("Location:admin.php");
				exit;
			}

		}

	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Admin Access </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/dashboardstyle.css">
	<link rel="stylesheet" type="text/css" href="css/publicstyle.css">
</head>
<style type="text/css">
	body{
		background-color: #003333;
	}
</style>
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
		<h1 class="sidebar-brand">The<br><?php echo ucwords($_SESSION["Username"]) ;?></h1>	
						<div class="sidebar-nav">
						  <nav class="sidebar-nav">
						    <ul class="">
						      <li class="nav-item btn ">
						        <a class="nav-link nav-link-success btn btn-outline-success" href="dashboard.php">
						          <i class=""></i> Dashboard
						        </a>	
						      </li>
						      <li class="nav-item btn ">
						        <a class="nav-link btn btn-outline-success" href="addNewPost.php">
						          <i class="nav-icon cui-speedometer"></i> Add New Post
						          <span class="badge badge-primary">NEW</span>
						        </a>
						      </li>
						      <li class="nav-item nav-itemdropdown btn btn-outline-suc">
						        <a class="nav-link nav-dropdown-toggle btn btn-outline-success" href="categories.php">
						          <i class="nav-icon cui-puzzle"></i> Categories
						        </a>
						      </li>
						      <li class="nav-item mt-auto btn ">
						        <a class="nav-link  btn btn-primary" href="admin.php">
						          <i class="nav-icon cui-cloud-download"></i>Manage Admin</a>
						      </li>
						      <li class="nav-item mt-auto btn">
						        <a class="nav-link btn btn-outline-success" href="Blog.php" target="_blank">
						          <i class="nav-icon cui-cloud-download"></i>Live Blog</a>
						      </li>
						      <li class="nav-item btn">
						        <a class="nav-link btn btn-outline-success" href="mcomments.php">
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
						      <li class="nav-item btn">
						        <a class="nav-link  btn btn-outline-success" href="logout.php">
						          <i class="nav-icon cui-cloud-download"></i>Logout &nbsp</a>
						      </li>
						      
						    </ul>
						  </nav>
						</div>	
			
		</div> <!-- ending of side bar -->

		<div class="col-sm-10">
			<h1>Manage Admin access</h1>
			
				<?php
					// echo "it is empty field";
					echo Message();
					echo SuccessMessage();
				 ?>

			<div>
				<form action="admin.php" method="POST">
					<fieldset>
					<div class="form-group"> 
						<label class="fieldinform" for="username">Username:</label>
						<input class="form-control" type="text" name="username" id="username" placeholder="username">
					</div>
					<div class="form-group"> 
						<label class="fieldinform" for="password">Password</label>
						<input class="form-control" type="password" name="password" id="password" placeholder="password">
					</div>
					<div class="form-group"> 
						<label class="fieldinform"  for="re_password">Confirm Password</label>
						<input class="form-control" type="password" name="re_password" id="re_password" placeholder="Confirm password">
					</div>
					<input class="btn btn-primary" type="submit" name="submit" value="Add New Admin">
					</fieldset>	
				</form>
			</div>
			<br>
			<div class="table-responsive ">
				<table class="table table-striped table-hover">
					<tr>
						<th class="tht">Sr. No.</th>
						<th class="tht">Date & Time</th>
						<th class="tht">Admin Name </th>
						<th class="tht">Added BY</th>
						<th class="tht"> Action</th>
					</tr>
				<?php
				global $conn;
				$query = "SELECT * FROM registration ORDER BY datetime DESC";
				$execute = mysqli_query($conn,$query) or die('Error');
				$sr_no = 0;

				while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
				{			

				$id = $row["id"];
				$dateTime = $row["datetime"];
				$username = $row["username"];
				$admin = $row["addedby"];
				$sr_no++;
				?>
				<tr>
					<td><?php echo $sr_no; ?></td>
					<td><?php echo $dateTime; ?></td>
					<td><?php echo $username; ?></td>
					<td><?php echo $admin; ?></td>
					<td><a href="admin_delete.php?id=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a></td>
				</tr>
				<?php } ?>
				</table>
			</div>
			

		</div> <!-- ending of main area -->					
 	</div><!-- ending of main row -->
</div><!-- ending of main container -->

<br>
<div class="footer" style="background: black;color: grey;text-decoration: none; opacity: .8; font-weight:bold;text-align: center;
height: 0px auto">
<span>Developed BY | Khole Rohit | &copy;2018-2023 --All right reserved.</span><br>
<span>This site is for study purose only</span>
</div>

</body>
</html>
