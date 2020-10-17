<?php
	//date_dafault_timezone_set("Asia/Delhi");
	$currentTime=time();
	$dateTime=strftime("%B-%d-%Y : %H:%M:%S",$currentTime);
	echo $dateTime;
?>