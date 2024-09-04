<!--Phần đầu-->
<?php
	include_once("qt_phandau.php");
?>
<style>
table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}

th,
td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
    color: #333;

}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

td:last-child {
    text-align: center;
}

.delete-button {
    background-color: #ff4d4d;
    color: white;
    border: none;
    padding: 5px 10px;
    text-align: center;
    cursor: pointer;
    border-radius: 4px;
}

.delete-button:hover {
    background-color: #ff3333;
}
</style>
<!--Phần nội dung-->
<h2>
    Quản lý danh mục
    <hr>
</h2>
<div style="text-align: right; margin-top: 10px;">
    <a class="btn btn-info" href="them_danhmuc.php" style="padding: 10px 20px; border-radius: 5px;">
        Thêm
    </a>
</div>

<table class="table table-hover table-striped">
    <tr class="table-primary">
        <th>Mã</th>
        <th>Tên danh mục</th>
        <th>Xóa</th>
        <th>Sửa</th>
    </tr>


    <?php
		//Select dữ liệu từ bảng Categories
		//1- Kết nối cơ sở dữ liệu
		include_once("connect.php");
		
		//2- Viết câu truy vấn
		$sql = "SELECT * FROM categories";
		
		//3-Thực thi câu truy vấn, nhận kết quả trả về
		$result = $conn->query($sql);
		
		//4 - Kiểm tra dữ liệu và hiển kết quả nếu có mẩu tin
		if($result->num_rows>0)
		{
			//Có mẩu tin >>Hiển thị từng mẩu tin
			while($row = $result->fetch_assoc())
			{
				echo "<tr>";
				echo "<td>".$row["CategoryID"]."</td>";
				echo "<td>".$row["Name"]."</td>";
				echo "<td>";
				?>
    <a onclick="return confirm('Bạn có chắc xóa không?');" href="xoa_danhmuc.php?ma=<?php echo $row["CategoryID"];?>">
        <img src="images/icons8-delete-24.png"></a>

    <?php
				echo "</td>";
				echo "<td>";
				?>
    <a href="sua_danhmuc.php?ma=<?php echo $row['CategoryID']; ?>" class="centered-link">
        <img src="images/icons8-edit-24.png" alt="Edit Icon">
    </a>
    <?php
				echo "</td>";
				echo "</tr>";
			}
		}
		else
		{
			//0 có mẩu tin
			echo "0 danh mục sản phẩm";
		}
	?>
</table>
<!--Phần chân trang-->
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

<!-- màu đen  -->
<span style="color: #000000	;">
    <footer class="container-fluid text-center">
        <p>© 2021 Bản quyền thuộc về Team Code K17</p>
    </footer>
    </div>