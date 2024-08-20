<?php
	include_once("qt_phandau.php");
?>
<!--Thiết kế form thêm mới một danh mục - Categories-->
<div class = "row">
	<div class = "col-sm-2">&nbsp;</div>
	<div class = "col-sm-8">
		<fieldset>
			<legend>Thêm hình ảnh cho sách</legend>
			<form name = "frmThemHinh" action = "" method = "post" enctype="multipart/form-data">
				<div class="mb-3 mt-3">
					<label for="txtSach" class="form-label">ID quyển sách</label>
					<input type="text" class="form-control" id="txtSach" name="txtSach">
				</div>
				<div class="mb-3 mt-3">
					<label for="fileHinh" class="form-label">Chọn hình:</label>
					<input type="file" class="form-control" id="fileHinh" name="fileHinh">
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