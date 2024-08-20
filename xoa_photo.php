<?php
	include_once("connect.php");
	$isbn = $_GET["ma"];
	$sql = "DELETE FROM photos WHERE PhotoID = '$isbn'";
	
	if($conn->query($sql)===TRUE)
	{
		header("Location:photos.php");
	}
	else
	{
		echo "Lỗi xóa file: ".$sql."<br>".$conn->error;
	}
?>