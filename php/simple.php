<!DOCTYPE html>
<html>
<head>
	<title>Simple</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script></script>
	<script ></script>
</head>
<body>
 
</body>
</html>
<div class="container-fluid">
	<div class="row">

		<div class="col-sm-2">
		<h1 class="sidebar-brand">The</h1>
<!-- 			<h4><?php echo $_SESSION["Username"] ;?><h4>	
 -->					<div class="sidebar">
						  <nav class="sidebar-nav">
						    <ul class="nav">
						      <li class="nav-item">
						        <a class="nav-link" href="dashboard.php">
						          <i class="nav-icon cui-speedometer"></i> Dashboard
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
						</div><!-- 
			<ul id="side_menu" class="">
				<li class="active"><a href="dashboard.php">Dashboard</a></li>
				<li><a href="addNewPost.php">Add new Posts</a></li>
				<li><a href="categories.php">Categaries</a></li>
				<li><a href="#.php">Manage Admin</a></li>
				<li><a href="#.php">Comments</a></li>
				<li><a href="#.php">Live Blogs</a></li>
				<li><a href="#.php">Log outs</a></li>

			</ul> -->
		</div> <!-- ending of side bar -->