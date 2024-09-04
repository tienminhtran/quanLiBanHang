<?php
include_once("connect.php");

$ten = $mk = $q = "";
$message = ""; // Để lưu thông báo lỗi hoặc thành công

if (isset($_POST["sbDangKy"])) {
    $ten = $_POST["uname"];
    $mk = md5($_POST["pswd"]); // Mã hóa mật khẩu
    $q = "2"; // Giá trị RoleID mặc định

    // Kiểm tra xem Username đã tồn tại chưa
    $checkSql = "SELECT Username FROM accounts WHERE Username = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('s', $ten);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Tên đăng nhập đã tồn tại
        $message = '<div class="alert alert-danger" role="alert">Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.</div>';
    } else {
        // Thực hiện INSERT nếu Username chưa tồn tại
        $sql = "INSERT INTO accounts (Username, Pass, RoleID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $ten, $mk, $q);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $message = '<div class="alert alert-danger" role="alert">Lỗi truy vấn: ' . $stmt->error . '</div>';
        }
    }

    $checkStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng ký tài khoản</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        max-width: 600px;
        margin-top: 50px;
    }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h3 class="mb-4">Đăng ký tài khoản mua hàng</h3>

        <?php echo $message; // Hiển thị thông báo ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="uname" class="form-label">Username (Nên nhập số điện thoại):</label>
                <input type="text" class="form-control" id="uname" placeholder="Nhập username" name="uname"
                    value="<?php echo htmlspecialchars($ten); ?>" required>
                <div class="valid-feedback">Hợp lệ.</div>
                <div class="invalid-feedback">Vui lòng điền đủ thông tin.</div>
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Nhập mật khẩu" name="pswd" required>
                <div class="valid-feedback">Hợp lệ.</div>
                <div class="invalid-feedback">Vui lòng điền đủ thông tin.</div>
            </div>
            <button type="submit" class="btn btn-primary" name="sbDangKy">Tạo tài khoản</button>
        </form>
    </div>

</body>

</html>