<?php
session_start();
if(!isset($_SESSION["Name"]))
{
	header("Location:login.php");
}
if($_SESSION["Role"]==2)//Khách hàng
{
	header("Location:trangchu.php");
}
include_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $accountId = $_SESSION['Account'];
    $date = date('Y-m-d');

    // Check stock availability
    $sql = "SELECT Soluong FROM books WHERE ISBN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $isbn);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stock = $row['Soluong'];
    $stmt->close();

    if ($quantity > $stock) {
        die('Số lượng yêu cầu vượt quá số lượng tồn kho.');
    }

    // Insert into orders
    $sql = "INSERT INTO orders (AccountID, ISBN, Quantity, Price, DateOrdered) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssids', $accountId, $isbn, $quantity, $price, $date);
    if ($stmt->execute()) {
        // Update stock
        $sql = "UPDATE books SET Soluong = Soluong - ? WHERE ISBN = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $quantity, $isbn);
        $stmt->execute();
        $stmt->close();

        echo 'Thanh toán thành công! Cảm ơn bạn đã mua hàng.';
    } else {
        echo 'Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.';
    }
}
?>