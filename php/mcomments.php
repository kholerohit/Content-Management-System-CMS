<?php require_once("include/session.php"); ?>
<?php require_once("include/db.php"); ?>
<?php require_once("include/function.php"); ?>
<?php login_confirm() ;?> 

<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
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
						      <li class="nav-item mt-auto btn">
						        <a class="nav-link  btn btn-outline-success" href="admin.php">
						          <i class="nav-icon cui-cloud-download"></i>Manage Admin</a>
						      </li>
						      <li class="nav-item mt-auto btn">
						        <a class="nav-link btn btn-outline-success" href="Blog.php" target="_blank">
						          <i class="nav-icon cui-cloud-download"></i>Live Blog</a>
						      </li>
						      <li class="nav-item btn">
						        <a class="nav-link btn btn-primary" href="mcomments.php">
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
			<h1>Un-approved Comments</h1>
			<div>
				<?php
					echo Message();
					echo SuccessMessage();
				 ?>
			</div>
			<div class="table-responsive ">
				<table class="table table-striped table-hover">
					<tr>
						<th class="tht">no.</th>
						<th class="tht">Name</th>
						<th class="tht">Date</th>
						<th class="tht">Comment</th>
						<th class="tht">Approve</th>
						<th class="tht">Delete</th>
						<th class="tht">Live Preview</th>
					</tr>
					<?php   
					global $conn;
					$srn = 0;
					$query = "SELECT * FROM comments WHERE status='OFF' ORDER BY datetime desc"; 
					$execute = mysqli_query($conn,$query) or die('Error');
					while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
			          {     

			          $id = $row["id"];
			          $dateTime = $row["datetime"];
			          $uname = $row["uname"];
			          $comment = $row["comment"];
			          $admin_panel_id = $row["admin_panel_id"];
			          $srn++;
			          ?>
			        <tr>
						<td><?php echo $srn; ?></td>
						<td><?php if(strlen($uname)>18){$uname=substr($uname, 0, 18).'...';} echo $uname; ?></td>
						<td><?php if(strlen($dateTime)>12){$dateTime=substr($dateTime, 0, 12);} echo $dateTime; ?></td>

						<td><?php if(strlen($comment)>18){$comment=substr($comment, 0, 18).'...';} echo $comment; ?></td>

						<td>
							<a href="approvecmt.php?id=<?php echo $id ;?>"><span class="btn btn-success">Approve</span></a>
						</td>
						<td>
							<a href="deletecmt.php?id=<?php echo $id ;?>"><span class="btn btn-danger">Delete</span></a>
						</td>
						<td>
							<a href="fullpost.php?id=<?php echo $admin_panel_id ;?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
						</td>
					</tr>
				<?php } ?>

				</table>
			</div>

			<h1>Approved Comments</h1>
			<div class="table-responsive ">
				<table class="table table-striped table-hover">
					<tr>
						<th class="tht">no.</th>
						<th class="tht">Name</th>
						<th class="tht">Date</th>
						<th class="tht">Comment</th>
						<th class="tht">Approved By</th>
						<th class="tht">Revert Approve</th>
						<th class="tht">Delete</th>
						<th class="tht">Live Preview</th>
					</tr>
					<?php   
					global $conn;
					// $admin = "Khole Rohan";
					$srn = 0;
					$query = "SELECT * FROM comments WHERE status='ON' ORDER BY datetime desc"; 
					$execute = mysqli_query($conn,$query) or die('Error');
					while($row=mysqli_fetch_array($execute,MYSQLI_ASSOC))
			          {     

			          $id = $row["id"];
			          $dateTime = $row["datetime"];
			          $uname = $row["uname"];
			          $comment = $row["comment"];
			          $approvedby = $row["approvedby"];

			          $admin_panel_id = $row["admin_panel_id"];
			          $srn++;
			          ?>
			        <tr>
						<td><?php  echo htmlentities($srn); ?></td>
						<td><?php if(strlen($uname)>18){$uname=substr($uname, 0, 18).'...';} echo htmlentities($uname); ?></td>
						<td><?php if(strlen($dateTime)>12){$dateTime=substr($dateTime, 0, 12);} echo htmlentities($dateTime); ?></td>

						<td><?php if(strlen($comment)>60){$comment=substr($comment, 0, 60).'...';} echo htmlentities($comment); ?></td>
						<td><?php if(strlen($approvedby)>60){$approvedby=substr($approvedby, 0, 60).'...';} echo htmlentities($approvedby); ?></td>
 
						<td>
							<a href="dis_approvecmt.php?id=<?php echo $id ;?>"><span class="btn btn-warning">Dis-approve</span></a>
						</td>
						<td>
							<a href="deletecmt.php?id=<?php echo $id ;?>"><span class="btn btn-danger">Delete</span></a>
						</td>
						<td>
							<a href="fullpost.php?id=<?php echo $admin_panel_id ;?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
						</td>
					</tr>
				<?php } ?>

				</table>
			</div>
			
			
		</div> <!-- ending of main area -->					
 	</div><!-- ending of main row -->
</div><!-- ending of main container -->

<br>
<div class="footer" style="background: black;color: grey; opacity: .7; text-decoration: none;font-weight:bold;text-align: center;
height: 0px auto">
<span>Developed BY | Khole Rohit | &copy;2018-2023 --All right reserved.</span><br>
<span>This site is for study purose only</span>
</div>


</body>
</html>