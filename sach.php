<!--Phần đầu-->
<?php
	include_once("qt_phandau.php");
?>

<!--Phần nội dung-->
<h2>
    Quản lý thông tin sách
    <hr>
</h2>
<div style="text-align: right; margin-top: 10px;">
    <a class="btn btn-info" href="them_sach.php" style="padding: 10px 20px; border-radius: 5px;">
        Thêm
    </a>
</div>
<table class="table table-hover table-striped">
    <tr class="table-primary">
        <th>ISBN</th>
        <th>Tựa đề</th>
        <th>Hình đại diện</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Xóa</th>
        <th>Sửa</th>
        <th>Hình ảnh</th>

    </tr>
    <?php
		//Select dữ liệu từ bảng books
		//1- Kết nối cơ sở dữ liệu
		include_once("connect.php");
		
		//2- Viết câu truy vấn
		$sql = "SELECT * FROM books";
		
		//3-Thực thi câu truy vấn, nhận kết quả trả về
		$result = $conn->query($sql);
		
		//4 - Kiểm tra dữ liệu và hiển kết quả nếu có mẩu tin
		if($result->num_rows>0)
		{
			//Có mẩu tin >>Hiển thị từng mẩu tin
			while($row = $result->fetch_assoc())
			{
				echo "<tr>";
				echo "<td>".$row["ISBN"]."</td>";
				echo "<td>".$row["Title"]."</td>";
				echo "<td><img width='50' height='50' src = 'images/".$row["Picture"]."' alt = ''></td>";
				echo "<td>".$row["Price"]."</td>";
				echo "<td>".$row["Soluong"]."</td>";
				echo "<td>";
				?>
    <a onclick="return confirm('Bạn có chắc xóa không?');" href="xoa_sach.php?ma=<?php echo $row["ISBN"];?>">
        <img src='images/icons8-delete-24.png' style='width: 60px; height: 50px; ' class='delete-button'>

        <?php
				echo "</td>";
				echo "<td>";
				?>
        <a href="sua_sach.php?ma=<?php echo $row["ISBN"];?>"><img src="images/icons8-edit-24.png"> </a>
        <?php
				echo "</td>";
				
				
				echo "<td>";
				?>
        <a href="xem_photo.php?ma=<?php echo $row["ISBN"];?>"><img src="images/icons8-view-24.png"></a>


        <?php
				echo "</td>";
				echo "</tr>";
			}
		}
		else
		{
			//0 có mẩu tin
			echo "0 quyển sách";
		}
	?>
</table>
<!--Phần chân trang-->
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