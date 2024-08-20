<?php
	include_once("qt_phandau.php");

?>

<div class = "row mt-3">
	<div class = "col-sm-3">&nbsp;</div>
	<div class = "col-sm-6">
		<?php
			//1 - Viết câu truy vấn
			$sql = "SELECT c.Name, count(b.ISBN) SoLuong FROM books b, categories c WHERE b.CategoryID = c.CategoryID GROUP BY c.CategoryID";
			//echo $sql;
			//2 - Thực thi và hiển thị kết quả
			$result = $conn->query($sql);
			echo "<h2>Số lượng ấn phẩm theo từng danh mục</h2>";
			if($result->num_rows>0)
			{
				echo "<table class = 'table table-hover table-bordered'>";
				echo "<tr><th>Danh  mục</th><th>Số lượng ấn phẩm</th></tr>";
				while($row = $result->fetch_assoc())
				{
					echo "<tr>";
					echo "<td>".$row["Name"]."</td>";
					echo "<td>".$row["SoLuong"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			else
			{
				echo "0 có dữ liệu thỏa mãn điều kiện thống kê";
				
			}
		?>
	
	</div>
	<div class = "col-sm-3">&nbsp;</div>
</div>


	

<?php
	include_once("qt_phanchan.php");

?>