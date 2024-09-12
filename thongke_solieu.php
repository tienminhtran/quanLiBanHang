<?php
// session_start();
	include_once("qt_phandau.php");
// Include database connection
if(!isset($_SESSION["Name"]))
{
header("Location:login.php");
}
if($_SESSION["Role"]==2)//Khách hàng
{
header("Location:trangchu.php");
}

include_once("connect.php");

// Fetch category names and total stock
$sql = "SELECT c.Name AS category_name, COALESCE(SUM(b.Soluong), 0) AS total_stock
FROM categories c
LEFT JOIN books b ON c.CategoryID = b.CategoryID
GROUP BY c.CategoryID";

$result = $conn->query($sql);

$categories = [];
$quantities = [];

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$categories[] = $row['category_name'];
$quantities[] = $row['total_stock'];
}
} else {
$categories = ["No Data"];
$quantities = [0];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục tồn kho</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .container {
        margin-top: 20px;
    }

    canvas {
        max-width: 100%;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Số lượng sản phẩm tồn theo danh mục</h1>
        <canvas id="stockChart" width="800" height="400"></canvas>

        <script>
        var ctx = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctx, {
            type: 'bar', // Column chart
            data: {
                labels: <?php echo json_encode($categories); ?>,
                datasets: [{
                    label: 'Stock Quantity',
                    data: <?php echo json_encode($quantities); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: '#000',
                            font: {
                                size: 14
                            }
                        },
                        title: {
                            display: true,
                            text: 'Danh mục sản phẩm',
                            color: '#000',
                            font: {
                                size: 16
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#000',
                            font: {
                                size: 14
                            }
                        },
                        title: {
                            display: true,
                            text: 'Số lượng tồn',
                            color: '#000',
                            font: {
                                size: 16
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#000',
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            }
        });
        </script>
    </div>
</body>
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
<span style="color: #000000	;">
    <footer class="container-fluid text-center">
        <p>© 2021 Bản quyền thuộc về Team Code K17</p>
    </footer>
    </div>

</html>