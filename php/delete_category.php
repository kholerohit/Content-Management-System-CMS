<?php require_once("include/db.php"); ?>
<?php require_once("include/session.php"); ?>
<?php require_once("include/function.php"); ?>
<?php login_confirm() ;?> 

<?php 

if (isset($_GET["id"]))
{
	global $conn;
	$idfromurl = $_GET["id"];
	$query = "DELETE FROM category WHERE id='$idfromurl'";
	$execute = mysqli_query($conn,$query) or die('Error');
			
	if($execute)
	{
		$_SESSION["SuccessMessage"] = " Category deleted successfully...";
		header("Location:categories.php");
		exit;
	}
	else
	{
		$_SESSION["ErrorMessage"] = "Something went wrong...Try again";
		header("Location:categories.php");
		exit;
	}
}
;?>


