<?php
	//1 - Lấy biến từ
	$ten = $mota = "";
	if(!empty($_POST["txtTen"])&&!empty($_POST["txtMoTa"]))
	{
		$ten = $_POST["txtTen"];
		$mota = $_POST["txtMoTa"];
	}
	
	//2 - Kết nối csdl
	include_once("connect.php");
	
	//3 - Viết câu truy vấn
	$sql = "INSERT INTO categories(Name,Description)values('$ten','$mota')";
	
	//4 - Thực thi và kiểm tra kết quả
	if($conn->query($sql)===TRUE)
	{
		//Điều hướng về trang danhmuc.php
		header("Location:danhmuc.php");
	}
	else
	{
		echo "Lỗi câu truy vấn: ".$sql."<br>".$conn->error;
	}

	//5 - Đóng kết nối
	$conn->close();
?>