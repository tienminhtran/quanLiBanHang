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
        /* border: 1px solid #ccc; */
        padding: 10px;
    }[]

    .row {
        /* border: 1px solid #ccc; */
        padding: 10px;
        color: #FF0000;
        /* background-color: #66FFFF; */
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
            (i.Quantity * b.Price) AS TotalPrice  -- Calculated column for total price per item
        FROM 
            orders o
        INNER JOIN 
            order_items i ON o.OrderID = i.OrderID
        INNER JOIN 
            accounts a ON o.AccountID = a.AccountID
        INNER JOIN 
            books b ON i.ISBN = b.ISBN
        WHERE 
            a.Username = ?";


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
            <?php if (isset($_SESSION['RoleID']) && $_SESSION['RoleID'] == 1) { // Quản trị ?>
            <li class="nav-item">
                <a class="nav-link" style="color: #FF00FF;" href="quantri.php">Đến trang quản trị</a>
            </li>
            <?php } ?>
            <li class="nav-item"><a class="nav-link" href="trangchu.php">Trang chủ</a></li>
            <li class="nav-item"><a class="nav-link" href="giohang.php">Giỏ hàng</a></li>
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
                echo "<td>" . htmlspecialchars($row["TotalPrice"]) . "</td>";

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
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-md-2" ; style="color: #000000">
                <h6>Địa chỉ:</h6>
                <p>Số 04, Nguyễn Văn Bảo, Phường 4, Gò Vấp, Hồ Chi Minh</p>
            </div>
            <div class="col-md-2" ; style="color: #000000">
                <h6>Số điện thoại:</h6>
                <p>0123456789</p>
                <p>0911123456</p>
            </div>
            <div class="col-md-2" ; style="color: #000000">
                <h6>Mạng xã hội</h6>

                <a target="#" href="https://www.w3schools.com/bootstrap4/" style="color: #000000">
                    <img src="./images/Youtube-on.webp">
                    Youtube
                </a>
                <br>
                <a target="#" href="https://www.w3schools.com/bootstrap4/" style="color: #000000">
                    <img src="./images/Facebook-on.webp">
                    Facebook
                </a><br>
                <a target="#" href="https://www.w3schools.com/bootstrap4/bootstrap_get_started.asp"
                    style="color: #000000">
                    <img src="./images/twitter-on.webp">
                    Twitter
                </a>


            </div>
            <div class="col-md-2" ; style="color: #000000">
                <h6>Về chúng tôi</h6>
                <ul>
                    <li><a target="#" href="trangchu.php" style="color: #000000">Trang chủ</a></li>
                    <li><a target="#" href="giohang.php" style="color: #000000">Giỏ hàng</a></li>
                    <li><a target="#" href="donhang_kh.php" style="color: #000000">Đơn hàng</a></li>

                </ul>
            </div>
            <div class="col">
                <div class="col col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <a href="http://online.gov.vn/Home/WebDetails/19168">
                        <img src="./images/bc.png" width="230" height="90">
                    </a>
                </div>
                <div>
                    <img src=" ./images/ZaloPay-logo-130x83.webp" width="85" height="40">
                    <img src="./images/shopeepay_logo.webp" width="70" height="40">
                    <img src="./images/momopay.webp" width="50" height="40">
                </div>
            </div>
        </div>

        <!-- <div class="col-md-6">&nbsp</div> -->

    </div>
    <!-- màu đen  -->
    <span style="color: #000000	;">
        <footer class="container-fluid text-center">
            <p>© 2021 Bản quyền thuộc về Team Code K17</p>
        </footer>
        </div>
</body>

</html>