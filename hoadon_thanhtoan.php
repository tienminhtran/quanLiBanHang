<?php
session_start();

// Kết nối cơ sở dữ liệu
include_once("connect.php");

// Kiểm tra nếu có mã ISBN được gửi từ liên kết
$amonut="1";
$orderid="";
if(isset($_GET['ma'])) {
	
    $isbn = $_GET['ma'];
    $soLuongMua = $_GET['slm'];
	$gia = $_GET['gia'];
	$tongtien=$soLuongMua*$gia;
    // Lấy thông tin ngày tháng hiện tại
    $dateTran = date("Y-m-d");
    
    // Lấy thông tin tài khoản đặt hàng và tên người dùng từ session
    $accountId = $_SESSION["Account"];
    $name = $_SESSION["Name"];

    // Thêm thông tin đơn hàng vào bảng "order_items"
	$sql_dathang = "INSERT INTO orders(AccountID, Amount, DateTran) VALUES('$accountId','$amonut','$dateTran')";
	// Thực hiện câu lệnh INSERT INTO
if ($conn->query($sql_dathang) === TRUE) {
    // Lấy OrderID mới được tạo
    $orderid = $conn->insert_id;
		}
	
    $sql_hoadon = "INSERT INTO order_items (ISBN, OrderID, Prices, Quantity) VALUES ('$isbn','$orderid', '$tongtien', '$soLuongMua')";
    if($conn->query($sql_hoadon) === TRUE) {
        echo "Thêm đơn hàng thành công!";
    } else {
        echo "Lỗi: " . $sql_hoadon . "<br>" . $conn->error;
    }

    // Cập nhật số lượng tồn trong bảng "books"
    $sql_soluong = "UPDATE books SET Soluong = Soluong - '$soLuongMua' WHERE ISBN = '$isbn'";
    if($conn->query($sql_soluong) === TRUE) {
        echo "Bạn đã đặt hàng thành công!";
        // dte update 7/9 
		header("Location:donhang_kh.php");
    } else {
        echo "Error: " . $sql_soluong . "<br>" . $conn->error;
    }
} else {
    echo "Không có mã ISBN được gửi!";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>