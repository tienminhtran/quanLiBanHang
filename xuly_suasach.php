<?php
	//1- kết nối cơ sở dữ liệu
	include_once("connect.php");
	
	//Lấy dữ liệu từ form
	$dm = $mota = $gia =$tacgia = $isbn = $ten=$file=$sl="";
	if(isset($_POST["sbSua"]))
	{
		$dm = $_POST["slDanhMuc"];
		$mota = $_POST["txtMoTa"];
		$gia =$_POST["txtGia"];
		$tacgia = $_POST["txtTacGia"];
		$isbn = $_POST["txtISBN"];
		$ten=$_POST["txtTen"];
		$sl=$_POST["txtSoluong"];
		$sql = "UPDATE books SET CategoryID = '$dm', Price = '$gia', 
						Author = '$tacgia', Description = '$mota',
						Title = '$ten', Soluong = '$sl'
						WHERE ISBN = '$isbn'";
		if(isset($_FILES["fileHinh"]["name"])&&!empty($_FILES["fileHinh"]["name"]))
		{
			$file = $_FILES["fileHinh"]["name"];
			$target_dir = "images/";
			$target_file = $target_dir . basename($_FILES["fileHinh"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
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
				$sql = "UPDATE books SET CategoryID = '$dm', Price = '$gia', 
						Author = '$tacgia', Description = '$mota',
						Title = '$ten',
						Picture = '$file', Soluong = '$sl'
						WHERE ISBN = '$isbn'";
				
			  } else {
				echo "Sorry, there was an error uploading your file.";
			  }
			}
		}
		
		//Thực thi câu truy vấn
		if($conn->query($sql)===TRUE)
		{
			echo "Thành công";
			header("Location:sach.php");
		}
	}
	
?>