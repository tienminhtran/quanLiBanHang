<!--Phần đầu-->
<?php
	include_once("qt_phandau.php");
?>
<!--Phần nội dung-->
<h2>
	Quản lý danh mục
	<hr>
</h2>
<a class = "btn btn-info" href = "them_danhmuc.php">
	Thêm
</a>
<table class = "table table-hover">
	<tr>
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
					<a onclick = "return confirm('Bạn có chắc xóa không?');" 
							href = "xoa_danhmuc.php?ma=<?php echo $row["CategoryID"];?>"><img src = "images/icons8-delete-24.png"></a>
				
				<?php
				echo "</td>";
				echo "<td>";
				?>
					<a href = "sua_danhmuc.php?ma=<?php echo $row["CategoryID"];?>"><img src = "images/icons8-edit-24.png"> </a>
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
