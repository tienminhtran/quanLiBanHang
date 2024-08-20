<?php
	include_once("connect.php");
	$ten = $mk = $q="";
	if(isset($_POST["sbDangKy"]))
	{
		$ten = $_POST["uname"];
		$mk = md5($_POST["pswd"]);
		//$q = $_POST["slQuyen"];
		$q="2";
	}
	$sql = "INSERT INTO accounts(Username, Pass, RoleID) values('$ten','$mk','$q')";
	
	if($conn->query($sql)===TRUE)
	{
		header("Location:login.php");
	}
	else
	{
		echo "Lỗi truy vấn: ".$sql."<br>".$conn->error;
	}
?>