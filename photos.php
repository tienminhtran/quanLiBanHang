<!--Phần đầu-->
<?php
	include_once("qt_phandau.php");
?>
<!--Phần nội dung-->
<h2>
    Quản lý thông tin hình ảnh
    <hr>
</h2>

<table class="table table-hover table-striped">
    <tr class="table-primary">
        <th>ISBN</th>
        <th>Tựa đề</th>
        <th>Thêm</th>
        <th>Album ảnh</th>
        <!-- <th>Xóa</th>
        <th>Sửa</th> -->
    </tr>
    <?php
		//Select dữ liệu từ bảng books
		//1- Kết nối cơ sở dữ liệu
		include_once("connect.php");
		
		//2- Viết câu truy vấn
		//$sql = "SELECT * FROM books, photos WHERE books.ISBN = photos.ISBN";
		//$sql = "SELECT books.ISBN, Picture, Title, count(PhotoID) as sl FROM books, photos WHERE books.ISBN = photos.ISBN GROUP BY books.ISBN";
		$sql = "SELECT*FROM books";
		//3-Thực thi câu truy vấn, nhận kết quả trả về
		$result = $conn->query($sql);
		
		//4 - Kiểm tra dữ liệu và hiển kết quả nếu có mẩu tin
		if($result->num_rows>0)
		{
			//Có mẩu tin >>Hiển thị từng mẩu tin
			while($row = $result->fetch_assoc())
			{
				echo "<tr>";
				echo "<td><img width='50' src='images/".$row["Picture"]."'></td>";
				echo "<td>".$row["Title"]."</td>";
				echo "<td>";
				?>
    <a href="them_photo.php?ma=<?php echo $row["ISBN"];?>"><img src="images/icons8-add-32.png"></a>

    <?php
				echo "</td>";
				echo "<td>";
				?>
    <a href="xem_photo.php?ma=<?php echo $row["ISBN"];?>"><img src="images/icons8-view-24.png"></a>
    <!--<span>(<?php //echo $row["sl"];?>)</span>-->

    <?php
				echo "</td>";
				
				
				echo "</tr>";
			}
		}
		else
		{
			//0 có mẩu tin
			echo "0 picture.";
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