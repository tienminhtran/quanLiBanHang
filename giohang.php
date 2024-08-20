<?php
session_start();

//1- Kết nối cơ sở dữ liệu
include_once("connect.php");

//2- Viết câu truy vấn
	$isbn="";
if(isset($_POST['sbThemhang'])) {
	$isbn = $_POST['txtISBN']; 					//lấy được ISBN
    $soLuongMua = $_POST['txtSoLuongMua'];    //lấy được số lượng sách mua
    $dateTran = date("Y-m-d");
    $amount = "1";
    $accountId = $_SESSION["Account"];
	$name= $_SESSION["Name"];
}
?>

<table class="table table-hover" style="text-align: center;" border='5'>
	<tr>
		<th>Tài khoản đặt hàng</th>
		<th>ISBN</th>
		<th>Tựa đề</th>
		<th>Giá</th>
		<th>Số lượng tồn kho</th>
		<th>Số lượng đặt</th>
		<th>Thanh toán</th>
	</tr>
   <?php
		//Select dữ liệu từ bảng books
		//1- Kết nối cơ sở dữ liệu
		include_once("connect.php");
		
		//2- Viết câu truy vấn
		$sql = "SELECT * FROM books WHERE ISBN = '$isbn'";
		
		//3-Thực thi câu truy vấn, nhận kết quả trả về
		$result = $conn->query($sql);
		
		//4 - Kiểm tra dữ liệu và hiển kết quả nếu có mẩu tin
		if($result->num_rows>0)
		{
			//Có mẩu tin >>Hiển thị từng mẩu tin
			while($row = $result->fetch_assoc())
			{
				echo "<tr>";
				echo "<td>".$name."</td>";
				echo "<td>".$row["ISBN"]."</td>";
				echo "<td>".$row["Title"]."</td>";
				echo "<td>".$row["Price"]."</td>";
				echo "<td>".$row["Soluong"]."</td>";
				echo "<td>".$soLuongMua."</td>";
				echo "<td>";
				?>
				
					<a href = "hoadon_thanhtoan.php?ma=<?php echo $row["ISBN"];?>&slm=<?php echo $soLuongMua;?>&gia=<?php echo $row["Price"];?>">Thanh toán</a>
				<?php
				echo "</td>";
				echo "</tr>";
			}
		}
		else
		{
			//0 có mẩu tin
			echo "0 có quyển sách nào trong giỏ";
		}
		
	?>
	
</table>
<h3><a class="btn btn-primary" href="trangchu.php">Quay lại trang chủ</a></h3>





