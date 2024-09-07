<?php
// Include database connection
include_once("connect.php");

// Define the default time period and year
$period = isset($_POST['period']) ? $_POST['period'] : 'month';
$selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

// Fetch revenue data based on selected period
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
} else {
    // Handle case where no data is found
    $labels = array_map(function($month) {
        return "<img src='images/khongco.png' alt='No data'>";
    }, $labels);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Chart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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
    <div class="container">
        <h1>Doanh Thu Biểu Đồ</h1>

        <form method="post" action="revenue_chart.php">
            <div class="form-group">
                <label for="period">Chọn thời gian:</label>
                <select id="period" name="period" class="form-control">
                    <option value="month" <?php echo $period == 'month' ? 'selected' : ''; ?>>Theo Tháng</option>
                </select>
            </div>
            <div class="form-group">
                <label for="year">Chọn năm:</label>
                <select id="year" name="year" class="form-control">
                    <option value="<?php echo $selectedYear; ?>"
                        <?php echo $selectedYear == $selectedYear ? 'selected' : ''; ?>><?php echo $selectedYear; ?>
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Xem</button>
        </form>

        <canvas id="revenueChart" width="800" height="400"></canvas>

        <script>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar', // You can also use 'line', 'pie', etc.
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
    </div>
</body>

</html>