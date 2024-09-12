<?php

session_start();

if (!isset($_SESSION["Name"])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION["Role"] == 2) { // Khách hàng
    header("Location: trangchu.php");
    exit();
}

include_once("connect.php");

// Handle record update
if (isset($_POST['update'])) {
    $accountID = intval($_POST['AccountID']);
    $roleID = intval($_POST['RoleID']);

    $updateSql = "UPDATE accounts SET RoleID = ? WHERE AccountID = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $roleID, $accountID);
    if ($stmt->execute()) {
        echo "<script>alert('Role đã cập nhật thành công!'); window.location.href='quanlykhachhang.php';</script>";
    } else {
        echo "<script>alert('Role đã cập nhật lỗi!');</script>";
    }
    $stmt->close();
}

// Load record for editing
$recordToEdit = null;
if (isset($_GET['edit'])) {
    $accountID = intval($_GET['edit']);
    $selectSql = "SELECT * FROM accounts WHERE AccountID = ?";
    $stmt = $conn->prepare($selectSql);
    $stmt->bind_param("i", $accountID);
    $stmt->execute();
    $result = $stmt->get_result();
    $recordToEdit = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    .edit-button {
        cursor: pointer;
        border: none;
        background: none;
    }

    .edit-button img {
        width: 24px;
        height: 24px;
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
        background-color: #007bff;
        /* Bootstrap Primary Color */
        color: #fff;
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

    .navbar-nav .nav-link.active {
        background-color: #007bff;
        /* Highlight active link */
        color: #fff !important;
    }

    .modal-content {
        border-radius: 0.5rem;
    }

    .modal-header {
        background-color: #007bff;
        color: #fff;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
    }

    footer {
        background-color: #f8f9fa;
        padding: 1rem 0;
    }

    .text-dark {
        color: #212529 !important;
    }

    .list-unstyled li {
        margin-bottom: 0.5rem;
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
            <li class="nav-item">
                <a class="nav-link" href="quanlykhachhang.php">Quản lý khách hàng</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Thống kê</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="thongke_anpham.php">Về ấn phẩm</a></li>
                    <li><a class="dropdown-item" href="thongke_doanhthu.php">Về doanh thu</a></li>
                    <li><a class="dropdown-item" href="thongke_solieu.php">Về tồn kho</a></li>
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
        <h2>Quản lý khách hàng</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>AccountID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>RoleID</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM accounts";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["AccountID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Username"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Pass"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["RoleID"]) . "</td>";

                        // Tạo nút chỉnh sửa
                        echo "<td><button type='button' class='edit-button' data-bs-toggle='modal' data-bs-target='#updateModal' 
                            data-accountid='" . htmlspecialchars($row["AccountID"]) . "' 
                            data-username='" . htmlspecialchars($row["Username"]) . "' 
                            data-pass='" . htmlspecialchars($row["Pass"]) . "' 
                            data-roleid='" . htmlspecialchars($row["RoleID"]) . "'>
                            <img src='images/icons8-edit-24.png' alt='Edit'>
                          </button></td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Form Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Chỉnh sửa tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" action="quanlykhachhang.php" method="post">
                        <input type="hidden" name="AccountID" id="modalAccountID">
                        <div class="mb-3">
                            <label for="modalUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="modalUsername" name="Username" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalPass" class="form-label">Password</label>
                            <input type="text" class="form-control" id="modalPass" name="Pass" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalRoleID" class="form-label">RoleID</label>
                            <input type="number" class="form-control" id="modalRoleID" name="RoleID" required>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var accountID = button.getAttribute('data-accountid');
            var username = button.getAttribute('data-username');
            var pass = button.getAttribute('data-pass');
            var roleID = button.getAttribute('data-roleid');

            var modalAccountID = updateModal.querySelector('#modalAccountID');
            var modalUsername = updateModal.querySelector('#modalUsername');
            var modalPass = updateModal.querySelector('#modalPass');
            var modalRoleID = updateModal.querySelector('#modalRoleID');

            modalAccountID.value = accountID;
            modalUsername.value = username;
            modalPass.value = pass;
            modalRoleID.value = roleID;
        });
    });
    </script>

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

    <!-- màu đen  -->
    <span style="color: #000000;">
        <footer class="container-fluid text-center">
            <p>© 2021 Bản quyền thuộc về Team Code K17</p>
        </footer>
    </span>
</body>

</html>