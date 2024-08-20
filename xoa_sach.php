<?php
	//1-Lấy biến trên URL sử dụng $_GET
	$masach = "";
	if(isset($_GET["ma"]))
	{
		$masach = $_GET["ma"];
	}
	//2-Kết nối cơ sở dữ liệu
	include_once("connect.php");
	
	//Viết câu truy vấn
	$sql = "DELETE FROM books WHERE ISBN = '$masach'";
	
	//4-Thực thi câu truy vấn và kiểm tra kết quả
	if ($conn->query($sql) === TRUE) 
	{
	  header("Location:sach.php");
	} 
	else 
	{
	  echo "Lỗi câu truy vấn: " .$sql."<br>". $conn->error;
	}
	//5-Đóng kết nối
	$conn->close();
?>