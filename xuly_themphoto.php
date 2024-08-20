<?php
	include_once("connect.php");
	//1 - Nhận mã ISBN được gửi từ liên kết
	$isbn = $file = "";
	$isbn = $_POST["txtISBN"];
	$target_dir = "images/";
	$target_file = $target_dir . basename($_FILES["fileHinh"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	if(isset($_POST["sbThem"])) 
	{
		$check = getimagesize($_FILES["fileHinh"]["tmp_name"]);
		if($check !== false) 
		{
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} 
		else 
		{
			echo "File is not an image.";
			$uploadOk = 0;
		  }
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) 
		{
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} 
		else 
		{
			if (move_uploaded_file($_FILES["fileHinh"]["tmp_name"], $target_file)) {
				echo "The file ". htmlspecialchars( basename( $_FILES["fileHinh"]["name"])). " has been uploaded.";
				$file = $_FILES["fileHinh"]["name"];
				$sql = "Insert into Photos(Names, ISBN)values('$file','$isbn')";
				echo $sql;
				if($conn->query($sql)===TRUE)
				{
					echo "Thành công!";
					header("Location:photos.php");
				}
			} 
			else 
			{
				echo "Sorry, there was an error uploading your file.";
			}
		}
?>
	