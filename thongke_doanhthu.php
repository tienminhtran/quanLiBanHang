<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng doanh thu</title>
    <style>
        .doanhthu {
            background-color: #f4f4f4;
            padding: 10px;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Thống Kê Doanh Thu Cửa Hàng:</h2>
    <?php
    // Kết nối cơ sở dữ liệu
    include_once("connect.php");

    // Truy vấn để lấy thông tin đơn hàng của mọi khách hàng kèm theo tên khách hàng và tiêu đề sách
    $sql = "SELECT o.OrderID, a.Username, o.Amount, o.DateTran, i.ISBN, b.Title, b.Price, i.Prices, i.Quantity
            FROM orders o
            INNER JOIN order_items i ON o.OrderID = i.OrderID
            INNER JOIN accounts a ON o.AccountID = a.AccountID
            INNER JOIN books b ON i.ISBN = b.ISBN";

    $result = $conn->query($sql);

    $doanhthu = 0; // Khởi tạo biến tổng doanh thu

    if ($result->num_rows > 0) {
        // Hiển thị dữ liệu

        echo "<table border='1'>
                <tr>
                    <th>OrderID</th>
                    <th>Tên tài khoản đặt hàng</th>
                    <th>Ngày đặt</th>
                    <th>ISBN</th>
                    <th>Tên Sách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["OrderID"] . "</td>";
            echo "<td>" . $row["Username"] . "</td>";
            echo "<td>" . $row["DateTran"] . "</td>";
            echo "<td>" . $row["ISBN"] . "</td>";
            echo "<td>" . $row["Title"] . "</td>";
            echo "<td>" . $row["Price"] . "</td>";
            echo "<td>" . $row["Quantity"] . "</td>";
            echo "<td>" . $row["Prices"] . "</td>";
            echo "</tr>";

            $doanhthu += $row["Prices"]; // Cộng giá trị của cột "Tổng tiền" vào biến tổng doanh thu
        }

        echo "</table>";

        // Hiển thị tổng doanh thu với style
        echo "<div class='doanhthu'>Tổng doanh thu: " . $doanhthu . "</div>";
    } else {
        echo "Không có đơn hàng nào.";
    }
    ?>
    <h3><a class="nav-link" href="trangchu.php">Quay Lại Trang chủ</a></h3>
    <?php
    // Đóng kết nối
    $conn->close();
    ?>
</body>
</html>
