<?php
include_once("qt_phandau.php");
include_once("connect.php");

// Define the default time period and year
$period = isset($_POST['period']) ? $_POST['period'] : 'month';
$selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

// Fetch revenue data based on the selected period
$sql = "SELECT DATE_FORMAT(DateTran, '%Y-%m') as period, SUM(Amount) as total 
        FROM orders 
        WHERE DATE_FORMAT(DateTran, '%Y') = ? 
        GROUP BY DATE_FORMAT(DateTran, '%Y-%m') 
        ORDER BY period";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $selectedYear);
$stmt->execute();
$result = $stmt->get_result();

$months = [
    '01' => 'January', '02' => 'February', '03' => 'March',
    '04' => 'April', '05' => 'May', '06' => 'June',
    '07' => 'July', '08' => 'August', '09' => 'September',
    '10' => 'October', '11' => 'November', '12' => 'December'
];

$data = array_fill_keys(array_keys($months), 0); // Initialize all months with zero
$labels = array_values($months);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $month = substr($row['period'], 5, 2); // Extract month part
        $data[$month] = $row['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng doanh thu và Số lượng ấn phẩm theo danh mục</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .doanhthu {
        margin-top: 20px;
        font-size: 40px;
        font-weight: bold;
        color: #ff5733;
    }

    .toggle-button {
        margin-top: 20px;
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

    .revenue-section,
    .chart-section {
        display: none;
        margin-top: 20px;
    }

    .container {
        margin-top: 20px;
    }

    .missing-data {
        width: 20px;
        height: 20px;
    }
    </style>
</head>

<body>
    <h1>Doanh thu</h1>

    <!-- Button to toggle the revenue table -->
    <button class="toggle-button" onclick="toggleRevenueTable()">Hiển thị/Ẩn bảng doanh thu</button>

    <br>

    <!-- Button to toggle the chart -->
    <button class="toggle-button" onclick="toggleChart()">Hiển thị/Ẩn biểu đồ doanh thu</button>

    <!-- Revenue Table Section -->
    <div class="revenue-section">
        <?php
            // Fetching order details and displaying the table
            $sql = "SELECT o.OrderID, a.Username, o.Amount, o.DateTran, i.ISBN, b.Title, b.Price, i.Prices, i.Quantity
                    FROM orders o
                    INNER JOIN order_items i ON o.OrderID = i.OrderID
                    INNER JOIN accounts a ON o.AccountID = a.AccountID
                    INNER JOIN books b ON i.ISBN = b.ISBN";

            $result = $conn->query($sql);
            $doanhthu = 0; // Initialize total revenue

            if ($result->num_rows > 0) {
                echo "<table class='table table-hover table-bordered'>
                        <tr class='table-danger'>
                            <th>OrderID</th>
                            <th>Tên tài khoản đặt hàng</th>
                            <th>Ngày đặt</th>
                            <th>ISBN</th>
                            <th>Tên Sách</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["OrderID"] . "</td>";
                    echo "<td>" . $row["Username"] . "</td>";
                    echo "<td>" . $row["DateTran"] . "</td>";
                    echo "<td>" . $row["ISBN"] . "</td>";
                    echo "<td>" . $row["Title"] . "</td>";
                    echo "<td>" . $row["Price"] . "</td>";
                    echo "<td>" . $row["Quantity"] . "</td>";
                    echo "<td>" . $row["Prices"] . "</td>";
                    echo "</tr>";
                    $doanhthu += $row["Prices"];
                }
                echo "</table>";
                echo "<div class='doanhthu'>Tổng doanh thu: " . $doanhthu . "</div>";
            } else {
                echo "Không có đơn hàng nào.";
            }
        ?>
    </div>

    <!-- Chart Section -->
    <div class="chart-section">
        <div class="container">
            <h2>Doanh Thu Biểu Đồ</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="year">Chọn năm:</label>
                    <select id="year" name="year" class="form-control">
                        <option value="<?php echo $selectedYear; ?>" selected><?php echo $selectedYear; ?></option>
                        <!-- Add more years here if needed -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Xem</button>
            </form>

            <canvas id="revenueChart" width="800" height="400"></canvas>
        </div>
    </div>

    <script>
    function toggleRevenueTable() {
        const table = document.querySelector('.revenue-section');
        table.style.display = table.style.display === 'none' || table.style.display === '' ? 'block' : 'none';
    }

    function toggleChart() {
        const chart = document.querySelector('.chart-section');
        chart.style.display = chart.style.display === 'none' || chart.style.display === '' ? 'block' : 'none';
    }

    // Render the Chart.js bar chart
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Doanh Thu',
                data: <?php echo json_encode(array_values($data)); ?>,
                backgroundColor: function(context) {
                    var index = context.dataIndex;
                    return <?php echo json_encode(array_map(function($value) {
                                return $value === 0 ? 'rgba(255, 99, 132, 0.2)' : 'rgba(75, 192, 192, 0.2)';
                            }, array_values($data))); ?>[index];
                },
                borderColor: function(context) {
                    var index = context.dataIndex;
                    return <?php echo json_encode(array_map(function($value) {
                                return $value === 0 ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)';
                            }, array_values($data))); ?>[index];
                },
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
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