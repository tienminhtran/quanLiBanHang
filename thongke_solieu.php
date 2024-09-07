<?php
// Include database connection
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
    <title>Category Stock Chart</title>
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

</html>