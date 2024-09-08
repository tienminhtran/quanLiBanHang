<?php
// Include the database connection file
include_once("qt_phandau.php");
include_once("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sách và Danh Mục</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .table-container {
        margin: 20px auto;
        max-width: 1200px;
    }

    .book-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }

    .toggle-button {
        margin: 20px 10px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
    }

    .toggle-button:hover {
        background-color: #0056b3;
    }

    .table-section {
        display: none;
        margin-top: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .table-hover tr:hover {
        background-color: #f1f1f1;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-danger th {
        background-color: #ffdddd;
    }

    h2,
    h3 {
        color: #333;
        margin-top: 20px;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center">Quản lý Sách và Danh Mục</h1>

        <!-- Button to toggle the books table -->
        <button class="toggle-button" onclick="toggleSection('booksSection')">Hiển thị/Ẩn Bảng Sách</button>
        <br>

        <!-- Button to toggle the categories table -->
        <button class="toggle-button" onclick="toggleSection('categoriesSection')">Hiển thị/Ẩn Bảng Danh Mục</button>

        <!-- Books Table Section -->
        <div id="booksSection" class="table-section">
            <?php
            // Query to fetch data from the books table
            $sqlBooks = "SELECT ISBN, Author, Title, Price, Description, CategoryID, Picture, Soluong FROM books";
            $resultBooks = $conn->query($sqlBooks);

            if ($resultBooks->num_rows > 0) {
                echo "<h3>Danh sách Sách</h3>";
                echo "<table class='table table-hover table-bordered'>";
                echo "<thead class='thead-dark'>";
                echo "<tr>
                        <th>ISBN</th>
                        <th>Tác Giả</th>
                        <th>Tiêu Đề</th>
                        <th>Giá</th>
                        <th>Mô Tả</th>
                        <th>ID Danh Mục</th>
                        <th>Số Lượng</th>
                      </tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $resultBooks->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['ISBN']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Author']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                    echo "<td>" . number_format($row['Price'], 2) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['CategoryID']) . "</td>";
           
                    echo "</td>";
                    echo "<td>" . htmlspecialchars($row['Soluong']) . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>Không có dữ liệu trong bảng sách.</p>";
            }
            ?>
        </div>

        <!-- Categories Table Section -->
        <div id="categoriesSection" class="table-section">
            <?php
            // Query to fetch the number of publications by category
            $sqlCategories = "SELECT c.Name, count(b.ISBN) AS SoLuong 
                              FROM books b 
                              INNER JOIN categories c ON b.CategoryID = c.CategoryID 
                              GROUP BY c.CategoryID";
            $resultCategories = $conn->query($sqlCategories);

            if ($resultCategories->num_rows > 0) {
                echo "<h3>Thống kê số lượng ấn phẩm theo từng danh mục</h3>";
                echo "<table class='table table-hover table-bordered'>
                        <tr class='table-danger'>
                            <th>Danh mục</th>
                            <th>Số lượng ấn phẩm</th>
                        </tr>";
                while ($row = $resultCategories->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["Name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["SoLuong"]) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Không có dữ liệu thỏa mãn điều kiện thống kê.</p>";
            }

            // Close the connection if it's open and valid
            if (isset($conn) && $conn instanceof mysqli) {
                $conn->close();
            }
            ?>
        </div>
    </div>

    <script>
    function toggleSection(sectionId) {
        const section = document.getElementById(sectionId);
        section.style.display = section.style.display === 'none' || section.style.display === '' ? 'block' : 'none';
    }
    </script>

</body>
<!--Phần chân trang-->
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



</html>