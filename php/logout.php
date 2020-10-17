<?php require_once("include/session.php"); ?>
<?php require_once("include/function.php"); ?>
<?php 

	$_SESSION["user_id"] = null;
	session_destroy();
	Redirect_to("loginn.php");

?>