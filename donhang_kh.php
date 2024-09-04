<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng KH</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./CSS/css.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    .col-sm-8 {
        border: 1px solid #ccc;
        padding: 10px;
    }

    .row {
        border: 1px solid #ccc;
        padding: 10px;
        color: #FF0000;
        background-color: #66FFFF;
        margin-bottom: 20px;
    }

    .col-sm-4 a.nav.nav-tabs {
        text-decoration: none;
        color: #0000FF;
        padding: 5px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: block;
        margin-bottom: 5px;
    }

    .col-sm-4 a.nav.nav-tabs:hover {
        background-color: #f0f0f0;
    }

    .book {
        display: inline-block;
        margin-right: 10px;
        text-align: center;
    }

    .carousel-indicators.custom-indicators {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(50%);
        right: 0;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>

</body>

</html><?php
session_start();
include 'connect.php'; // Ensure you include your database connection

// Check if user is logged in
if (!isset($_SESSION['Name'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['Name']; // Username from session

// SQL query to get orders for the logged-in user
$sql = "SELECT o.OrderID, a.Username, o.Amount, o.DateTran, i.ISBN, b.Title, b.Price, i.Prices, i.Quantity
        FROM orders o
        INNER JOIN order_items i ON o.OrderID = i.OrderID
        INNER JOIN accounts a ON o.AccountID = a.AccountID
        INNER JOIN books b ON i.ISBN = b.ISBN
        WHERE a.Username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Adjust path as needed -->
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
</head>

<body cz-shortcut-listen="true">
    <div class="container">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="trangchu.php">Trang chủ</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="donhang.php">Đơn hàng</a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="giohang.php">Giỏ hàng</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Sản Phẩm</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="trangchu.php?category=5">Văn Học Việt Nam</a></li>
                    <li><a class="dropdown-item" href="trangchu.php?category=6">Văn Học Nước Ngoài</a></li>
                    <li><a class="dropdown-item" href="trangchu.php?category=7">Cổ Tích - Thần Thoại</a></li>
                    <li><a class="dropdown-item" href="trangchu.php?category=8">Ngôn Ngữ Lập Trình</a></li>
                    <li><a class="dropdown-item" href="trangchu.php?category=9">Sách Giáo Khoa - Giảng Dạy</a></li>
                    <li><a class="dropdown-item" href="trangchu.php?category=10">Sách Y Khoa</a></li>
                </ul>
            </li>
            <?php if (!isset($_SESSION['Name'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="registry.php">Đăng ký</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Đăng nhập</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php?flag=1">Đăng xuất</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo 'Xin chào ' . htmlspecialchars($_SESSION['Name']) . '!'; ?></a>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="container">
        <h2>Thông Tin Các Đơn Đặt Hàng:</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table border='4'>
                <tr>
                    <th>OrderID</th>
                    <th>Tên tài khoản</th>
                    <th>Ngày đặt</th>
                    <th>ISBN</th>
                    <th>Tên Sách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Xoá</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["OrderID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Username"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["DateTran"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Title"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Price"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Prices"]) . "</td>";

                echo "<td>";
                if ($_SESSION["Role"] == 1) { // Quản trị
                    echo "<a onclick=\"return confirm('Bạn có chắc xóa không?');\" href='xoa_donhang.php?ma=" . htmlspecialchars($row["OrderID"]) . "'><img src='images/icons8-delete-24.png' class='delete-button'></a>";
                }
                echo "</td>";

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Không có đơn hàng nào.";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>

</html>