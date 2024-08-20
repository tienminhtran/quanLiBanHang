<?php
	//1-Lấy biến trên URL sử dụng $_GET
	$madm = "";
	if(isset($_GET["ma"]))
	{
		$madm = $_GET["ma"];
	}
	
	//2-Kết nối cơ sở dữ liệu
	include_once("connect.php");
	
	//Viết câu truy vấn
	$sql = "DELETE FROM categories WHERE CategoryID = '$madm'";
	
	//4-Thực thi câu truy vấn và kiểm tra kết quả
	if ($conn->query($sql) === TRUE) 
	{
	  header("Location:danhmuc.php");
	} 
	else 
	{
	  echo "Lỗi câu truy vấn: " .$sql."<br>". $conn->error;
	}
	//5-Đóng kết nối
	$conn->close();
?>