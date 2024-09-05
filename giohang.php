<?php
session_start();
require 'connect.php'; // Kết nối với cơ sở dữ liệu

// Khởi tạo biến thông báo
$message = '';

// Kiểm tra xem AccountID đã được lưu trong session chưa
if (isset($_SESSION['Name'])) {
    // Lấy username từ session
    $username = $_SESSION['Name'];

    // Truy vấn cơ sở dữ liệu để lấy AccountID dựa trên username
    $sql = "SELECT AccountID FROM accounts WHERE Username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra xem truy vấn có trả về kết quả không
    if ($result->num_rows === 0) {
        die('Error: Account not found.');
    }

    // Lấy AccountID từ kết quả truy vấn
    $row = $result->fetch_assoc();
    $accountId = $row['AccountID'];

    $stmt->close();
} else {
    $message = '<div class="alert alert-danger">Bạn chưa đăng nhập.</div>';
    exit; // Ngừng thực thi nếu chưa đăng nhập
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sbgiohang'])) {
    // Lấy dữ liệu từ form
    $isbn = isset($_POST['txtISBN']) ? htmlspecialchars($_POST['txtISBN']) : '';
    $quantity = isset($_POST['txtSoLuongGH']) ? intval($_POST['txtSoLuongGH']) : 0;

    // Kiểm tra số lượng và thêm sách vào giỏ hàng
    if ($quantity > 0) {
        // Kiểm tra xem sách đã tồn tại trong giỏ hàng chưa
        $query = "SELECT Quantity FROM cart_items WHERE AccountID = ? AND ISBN = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param('is', $accountId, $isbn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Sách đã có trong giỏ hàng, cập nhật số lượng
            $query = "UPDATE cart_items SET Quantity = Quantity + ?, DateAdded = NOW() WHERE AccountID = ? AND ISBN = ?";
        } else {
            // Sách chưa có trong giỏ hàng, thêm mới
            $query = "INSERT INTO cart_items (AccountID, ISBN, Quantity, DateAdded) VALUES (?, ?, ?, NOW())";
        }

        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        if ($result->num_rows > 0) {
            // Cập nhật số lượng
            $stmt->bind_param('iis', $quantity, $accountId, $isbn);
        } else {
            // Thêm mới
            $stmt->bind_param('isi', $accountId, $isbn, $quantity);
        }

        // Kiểm tra xem việc thêm vào có thành công không
        if ($stmt->execute()) {
            // Redirect to prevent resubmission
            header('Location: gh.php');
            exit();
        } else {
            $message = '<div class="alert alert-danger">Có lỗi xảy ra. Vui lòng thử lại.</div>';
        }

        $stmt->close();
    } else {
        $message = '<div class="alert alert-warning">Số lượng phải lớn hơn 0.</div>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Website giới thiệu sản phẩm</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container">
        <ul class="nav justify-content-end">
            <?php if (isset($_SESSION['RoleID']) && $_SESSION['RoleID'] == 1) { // Quản trị ?>
            <li class="nav-item">
                <a class="nav-link" style="color: #FF00FF;" href="quantri.php">Đến trang quản trị</a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="trangchu.php">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gh.php">Giỏ hàng</a>
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
        <!-- Display message -->
        <?php if (!empty($message)) echo $message; ?>

        <!-- Cart display table -->
        <table class="table table-hover" style="text-align: center;" border='5'>
            <thead>
                <tr>
                    <th>Tài khoản đặt hàng</th>
                    <th>ISBN</th>
                    <th>Tựa đề</th>
                    <th>Giá</th>
                    <th>Số lượng tồn kho</th>
                    <th>Số lượng đặt</th>
                    <th>Thanh toán</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to get cart items
                $sql = "SELECT cart_items.ISBN, books.Title, books.Price, books.Soluong, cart_items.Quantity
                        FROM cart_items
                        JOIN books ON cart_items.ISBN = books.ISBN
                        WHERE cart_items.AccountID = ?";
                
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }

                // Bind parameter and execute
                $stmt->bind_param('i', $accountId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if any rows are returned
                if ($result->num_rows === 0) {
                    echo '<tr><td colspan="7"><img src="./images/giohangtrong.png" alt="No items found" style="width: 100%; max-width: 300px;" /></td></tr>';
                } else {
                    // Display cart items
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($accountId) . '</td>';
                        echo '<td>' . htmlspecialchars($row['ISBN']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Title']) . '</td>';
                        echo '<td>' . htmlspecialchars(number_format($row['Price'], 2)) . ' VND</td>';
                        echo '<td>' . htmlspecialchars($row['Soluong']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Quantity']) . '</td>';
                        echo '<td><a href="checkout.php?isbn=' . htmlspecialchars($row['ISBN']) . '" class="btn btn-primary">Thanh toán</a></td>';
                        echo '</tr>';
                    }
                }

                $stmt->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>