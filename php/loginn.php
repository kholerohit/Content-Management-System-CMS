	<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/function.php"); ?>


<?php
	if(isset($_POST["submit"]))
	{
		// $category=$_POST["category"];
		$username = mysqli_real_escape_string($conn,$_POST["username"]);
		$password = mysqli_real_escape_string($conn,$_POST["password"]);
		
		if(empty($username) || empty($password))
		{
			// echo "it's empty";		
			$_SESSION["ErrorMessage"]="All fields must be filled out";
			header("Location:loginn.php");
			exit;
		}
		else
		{ 
			$login_success = login_admin($username, $password);
			// function call 
			$_SESSION["user_id"] = $login_success["id"];
			$_SESSION["Username"] = $login_success["username"];

			if($login_success)
			{
				$_SESSION["SuccessMessage"] = "Welcome ".ucwords($_SESSION["Username"]).'...!';
				header("Location:dashboard.php");
				exit;
			}
			else
			{
				$_SESSION["ErrorMessage"] = "Invalid username/Password";
				header("Location:loginn.php");
				exit;
			}
		}

	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/dashboardstyle.css">
	<link rel="stylesheet" type="text/css" href="css/publicstyle.css">
</head>
<style type="text/css">
body{
	background-color: ;
	/*background-image: url("image/");*/
}
</style>
<body>

 <!-- Navbar starting -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
</nav>
<!-- navbar ended -->
	
<div class="container-fluid">

	<div class="row">
		<div class="col-sm-4">
		</div>

		<div class="col-sm-4">
			<br><br><br><br>
			<h1 >Welcome...!</h1>
			
				<?php
					// echo "it is empty field";
					echo Message();
					echo SuccessMessage();
			http://127.0.0.1/Astarted/cms_php/fullpost.php?id=12	 ?>

			<div>
				<form action="loginn.php" method="POST">
					<fieldset>
					<div class="form-group"> 
						<label class="fieldinform" for="username">Username:</label>
						<input class="form-control" type="text" name="username" id="username" placeholder="username">
					</div>
					<div class="form-group"> 
						<label class="fieldinform" for="password">Password</label>
						<input class="form-control" type="password" name="password" id="password" placeholder="password">
					</div><br>
					<input class="btn btn-success btn-block" type="submit" name="submit" value="Login">
					</fieldset>	
				</form>
			</div>

		</div> <!-- ending of main area -->		

 	</div><!-- ending of main row -->
</div><!-- ending of main container -->

</div>
</html>
	