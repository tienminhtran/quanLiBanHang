<?php
session_start();
include_once("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>

<body>

    <div class="container">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" style="color: #FF00FF;" href="trangchu.php">Đến Trang Chủ</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Quản lý dữ liệu</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="danhmuc.php">Bảng danh mục - Categories</a></li>
                    <li><a class="dropdown-item" href="sach.php">Bảng sản phẩm - Books</a></li>
                    <li><a class="dropdown-item" href="photos.php">Bảng hình ảnh - Photos</a></li>
                    <li><a class="dropdown-item" href="donhang.php">Đơn hàng</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Thống kê</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="thongke_anpham.php">Về ấn phẩm</a></li>
                    <li><a class="dropdown-item" href="thongke_doanhthu.php">Về doanh thu</a></li>
                </ul>
            </li>
            <?php if (!isset($_SESSION['Name'])) { ?>
            <li class="nav-item"><a class="nav-link" href="registry.php">Đăng ký</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Đăng nhập</a></li>
            <?php } else { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php echo 'Xin chào ' . $_SESSION['Name'] . '!'; ?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="change_password.php">Đổi mật khẩu</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php?flag=1">Đăng xuất</a></li>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>

    <div class="container">
        <h2>Thông Tin Các Đơn Đặt Hàng:</h2>
        <?php
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
            echo "<table>
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
                echo "<td>" . htmlspecialchars($row["TotalPrice"]) . "</td>";  
                echo "<td>";
                if ($_SESSION["Role"] == 1) {
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
        ?>
    </div>

    <!-- Footer -->
    <div class="container">
        <br>
        <hr>
        <div class="row text-dark">
            <div class="col-md-3">
                <h6><strong>Địa chỉ:</strong></h6>
                <p>Số 04, Nguyễn Văn Bảo, Phường 4, Gò Vấp, Hồ Chí Minh</p>
            </div>
            <div class="col-md-3">
                <h6><strong>Số điện thoại:</strong></h6>
                <p>0123456789</p>
                <p>0911123456</p>
            </div>
            <div class="col-md-2">
                <h6><strong>Quản trị</strong></h6>
                <ul class="list-unstyled">
                    <li><a href="trangchu.php" class="text-dark">Trang chủ</a></li>
                    <li><a href="quantri.php" class="text-dark">Quản trị</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6><strong>Về chúng tôi</strong></h6>
                <ul class="list-unstyled">
                    <li><a href="danhmuc.php" class="text-dark">Item category</a></li>
                    <li><a href="sach.php" class="text-dark">Item book</a></li>
                    <li><a href="photo.php" class="text-dark">Item photo</a></li>
                    <li><a href="donhang.php" class="text-dark">Order</a></li>
                </ul>
            </div>
            <div class="col-md-2 text-center">
                <div>
                    <a href="http://online.gov.vn/Home/WebDetails/19168">
                        <img src="./images/bc.png" class="img-fluid mb-2" alt="Logo" style="max-width: 230px;">
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>