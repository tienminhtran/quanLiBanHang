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
<a class="btn btn-info" href="them_danhmuc.php">
    Thêm
</a>
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
    <a onclick="return confirm('Bạn có chắc xóa không?');"
        href="xoa_danhmuc.php?ma=<?php echo $row["CategoryID"];?>"><img src="images/icons8-delete-24.png"></a>

    <?php
				echo "</td>";
				echo "<td>";
				?>
    <a href="sua_danhmuc.php?ma=<?php echo $row["CategoryID"];?>"><img src="images/icons8-edit-24.png"> </a>
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