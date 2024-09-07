<?php
session_start();
//echo $_SESSION["Role"];
//1-Kết nối cơ sở dữ liệu
include_once 'connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width= , initial-scale=1.0"> -->
    <meta charset="utf-8">

    <title>Đơn hàng</title>
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

<body cz-shortcut-listen="true">
    <div class="container ">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="trangchu.php">Trang chủ</a>
            </li>

            <li class="nav-item">
            <li><a class="nav-link" href="giohang.php">Giỏ hàng</a></li>
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


            <?php if (isset($_SESSION['Name']) == 0) { ?>
            <li><a class="nav-link" href="registry.php">Đăng ký</a></li>
            <li><a class="nav-link" href="login.php">Đăng nhập</a></li>
            </li>
            <?php } else { ?>
            <li><a class="nav-link" href="logout.php?flag=1">Đăng xuất</a></li>
            <li><a class="nav-link" href="#"><?php echo 'Xin chào ' .
        $_SESSION['Name'] .
        '!'; ?></a>
                <?php } ?>


        </ul>



    </div>
</body>

</html>
<div class="container ">

    <h2>Thông Tin Các Đơn Đặt Hàng:</h2>
    <?php

// bo o dau trang, de o cuoi cho nay, neu loi nha 20/8
// session_start();
//1-Kết nối cơ sở dữ liệu
// include_once("connect.php");
// SQL query to retrieve order information with customer names and book titles
$sql = "SELECT 
            o.OrderID, 
            a.Username, 
            o.Amount, 
            o.DateTran, 
            i.ISBN, 
            b.Title, 
            b.Price, 
            i.Prices, 
            i.Quantity,
            (i.Quantity * b.Price) AS TotalPrice  
        FROM 
            orders o
        INNER JOIN 
            order_items i ON o.OrderID = i.OrderID
        INNER JOIN 
            accounts a ON o.AccountID = a.AccountID
        INNER JOIN 
            books b ON i.ISBN = b.ISBN";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
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
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            cursor: pointer;
            border-radius: 4px;
        }
        .delete-button:hover {
            background-color: #ed8b8b;
        }
    </style>
    <table border='4'>
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
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["OrderID"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Username"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["DateTran"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["ISBN"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Title"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Price"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["TotalPrice"]) . "</td>";  // Display the calculated TotalPrice
        
        echo "<td>";
        if ($_SESSION["Role"] == 1) {  // Admin role check
            echo "<a onclick=\"return confirm('Bạn có chắc xóa không?');\" href='xoa_donhang.php?ma=" . htmlspecialchars($row["OrderID"]) . "'>
            <img src='images/icons8-delete-24.png' style='width: 60px; height: 50px;' class='delete-button'>
          </a>";
        }
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Không có đơn hàng nào.";
}

// Close the connection
$conn->close();
?>