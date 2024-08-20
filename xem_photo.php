<?php
	include_once("qt_phandau.php");
	//1 - Nhận mã ISBN được gửi từ liên kết
	$isbn = $_GET["ma"];
	$sql = "SELECT *FROM Photos WHERE ISBN = '$isbn'";
	$result = $conn->query($sql);
	
	if($result->num_rows>0)
	{	echo "<h2 style = 'text-transform:uppercase'>Quyển sách có mã ISBN là ".$isbn."</h2>";
		echo "<a class ='btn btn-success' href = 'them_photo.php?ma=".$isbn."'>Thêm</a>";
		echo "<h4 style ='border-bottom:2px solid black'>Album hình ảnh</h4>";
		echo "<table class ='table table-hover'>";
		echo "<tr><th>PhotoID</th><th>Ảnh</th><th>Sửa</th><th>Xóa</th></tr>";
		while($row = $result->fetch_assoc())
		{
			echo "<tr>";
			echo "<td>".$row["PhotoID"]."</td>";
			echo "<td><img width = '50' src='images/".$row["Names"]."'></td>";
			echo "<td>";
				?>
					<a onclick = "return confirm('Bạn có chắc xóa không?');" 
							href = "xoa_photo.php?ma=<?php echo $row["PhotoID"];?>">Xóa</a>
				
				<?php
				echo "</td>";
				echo "<td>";
				?>
					<a href = "sua_photo.php?ma=<?php echo $row["PhotoID"];?>">Sửa</a>
				<?php
				echo "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else
	{
		echo "Chưa có Album ảnh";
		?>
		<a href="sach.php" class="btn btn-primary">Quay lại</a>
		<?php
	}
	include_once("qt_phandau.php");
?>