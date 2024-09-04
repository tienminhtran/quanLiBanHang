<?php
	include_once("qt_phandau.php");
?>
<?php
	//1-Lấy dữ liệu từ URL đổ lên form
	$madm = "";
	if(isset($_GET["ma"]))
	{
		$madm = $_GET["ma"];
	}
	
	//Select các thông tin còn lại của mẩu tin có mã vừa lấy từ url
	
	include_once("connect.php");
	$sql = "SELECT * FROM categories WHERE CategoryID = '$madm'";
	$result = $conn->query($sql);
	$ma_val = $ten_val = $mota_val = "";
	$row = $result->fetch_assoc();
	
	$ma_val = $row["CategoryID"];
	$ten_val = $row["Name"];
	$mota_val = $row["Description"];
?>

<!--Thiết kế form thêm mới một danh mục - Categories-->
<!-- 
<div class="row">
    <div class="col-sm-2">&nbsp;</div>
    <div class="col-sm-8">
        <fieldset>
            <legend>Cập nhật danh mục</legend>
            <form name="frmSuaDM" action="xuly_suadanhmuc.php" method="post">
                <div class="mb-3 mt-3">
                    <label for="txtMa" class="form-label">Nhập mã danh mục:</label>
                    <input readonly type="text" class="form-control" id="txtMa" placeholder="Nhập mã danh mục mới"
                        name="txtMa" value="<?php if(isset($_GET["ma"])){ echo $ma_val;}?>">
                </div>
                <div class="mb-3 mt-3">
                    <label for="txtTen" class="form-label">Nhập tên danh mục:</label>
                    <input type="text" class="form-control" id="txtTen" placeholder="Nhập tên danh mục mới"
                        name="txtTen" value="<?php if(isset($_GET["ma"])){ echo $ten_val;}?>">
                </div>
                <div class="mb-3 mt-3">
                    <label for="txtMoTa" class="form-label">Nhập mô tả:</label>
                    <textarea class="form-control" name="txtMoTa" id="txtMoTa" cols="50"
                        rows="3"><?php if(isset($_GET["ma"])){ echo $mota_val;}?></textarea>
                </div>
                <input class="btn btn-danger" type="submit" name="sbSua" value="Lưu">
                <input class="btn btn-danger" type="reset" name="sbHuy" value="Hủy">
            </form>
        </fieldset>
    </div>
    <div class="col-sm-2">&nbsp;</div>
</div> -->
<div class="row justify-content-center">
    <div class="col-sm-8">
        <fieldset class="border p-4 rounded">
            <legend class="w-auto px-3">Cập nhật danh mục</legend>
            <form name="frmSuaDM" action="xuly_suadanhmuc.php" method="post">
                <div class="mb-3">
                    <label for="txtMa" class="form-label">Nhập mã danh mục:</label>
                    <input readonly type="text" class="form-control" id="txtMa" placeholder="Nhập mã danh mục mới"
                        name="txtMa" value="<?php if(isset($_GET['ma'])){ echo $ma_val;}?>">
                </div>
                <div class="mb-3">
                    <label for="txtTen" class="form-label">Nhập tên danh mục:</label>
                    <input type="text" class="form-control" id="txtTen" placeholder="Nhập tên danh mục mới"
                        name="txtTen" value="<?php if(isset($_GET['ma'])){ echo $ten_val;}?>">
                </div>
                <div class="mb-3">
                    <label for="txtMoTa" class="form-label">Nhập mô tả:</label>
                    <textarea class="form-control" name="txtMoTa" id="txtMoTa" cols="50" rows="3"
                        placeholder="Nhập mô tả danh mục"><?php if(isset($_GET['ma'])){ echo $mota_val;}?></textarea>
                </div>
                <div class="text-end">
                    <input class="btn btn-danger" type="submit" name="sbSua" value="Lưu">
                    <input class="btn btn-secondary" type="reset" name="sbHuy" value="Hủy">
                </div>
            </form>
        </fieldset>
    </div>
</div>
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

<?php
	include_once("qt_phanchan.php");
?>