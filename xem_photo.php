<?php
    include_once("qt_phandau.php");

    // Nhận mã ISBN được gửi từ liên kết
    $isbn = $_GET["ma"];

    // Sử dụng Prepared Statements để tránh SQL Injection
    $stmt = $conn->prepare("SELECT * FROM Photos WHERE ISBN = ?");
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2 class='text-uppercase'>Quyển sách có mã ISBN là " . htmlspecialchars($isbn) . "</h2>";
        echo "<a class='btn btn-success mb-3' href='them_photo.php?ma=" . urlencode($isbn) . "'>Thêm</a>";
        echo "<h4 class='border-bottom pb-2'>Album hình ảnh</h4>";
        echo "<table class='table table-hover'>";
        echo "<thead><tr><th>PhotoID</th><th>Ảnh</th><th>Sửa</th><th>Xóa</th></tr></thead><tbody>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["PhotoID"]) . "</td>";
            echo "<td><img width='50' src='images/" . htmlspecialchars($row["Names"]) . "' alt=''></td>";
            echo "<td><a class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc xóa không?\");' href='xoa_photo.php?ma=" . urlencode($row["PhotoID"]) . "'>Xóa</a></td>";
            echo "<td><a class='btn btn-warning btn-sm' href='sua_photo.php?ma=" . urlencode($row["PhotoID"]) . "'>Sửa</a></td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>Chưa có Album ảnh</div>";
        echo "<a href='sach.php' class='btn btn-primary'>Quay lại</a>";
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();

    include_once("qt_phandau.php");
?>
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