<!--Phần đầu-->
<?php
	include_once("qt_phandau.php");
?>
<!--Phần nội dung-->
<h2>
	Quản lý thông tin sách
	<hr>
</h2>
<a class = "btn btn-info" href = "them_sach.php">
	Thêm
</a>
<table class = "table table-hover">
	<tr>
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
					<a onclick = "return confirm('Bạn có chắc xóa không?');" 
							href = "xoa_sach.php?ma=<?php echo $row["ISBN"];?>"><img src = "images/icons8-delete-24.png"></a>
				
				<?php
				echo "</td>";
				echo "<td>";
				?>
					<a href = "sua_sach.php?ma=<?php echo $row["ISBN"];?>"><img src = "images/icons8-edit-24.png"> 	</a>
				<?php
				echo "</td>";
				
				
				echo "<td>";
				?>
					<a href = "xem_photo.php?ma=<?php echo $row["ISBN"];?>"><img src = "images/icons8-view-24.png"></a>
				
				
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
<?php
	include_once("qt_phanchan.php");
?>
