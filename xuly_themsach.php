<?php
	//1-Kết nối cơ sở dữ liệu
	include_once("connect.php");
	
	$target_dir = "images/";
	$target_file = $target_dir . basename($_FILES["fileHinh"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	//2-Lấy dữ liệu từ form
	$dm = $mota = $gia =$tacgia = $isbn = $ten=$sl=$file="";
	if(!empty($_POST["txtISBN"])
		&&!empty($_POST["slDanhMuc"])
		&&!empty($_POST["txtTen"])
		&&!empty($_POST["txtTacGia"])
		&&!empty($_POST["txtGia"])
		&&!empty($_POST["txtMoTa"])
	)
	{
		$dm = $_POST["slDanhMuc"];
		$mota = $_POST["txtMoTa"];
		$gia =$_POST["txtGia"];
		$tacgia = $_POST["txtTacGia"];
		$isbn = $_POST["txtISBN"];
		$ten=$_POST["txtTen"];
		$sl=$_POST["txtSoluong"];
	}
	
	$check = getimagesize($_FILES["fileHinh"]["tmp_name"]);
	if($check !== false) {
		
		$uploadOk = 1;
	} else {
		
		$uploadOk = 0;
	}
	
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	  $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	  echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} 
	else 
	{
	  if (move_uploaded_file($_FILES["fileHinh"]["tmp_name"], $target_file)) 
	  {
		
		echo "The file ". htmlspecialchars( basename( $_FILES["fileHinh"]["name"])). " has been uploaded.";
		$file = $_FILES["fileHinh"]["name"];
		
	  } else {
		echo "Sorry, there was an error uploading your file.";
	  }
	}


	//3-Viết câu truy vấn
	$sql = "INSERT INTO books(ISBN,Author,Title,Price,Description,CategoryID, Picture, Soluong)VALUES('$isbn','$tacgia','$ten','$gia','$mota','$dm','$file','$sl')";
	echo $sql;
	//4-Thực thi câu truy vấn và kiểm tra kết quả
	if($conn->query($sql)===TRUE)
	{
		header("Location:sach.php");
	}
	else
	{
		echo "Lỗi câu truy vấn: ".$sql."<br>".$conn->error;
	}
	
?>