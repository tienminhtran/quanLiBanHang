<?php
	include_once("qt_phandau.php");
?>
<?php
//1 - Nhận mã ISBN được gửi từ liên kết
	$isbn = "";
	if(isset($_GET["ma"]))
	{
			$isbn = $_GET["ma"];
	}
		
?>
<!--Thiết kế form thêm mới một ảnh quyển sách - photos-->
<div class = "row">
	<div class = "col-sm-2">&nbsp;</div>
	<div class = "col-sm-8">
		<fieldset>
			<legend>Thêm ảnh  mới</legend>
			<form name = "frmThemSach" action = "xuly_themphoto.php" method = "post" enctype="multipart/form-data">
				<div class="mb-3 mt-3">
					<label for="txtISBN" class="form-label">Nhập số ISBN:</label>
					<input value = "<?php echo $isbn;?>" readonly type="text" class="form-control" id="txtISBN" 
						placeholder="Nhập số ISBN" name="txtISBN" required>
				</div>
				<div class="mb-3 mt-3">
					<label for="fileHinh" class="form-label">Chọn ảnh mới:</label>
					<input type = "file" name = "fileHinh">
				</div>
				<input class = "btn btn-danger" type = "submit" name = "sbThem" value = "Thêm">
				<input class = "btn btn-danger" type = "reset" name = "sbHuy" value = "Hủy">
			</form>
		</fieldset>
	</div>
	<div class = "col-sm-2">&nbsp;</div>
</div>

<?php
	include_once("qt_phanchan.php");
?>