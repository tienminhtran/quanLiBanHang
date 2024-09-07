<?php
session_start();
require 'connect.php'; // Include your database connection

// Initialize a message variable
$message = '';

// Check if the user is logged in and get AccountID
if (isset($_SESSION['Name'])) {
    $username = $_SESSION['Name'];
    $sql = "SELECT AccountID FROM accounts WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed for AccountID query: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die('Error: Account not found.');
    }
    $row = $result->fetch_assoc();
    $accountId = $row['AccountID'];
    $stmt->close();
} else {
    $message = '<div class="alert alert-danger">Bạn chưa đăng nhập.</div>';
    exit; // Stop further execution if not logged in
}

// Handle adding items to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sbgiohang'])) {
    $isbn = isset($_POST['txtISBN']) ? htmlspecialchars($_POST['txtISBN']) : '';
    $quantity = isset($_POST['txtSoLuongGH']) ? intval($_POST['txtSoLuongGH']) : 0;

    if ($quantity > 0) {
        $query = "SELECT Quantity FROM cart_items WHERE AccountID = ? AND ISBN = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die('Prepare failed for cart_items select query: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param('is', $accountId, $isbn);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $query = "UPDATE cart_items SET Quantity = Quantity + ?, DateAdded = NOW() WHERE AccountID = ? AND ISBN = ?";
        } else {
            $query = "INSERT INTO cart_items (AccountID, ISBN, Quantity, DateAdded) VALUES (?, ?, ?, NOW())";
        }

        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die('Prepare failed for cart_items insert/update query: ' . htmlspecialchars($conn->error));
        }

        if ($result->num_rows > 0) {
            $stmt->bind_param('iis', $quantity, $accountId, $isbn);
        } else {
            $stmt->bind_param('isi', $accountId, $isbn, $quantity);
        }

        if ($stmt->execute()) {
            header('Location: giohang.php');
            exit();
        } else {
            $message = '<div class="alert alert-danger">Có lỗi xảy ra. Vui lòng thử lại.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert alert-warning">Số lượng phải lớn hơn 0.</div>';
    }
}

// Handle cart actions (delete, update, payment)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $selectedISBNs = isset($_POST['selected-isbns']) ? explode(',', $_POST['selected-isbns']) : [];

    if ($action === 'delete' && !empty($selectedISBNs)) {
        foreach ($selectedISBNs as $isbn) {
            $sql = "DELETE FROM cart_items WHERE ISBN = ? AND AccountID = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die('Prepare failed for cart_items delete query: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('si', $isbn, $accountId);
            if ($stmt->execute()) {
                $message = 'Đã xóa thành công các mục đã chọn.';
            } else {
                $message = 'Không thể xóa mục: ' . htmlspecialchars($isbn);
            }
            $stmt->close();
        }
    } elseif ($action === 'update') {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'quantity_') === 0) {
                $isbn = str_replace('quantity_', '', $key);
                $quantity = intval($value);

                // Check stock quantity
                $sql = "SELECT Soluong FROM books WHERE ISBN = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die('Prepare failed for books select query: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param('s', $isbn);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stockQuantity = $row['Soluong'];
                $stmt->close();

                if ($quantity > $stockQuantity) {
                    $message = 'Số lượng yêu cầu vượt quá số lượng tồn kho cho ISBN ' . htmlspecialchars($isbn);
                    break;
                }

                // Update quantity in the database
                $sql = "UPDATE cart_items SET Quantity = ? WHERE AccountID = ? AND ISBN = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die('Prepare failed for cart_items update query: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param('iis', $quantity, $accountId, $isbn);
                if (!$stmt->execute()) {
                    $message = 'Lỗi cập nhật số lượng cho ISBN ' . htmlspecialchars($isbn);
                }
                $stmt->close();
            }
        }
        if (empty($message)) {
            $message = 'Cập nhật thành công!';
        }
    }
    if ($action === 'payment' && !empty($selectedISBNs)) {
        // Calculate the total amount of the order
        $totalAmount = 0;
        $orderItems = [];
    
        foreach ($selectedISBNs as $isbn) {
            // Retrieve price and quantity from the cart
            $sql = "SELECT Price, Quantity FROM cart_items JOIN books ON cart_items.ISBN = books.ISBN WHERE cart_items.AccountID = ? AND cart_items.ISBN = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die('Prepare failed for order items query: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('is', $accountId, $isbn);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $price = (float) $row['Price']; // Cast to float to ensure correct multiplication
                $quantity = (int) $row['Quantity']; // Cast to integer to ensure correct multiplication
    
                // Debug: Print price and quantity for each item
                echo "ISBN: $isbn, Price: $price, Quantity: $quantity<br>";
    
                $totalAmount += $price * $quantity;
                $orderItems[] = ['isbn' => $isbn, 'quantity' => $quantity, 'price' => $price];
            }
            $stmt->close();
        }
    
        // Debug: Print total amount before inserting into the orders table
        echo "Total Amount: $totalAmount<br>";
    
        // Insert the order into the orders table
        $dateTran = date('Y-m-d');
        $sql_dathang = "INSERT INTO orders (AccountID, Amount, DateTran) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_dathang);
        if (!$stmt) {
            die('Prepare failed for orders insert query: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param('ids', $accountId, $totalAmount, $dateTran);
        if ($stmt->execute()) {
            $orderId = $conn->insert_id; // Get the newly created OrderID
        } else {
            die('Error: Could not create order. ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
    
        // Insert items into the order_items table
        foreach ($orderItems as $item) {
            $sql_hoadon = "INSERT INTO order_items (ISBN, OrderID, Prices, Quantity) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_hoadon);
            if (!$stmt) {
                die('Prepare failed for order_items insert query: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('sidi', $item['isbn'], $orderId, $item['price'], $item['quantity']);
            if (!$stmt->execute()) {
                die('Error: Could not insert order items. ' . htmlspecialchars($stmt->error));
            }
            $stmt->close();
    
            // Update the stock quantity in the books table
            $sql_soluong = "UPDATE books SET Soluong = Soluong - ? WHERE ISBN = ?";
            $stmt = $conn->prepare($sql_soluong);
            if (!$stmt) {
                die('Prepare failed for books update query: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('is', $item['quantity'], $item['isbn']);
            if (!$stmt->execute()) {
                die('Error: Could not update stock quantity. ' . htmlspecialchars($stmt->error));
            }
            $stmt->close();
        }
    
        // Delete paid items from the cart
        foreach ($selectedISBNs as $isbn) {
            $sql = "DELETE FROM cart_items WHERE ISBN = ? AND AccountID = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die('Prepare failed for cart_items delete query: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('si', $isbn, $accountId);
            $stmt->execute();
            $stmt->close();
        }
    
        // Display a success message
        $message = '<div class="alert alert-success">Thanh toán thành công!</div>';
    }
    
    else {
            $message = 'Vui lòng chọn ít nhất một mục để thanh toán.';
        }
       
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .action-container {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .form-select {
        border: 2px solid #007bff;
        border-radius: 4px;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-select:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        transition: background-color 0.3s, border-color 0.3s;
        width: 200px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-primary:focus,
    .btn-primary.focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
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
        <!-- Action Select -->
        <form method="post" id="cart-form">
            <div class="action-container d-flex align-items-center">
                <select id="actionSelect" class="form-select me-2" name="action">
                    <option value="">-- Chọn hành động --</option>
                    <option value="delete">Xóa</option>
                    <option value="update">Thay đổi</option>
                    <option value="payment">Thanh toán</option>
                </select>
                <button id="apply-action" class="btn btn-primary">Áp dụng</button>
            </div>
            <input type="hidden" name="selected-isbns" id="selected-isbns">

            <!-- Display message -->
            <?php if (!empty($message)) echo '<div class="alert alert-info">' . $message . '</div>'; ?>

            <!-- Cart display table -->
            <table class="table table-hover" style="text-align: center;" border='5'>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Tài khoản đặt hàng</th>
                        <th>ISBN</th>
                        <th>Tựa đề</th>
                        <th>Giá</th>
                        <th>Số lượng tồn kho</th>
                        <th>Số lượng đặt</th>
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
                            echo '<td><input type="checkbox" class="select-item" data-isbn="' . htmlspecialchars($row['ISBN']) . '"></td>';
                            echo '<td>' . htmlspecialchars($accountId) . '</td>';
                            echo '<td>' . htmlspecialchars($row['ISBN']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['Title']) . '</td>';
                            echo '<td>' . htmlspecialchars(number_format($row['Price'], 2)) . ' VND</td>';
                            echo '<td>' . htmlspecialchars($row['Soluong']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['Quantity']) . '</td>';
                            echo '</tr>';
                        }
                    }

                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Modal for updating quantities -->
    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Cập nhật số lượng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="update-form">
                    <div class="modal-body" id="update-items">
                        <!-- Dynamic update items will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
    // Select/Deselect all checkboxes
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.select-item');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Apply action button click event
    document.getElementById('apply-action').addEventListener('click', function(event) {
        event.preventDefault();

        // Get selected action from dropdown
        const action = document.getElementById('actionSelect').value;

        if (!action) {
            alert('Vui lòng chọn một hành động.');
            return;
        }

        // Get all selected ISBNs
        const selectedCheckboxes = document.querySelectorAll('.select-item:checked');
        const selectedISBNs = Array.from(selectedCheckboxes).map(checkbox => checkbox.dataset.isbn);

        if (selectedISBNs.length === 0) {
            alert('Vui lòng chọn ít nhất một mục.');
            return;
        }

        // Set hidden input with selected ISBNs
        document.getElementById('selected-isbns').value = selectedISBNs.join(',');


        // tác vụ 2: cập nhật

        // tác vụ 2: cập nhật
        if (action === 'update') {
            // Show update modal
            const updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();

            // Populate modal with items
            const updateItemsContainer = document.getElementById('update-items');
            updateItemsContainer.innerHTML = '';
            selectedISBNs.forEach(isbn => {
                const row = document.querySelector(`.select-item[data-isbn="${isbn}"]`).closest('tr');
                const quantity = row.cells[5].textContent.trim();
                const title = row.cells[2].textContent.trim();
                const price = row.cells[4].textContent.trim();
                const stockQuantity = row.cells[5].textContent.trim();

                const html = `
                <div class="mb-3">
                    <label for="quantity_${isbn}" class="form-label">Số lượng bạn muốn thay đổi cho ISBN ${isbn} - ${title} (Giá: ${price}, Tồn kho: ${stockQuantity})</label>
                    <input type="number" class="form-control" id="quantity_${isbn}" name="quantity_${isbn}" value="${quantity}" min="1" max="${stockQuantity}" data-stock="${stockQuantity}">
                    <div class="invalid-feedback"></div>
                </div>
            `;
                updateItemsContainer.innerHTML += html;
            });
        } else {
            // Confirm delete action
            if (action === 'delete' && !confirm('Bạn có chắc chắn muốn xóa các mục đã chọn không?')) {
                return;
            }

            // Submit the form
            document.getElementById('cart-form').submit();
        }
    });

    // Handle update form submission
    document.getElementById('update-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Check stock quantity
        let valid = true;
        const updateItems = document.querySelectorAll('#update-items input[type="number"]');

        updateItems.forEach(input => {
            const stockQuantity = parseInt(input.dataset.stock, 10);
            const enteredQuantity = parseInt(input.value, 10);

            if (enteredQuantity > stockQuantity) {
                valid = false;
                input.classList.add('is-invalid'); // Add Bootstrap invalid class
                input.nextElementSibling.innerHTML = `Số lượng không được vượt quá ${stockQuantity}.`;
            } else {
                input.classList.remove('is-invalid');
                input.nextElementSibling.innerHTML = ''; // Clear previous error message
            }
        });

        if (!valid) {
            return; // Prevent form submission if there are invalid quantities
        }

        // Get all update quantities
        const formData = new FormData(this);

        // Append selected ISBNs
        formData.append('selected-isbns', document.getElementById('selected-isbns').value);
        formData.append('action', 'update');

        fetch('giohang.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
            .then(result => {
                // Display result in alert
                alert('Cập nhật thành công.');

                // Hide the modal
                const updateModal = bootstrap.Modal.getInstance(document.getElementById('updateModal'));
                updateModal.hide();

                // Reload the page
                location.reload();
            })
            .catch(error => {
                console.error('Có lỗi xảy ra:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
    });
    </script>

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