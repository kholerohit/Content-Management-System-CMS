<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/function.php"); ?>
<?php login_confirm() ;?> 

<?php 

	if (isset($_GET["id"])) 
	{
		global $conn;
		$idfromurl = $_GET["id"];
		$admin = $_SESSION["Username"];

		$query = "UPDATE comments SET status='ON', approvedby='$admin' WHERE id='$idfromurl'";
		$execute = mysqli_query($conn,$query) or die('Error');

		if($execute)
		{
			// echo "it's empty";		
			$_SESSION["SuccessMessage"]="comment approved successfully...";
			header("Location:mcomments.php");
			exit;
		}
		else
		{
			$_SESSION["ErrorMessage"]="Something went wrong ..Try again...";
			header("Location:mcomments.php");
			exit;
		}



	}

;?>