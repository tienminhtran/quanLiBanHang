<?php
	//1- Kết nối cơ sở dữ liệu
	include_once("connect.php");
	
	//2-Lấy dữ liệu từ form
	$madm = $ten = $mota = "";
	if(!empty($_POST["txtTen"])&&!empty($_POST["txtMoTa"]))
	{
			$madm = $_POST["txtMa"];
			$ten = $_POST["txtTen"];
			$mota = $_POST["txtMoTa"];
	}
	
	//3-Viết câu truy vấn cập nhật dữ liệu - UPDATE
	$sql = "UPDATE categories SET Name = '$ten', Description = '$mota' WHERE CategoryID = '$madm'";
	
	//4- Thực thi câu truy vấn và kiểm tra kết quả
	if($conn->query($sql)===TRUE)
	{
		//echo "Thành công rồi";
		header("Location:danhmuc.php");
	}
	else
	{
		echo "Lỗi câu truy vấn ".$sql."<br>".$conn->error;
	}
	
	//5- Đóng kết nối
	$conn->close();
?>