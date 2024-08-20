<!--Phần đầu-->
<?php
	include_once("qt_phandau.php");
?>
<!--Phần nội dung-->
<h2>
	Quản lý thông tin hình ảnh
	<hr>
</h2>

<table class = "table table-hover">
	<tr>
		<th>ISBN</th>
		<th>Tựa đề</th>
		<th>Thêm</th>
		<th>Album ảnh</th>
		<!--<th>Xóa</th>
		<th>Sửa</th>-->
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
					<a href = "them_photo.php?ma=<?php echo $row["ISBN"];?>"><img src = "images/icons8-add-32.png"></a>
				
				<?php
				echo "</td>";
				echo "<td>";
				?>
					<a href = "xem_photo.php?ma=<?php echo $row["ISBN"];?>"><img src = "images/icons8-view-24.png"></a>
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
<?php
	include_once("qt_phanchan.php");
?>
