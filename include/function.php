	<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>

<?php 
	
	function Redirect_to($new_site)
	{
		header("location:".$new_site);
		exit;
	}

	function login_admin($username, $password)
	{
		global $conn;
		$password = md5($password);
		$query = "SELECT * FROM registration WHERE username='$username' AND password='$password'" ;
		$execute = mysqli_query($conn,$query) or die('Error');
		if($admin=mysqli_fetch_assoc($execute))
		{
			return $admin;
		}
	}

	function login_required()
	{
		if(isset($_SESSION["user_id"]))
		{
			
			return true;
		}
		else
		{
			return false;
		}
	}

	function login_confirm()
	{
		if(!login_required())
		{
			$_SESSION["ErrorMessage"] = "Login required...!";
			Redirect_to("loginn.php");
		}
	}
?>