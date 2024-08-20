<?php
	session_start();
	include_once("connect.php");
	//Lấy dữ liệu từ form
	$ten = $mk = "";
	if(isset($_POST["sbDangNhap"]))
	{
		$ten =$_POST["uname"];
		$mk = md5($_POST["pswd"]);
		
	}
	
	//Kiểm tra có trong bảng accounts không
	$sql = "SELECT *FROM accounts WHERE Username = '$ten' AND Pass = '$mk'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	//Nếu có điều hướng vào trang phù hợp - Ví dụ đối với tài khoản quản trị thì vào trang quản trị
	if($result->num_rows>0)
	{
		$_SESSION["Name"]=$ten;
		$_SESSION["Role"]=$row["RoleID"];
		$_SESSION["Account"]=$row["AccountID"];
		header("Location:quantri.php");
	}
	else
	{
		header("Location:login.php");		
	}
	
?>