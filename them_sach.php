<?php
	include_once("qt_phandau.php");
?>
<!--Thiết kế form thêm mới một quyển sách - books-->
<div class = "row">
	<div class = "col-sm-2">&nbsp;</div>
	<div class = "col-sm-8">
		<fieldset>
			<legend>Thêm một quyển sách mới</legend>
			<form name = "frmThemSach" action = "xuly_themsach.php" method = "post" enctype="multipart/form-data">
				<div class="mb-3 mt-3">
					<label for="slDanhMuc" class="form-label">Chọn danh mục sách:</label>
					<select class="form-control"  name = "slDanhMuc">
						<?php
							
							
							//2- Viết câu truy vấn lấy dữ liệu từ bảng Categories
							$sql = "SELECT * FROM categories";
							
							//3-Thực thi câu truy vấn và hiển thị kết quả
							$result = $conn->query($sql);
							if($result->num_rows>0)
							{
								while($row = $result->fetch_assoc())
								{
									echo "<option value = '".$row["CategoryID"]."'>";
									echo $row["CategoryID"]. "-".$row["Name"];
									echo "</option>";
								}
							}
							else{
								
								echo "<option value =''>Chưa có danh mục sách</option>";
							}
						?>
					</select>
				</div>
				<div class="mb-3 mt-3">
					<label for="txtISBN" class="form-label">Nhập số ISBN:</label>
					<input type="text" class="form-control" id="txtISBN" 
						placeholder="Nhập số ISBN" name="txtISBN" required>
				</div>
				
				<div class="mb-3 mt-3">
					<label for="txtTen" class="form-label">Nhập tên sách:</label>
					<input type="text" class="form-control" id="txtTen" 
						placeholder="Nhập tên sách mới" name="txtTen">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtTacGia" class="form-label">Nhập thông tin tác giả:</label>
					<input type="text" class="form-control" id="txtTacGia" 
						placeholder="Nhập tác giả" name="txtTacGia">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtGia" class="form-label">Nhập đơn giá:</label>
					<input type="text" class="form-control" id="txtGia" 
						placeholder="Nhập đơn giá" name="txtGia">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtSoluong" class="form-label">Nhập số lượng:</label>
					<input type="text" class="form-control" id="txtSoluong" 
						placeholder="Nhập số lượng" name="txtSoluong">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtMoTa" class="form-label">Nhập mô tả:</label>
					<textarea class="form-control"  name = "txtMoTa" id = "txtMoTa" cols = "50" rows = "3"></textarea>
				</div>
				<div class="mb-3 mt-3">
					<label for="fileHinh" class="form-label">Chọn hình đại diện:</label>
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