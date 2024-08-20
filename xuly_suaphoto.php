<?php
	//1- kết nối cơ sở dữ liệu
	include_once("connect.php");
	
	//Lấy dữ liệu từ form
	$id=$file="";
	if(isset($_POST["sbSua"]))
	{
		$id = $_POST["txtPhotoID"];
		
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
				$sql = "UPDATE photos SET Names = '$file'
						WHERE PhotoID = '$id'";
				
			  } else {
				echo "Sorry, there was an error uploading your file.";
			  }
			}
		}
		
		//Thực thi câu truy vấn
		if($conn->query($sql)===TRUE)
		{
			echo "Thành công";
			header("Location:photos.php");
		}
		else
			echo "Lỗi ".$sql."<br>".$conn->error;
	}
	

?>