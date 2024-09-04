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
	
	//2- Select dữ liệu từ bảng books với điều kiện ISBN = $isbn
	$sql = "SELECT*FROM books WHERE ISBN = '$isbn'";
	
	$result = $conn->query($sql);
	
	$isbn_val = $cate_val = $title_val = $author_val = $price_val = $des_val = $picture_val=$souong_val="";
	
	$row = $result->fetch_assoc();
	$isbn_val = $row["ISBN"];
	$cate_val = $row["CategoryID"];
	$title_val = $row["Title"];
	$author_val = $row["Author"];
	$price_val = $row["Price"];
	$des_val = $row["Description"];
	$picture_val = $row["Picture"];
	$soluong_val = $row["Soluong"];
	
?>




<!--Thiết kế form thêm mới một quyển sách - books-->
<!-- <div class = "row">
	<div class = "col-sm-2">&nbsp;</div>
	<div class = "col-sm-8">
		<fieldset>
			<legend>Cập nhật thông tin quyển sách mới</legend>
			<form name = "frmSuaSach" action = "xuly_suasach.php" method = "post" enctype="multipart/form-data">
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
									if($row["CategoryID"]===$cate_val)
									{
										echo "<option selected value = '".$row["CategoryID"]."'>";
										echo $row["CategoryID"]. "-".$row["Name"];
										echo "</option>";
										
									}
									else
									{
										echo "<option value = '".$row["CategoryID"]."'>";
										echo $row["CategoryID"]. "-".$row["Name"];
										echo "</option>";
									}
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
					<input value ="<?php echo $isbn_val ;?>" readonly type="text" class="form-control" id="txtISBN" 
						placeholder="Nhập số ISBN" name="txtISBN" required>
				</div>
				
				<div class="mb-3 mt-3">
					<label for="txtTen" class="form-label">Nhập tên sách:</label>
					<input value ="<?php echo $title_val ;?>"  type="text" class="form-control" id="txtTen" 
						placeholder="Nhập tên sách mới" name="txtTen">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtTacGia" class="form-label">Nhập thông tin tác giả:</label>
					<input value ="<?php echo $author_val ;?>"  type="text" class="form-control" id="txtTacGia" 
						placeholder="Nhập tác giả" name="txtTacGia">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtGia" class="form-label">Nhập đơn giá:</label>
					<input value ="<?php echo $price_val ;?>"  type="text" class="form-control" id="txtGia" 
						placeholder="Nhập đơn giá" name="txtGia">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtSoluong" class="form-label">Nhập số lượng:</label>
					<input value ="<?php echo $soluong_val ;?>"  type="text" class="form-control" id="txtSoluong" 
						placeholder="Nhập số lượng" name="txtSoluong">
				</div>
				<div class="mb-3 mt-3">
					<label for="txtMoTa" class="form-label">Nhập mô tả:</label>
					<textarea class="form-control"  name = "txtMoTa" id = "txtMoTa" cols = "50" rows = "3"><?php echo $des_val ;?></textarea>
				</div>
				<div class="mb-3 mt-3">
					<label>Ảnh hiện tại</label>
					<img src = "images/<?php echo $picture_val;?>" alt = "" width = "50">
					<br>
					<label for="fileHinh" class="form-label">Chọn hình mới</label>
					<input type = "file" name = "fileHinh">
				</div>
				<input class = "btn btn-danger" type = "submit" name = "sbSua" value = "Sửa">
				<input class = "btn btn-danger" type = "reset" name = "sbHuy" value = "Hủy">
			</form>
		</fieldset>
	</div>
	<div class = "col-sm-2">&nbsp;</div>
</div> -->

<div class="row justify-content-center">
    <div class="col-sm-8">
        <fieldset class="border p-4 rounded">
            <legend class="w-auto px-3">Cập nhật thông tin quyển sách mới</legend>
            <form name="frmSuaSach" action="xuly_suasach.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="slDanhMuc" class="form-label">Chọn danh mục sách:</label>
                    <select class="form-control" name="slDanhMuc">
                        <?php
                            $sql = "SELECT * FROM categories";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($row["CategoryID"] === $cate_val) ? "selected" : "";
                                    echo "<option $selected value='".$row["CategoryID"]."'>";
                                    echo $row["CategoryID"]. "-".$row["Name"];
                                    echo "</option>";
                                }
                            } else {
                                echo "<option value=''>Chưa có danh mục sách</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="txtISBN" class="form-label">Nhập số ISBN:</label>
                    <input readonly type="text" class="form-control" id="txtISBN" placeholder="Nhập số ISBN"
                        name="txtISBN" required value="<?php echo $isbn_val; ?>">
                </div>

                <div class="mb-3">
                    <label for="txtTen" class="form-label">Nhập tên sách:</label>
                    <input type="text" class="form-control" id="txtTen" placeholder="Nhập tên sách mới" name="txtTen"
                        value="<?php echo $title_val; ?>">
                </div>

                <div class="mb-3">
                    <label for="txtTacGia" class="form-label">Nhập thông tin tác giả:</label>
                    <input type="text" class="form-control" id="txtTacGia" placeholder="Nhập tác giả" name="txtTacGia"
                        value="<?php echo $author_val; ?>">
                </div>

                <div class="mb-3">
                    <label for="txtGia" class="form-label">Nhập đơn giá:</label>
                    <input type="text" class="form-control" id="txtGia" placeholder="Nhập đơn giá" name="txtGia"
                        value="<?php echo $price_val; ?>">
                </div>

                <div class="mb-3">
                    <label for="txtSoluong" class="form-label">Nhập số lượng:</label>
                    <input type="text" class="form-control" id="txtSoluong" placeholder="Nhập số lượng"
                        name="txtSoluong" value="<?php echo $soluong_val; ?>">
                </div>

                <div class="mb-3">
                    <label for="txtMoTa" class="form-label">Nhập mô tả:</label>
                    <textarea class="form-control" name="txtMoTa" id="txtMoTa" cols="50" rows="3"
                        placeholder="Nhập mô tả sách"><?php echo $des_val; ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Ảnh hiện tại:</label><br>
                    <img src="images/<?php echo $picture_val; ?>" alt="" class="img-thumbnail" width="100">
                    <br><br>
                    <label for="fileHinh" class="form-label">Chọn hình mới:</label>
                    <input type="file" name="fileHinh" class="form-control-file">
                </div>

                <div class="text-end">
                    <input class="btn btn-danger" type="submit" name="sbSua" value="Sửa">
                    <input class="btn btn-secondary" type="reset" name="sbHuy" value="Hủy">
                </div>
            </form>
        </fieldset>
    </div>
</div>



<?php
	include_once("qt_phanchan.php");
?>
<div class="container">
    <br>
    <hr>
    <div class="row text-dark">
        <div class="col-md-3">
            <h6><strong>Địa chỉ:</strong></h6>
            <p>Số 04, Nguyễn Văn Bảo, Phường 4, Gò Vấp, Hồ Chí Minh</p>
        </div>
        <div class="col-md-3">
            <h6><strong>Số điện thoại:</strong></h6>
            <p>0123456789</p>
            <p>0911123456</p>
        </div>
        <div class="col-md-2">
            <h6><strong>Quản trị</strong></h6>
            <ul class="list-unstyled">
                <li><a href="trangchu.php" class="text-dark">Trang chủ</a></li>
                <li><a href="quantri.php" class="text-dark">Quản trị</a></li>
            </ul>
        </div>
        <div class="col-md-2">
            <h6><strong>Về chúng tôi</strong></h6>
            <ul class="list-unstyled">
                <li><a href="danhmuc.php" class="text-dark">Item category</a></li>
                <li><a href="sach.php" class="text-dark">Item book</a></li>
                <li><a href="photo.php" class="text-dark">Item photo</a></li>
                <li><a href="donhang.php" class="text-dark">Order</a></li>
            </ul>
        </div>
        <div class="col-md-2 text-center">
            <div>
                <a href="http://online.gov.vn/Home/WebDetails/19168">
                    <img src="./images/bc.png" class="img-fluid mb-2" alt="Logo" style="max-width: 230px;">
                </a>
            </div>

        </div>
    </div>
</div>