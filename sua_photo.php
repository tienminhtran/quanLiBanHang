<?php
	include_once("qt_phandau.php");
?>
<?php
	//1 - Nhận mã ISBN được gửi từ liên kết
	$ma = "";
	if(isset($_GET["ma"]))
	{
			$ma = $_GET["ma"];
	}
	
	//2- Select dữ liệu từ bảng books với điều kiện ISBN = $isbn
	$sql = "SELECT*FROM photos WHERE PhotoID = '$ma'";
	
	$result = $conn->query($sql);
	
	$ma_val = $name_val="";
	
	$row = $result->fetch_assoc();
	$ma_val = $row["PhotoID"];
	$name_val = $row["Names"];
	
?>

<!--Thiết kế form thêm mới một quyển sách - books-->
<div class = "row">
	<div class = "col-sm-2">&nbsp;</div>
	<div class = "col-sm-8">
		<fieldset>
			<legend>Thay đổi ảnh</legend>
			<form name = "frmSuaSach" action = "xuly_suaphoto.php" method = "post" enctype="multipart/form-data">
				
				<div class="mb-3 mt-3">
					<label for="txtPhotoID" class="form-label">Photo ID</label>
					<input value ="<?php echo $ma_val ;?>" readonly type="text" class="form-control" id="txtPhotoID" 
						name="txtPhotoID" required>
				</div>
				
				
				<div class="mb-3 mt-3">
					<label>Ảnh hiện tại</label>
					<img src = "images/<?php echo $name_val;?>" alt = "" width = "50">
					<br>
					<label for="fileHinh" class="form-label">Chọn hình mới</label>
					<input required type = "file" name = "fileHinh">
				</div>
				<input class = "btn btn-danger" type = "submit" name = "sbSua" value = "Sửa">
				<input class = "btn btn-danger" type = "reset" name = "sbHuy" value = "Hủy">
			</form>
		</fieldset>
	</div>
	<div class = "col-sm-2">&nbsp;</div>
</div>

<?php
	include_once("qt_phanchan.php");
?>