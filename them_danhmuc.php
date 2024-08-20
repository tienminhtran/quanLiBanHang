<?php
	include_once("qt_phandau.php");
?>
<!--Thiết kế form thêm mới một danh mục - Categories-->
<div class = "row">
	<div class = "col-sm-2">&nbsp;</div>
	<div class = "col-sm-8">
		<fieldset>
			<legend>Thêm một danh mục mới</legend>
			<form name = "frmThemDM" action = "xuly_themdanhmuc.php" method = "post">
				<!--<div class="mb-3 mt-3">
					<label for="txtMa" class="form-label">Nhập mã danh mục:</label>
					<input type="text" class="form-control" id="txtMa" 
						placeholder="Nhập mã danh mục mới" name="txtMa">
				</div>
				-->
				<div class="mb-3 mt-3">
					<label for="txtTen" class="form-label">Nhập tên danh mục:</label>
					<input type="text" class="form-control" id="txtTen" 
						placeholder="Nhập tên danh mục mới" name="txtTen">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtMoTa" class="form-label">Nhập mô tả:</label>
					<textarea class="form-control"  name = "txtMoTa" id = "txtMoTa" cols = "50" rows = "3"></textarea>
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