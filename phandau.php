<?php
session_start();
//echo $_SESSION["Role"];
//1-Kết nối cơ sở dữ liệu
include_once 'connect.php';

?>


<!DOCTYPE html>
<html>

<head>
    <title>Website cửa hàng sách online</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./CSS/css.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
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

    <div class="container ">
        <ul class="nav justify-content-end ">
            <?php if ($_SESSION['Role'] == 1) {//Quản trị
      ?>

            <li class="nav-item">
                <a class="nav-link" style="color: #FF00FF;" href="quantri.php">Đến trang quản trị</a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="trangchu.php">Trang chủ</a>
            </li>
            <li class="nav-item">
            <li><a class="nav-link" href="donhang.php">Đơn hàng</a></li>
            </li>

            <li class="nav-item">
            <li><a class="nav-link" href="giohang.php">Giỏ hàng</a></li>
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
            <!--<li class="nav-item">
		<a class="nav-link" href="#">Liên hệ</a>
	  </li>	-->
            <?php if (isset($_SESSION['Name']) == 0) { ?>
            <li><a class="nav-link" href="registry.php">Đăng ký</a></li>
            <li><a class="nav-link" href="login.php">Đăng nhập</a></li>
            </li>
            <?php } else { ?>
            <li><a class="nav-link" href="logout.php?flag=1">Đăng xuất</a></li>
            <li><a class="nav-link" href="#"><?php echo 'Xin chào ' .
        $_SESSION['Name'] .
        '!'; ?></a>
                <?php } ?>
        </ul>
        <!-- thiết kế logo và nút tìm kiếm-->
        <div class="row align-items-center">
            <div class="col">
                <a target="#" href="trangchu.php">
                    <img width="70" height="70" src="images/logo1.jpg" alt="TRƯỜNG ĐHCN HCM">
                </a>
            </div>
            <div class="col">
                <form class="example" action="trangchu.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Nhập tên sách cần tìm.." name="search">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <?php
        
 // Kiểm tra xem đã nhập từ khóa tìm kiếm hay chưa
 if (isset($_GET['search']) && !empty($_GET['search'])) {
     // Lấy từ khóa tìm kiếm từ biểu mẫu

     $search = $_GET['search'];

     // Xử lý tìm kiếm ở đây
     echo "<p class='text-center'>Kết quả tìm kiếm cho: " .
         htmlspecialchars($search) .
         '</p>';

     //$sql = "SELECT * FROM books WHERE Title = '$search'";
 }
 if (isset($_GET['search']) && empty($_GET['search'])) {
     // Thông báo không có
     echo "<p class='text-center'>Vui lòng nhập từ khóa tìm kiếm.</p>";
 }
 ?>
        <div class="row">
            <div class="col-sm-4">
                <a class="nav nav-tabs" href="trangchu.php">Tất Cả Sản Phẩm</a>
                <a class="nav nav-tabs" href="trangchu.php?category=5">Sách Văn Học Việt Nam</a>
                <a class="nav nav-tabs" href="trangchu.php?category=6">Sách Văn Học Nước Ngoài</a>
                <a class="nav nav-tabs" href="trangchu.php?category=7">Truyện Cổ Tích - Thần Thoại</a>
                <a class="nav nav-tabs" href="trangchu.php?category=8">Sách Ngôn Ngữ Lập Trình</a>
                <a class="nav nav-tabs" href="trangchu.php?category=9">Sách Giáo Khoa - Giảng Dạy</a>
                <a class="nav nav-tabs" href="trangchu.php?category=10">Sách Y Khoa</a>
            </div>
            <div class="col-sm-8">
                <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
            //Select dữ liệu từ bảng books
            //1- Kết nối cơ sở dữ liệu
            include_once 'connect.php';

            //2- Viết câu truy vấn
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                // $category = $_GET["category"];
                $sql = "SELECT * FROM books WHERE Title = '$search'";
            } else {
                if (isset($_GET['category'])) {
                    $category = $_GET['category'];
                    $sql = "SELECT * FROM books WHERE CategoryID='$category'";
                } else {
                    // hiển thị tất cả sách
                    $sql = 'SELECT * FROM books';
                }
            }

            //3-Thực thi câu truy vấn, nhận kết quả trả về
            $result = $conn->query($sql);

            // 4 - Kiểm tra dữ liệu và hiển kết quả nếu có mẩu tin
            if ($result->num_rows > 0) {
                $count = 0;
                $slideCount = 0;
                $active = 'active'; // Set the first slide as active
                echo '<div class="carousel-item ' .
                    $active .
                    '"><div class="row">';
                // Loop through the rows and display the books
                while ($row = $result->fetch_assoc()) {
                    // Start a new row if the count is multiple of 10
                    if ($count % 10 == 0 && $count != 0) {
                        echo '</div></div>'; // Close the current row and slide
                        $slideCount++;
                        $active = ''; // Remove active class for subsequent slides
                        echo '<div class="carousel-item ' .
                            $active .
                            '"><div class="row">';
                    }
                    echo "<div class='book col-md-2'>";
                    echo "<a href='chitiet_sach.php?txtISBN=" .
                        $row['ISBN'] .
                        "'>";
                    echo "<img width='100' height='100' src='images/" .
                        $row['Picture'] .
                        "' alt=''>";
                    echo '<p>' . $row['Price'] . '</p>';
                    echo '</a>';
                    echo '</div>';
                    $count++;
                }
                echo '</div></div>'; // Close
            } else {
                // không có sách
                echo '<p>0 quyển sách</p>';
            }
            ?>
                    </div>
                    <br>
                    <ol class="carousel-indicators custom-indicators">
                        <?php if (!empty($slideCount)) {
      for ($i = 0; $i <= $slideCount; $i++) {
          $active = $i == 0 ? 'active' : ''; // active cho phần đầu tiên
          echo '<a data-bs-target="#bookCarousel" data-bs-slide-to="' .
              $i .
              '" class="' .
              $active .
              '"></a>';
      }
  } ?>
                    </ol>
                </div>
            </div>
        </div>
        <h4>SÁCH HAY:</h4>
        <div class="container">
            <div class="row">
                <?php
        // Viết câu truy vấn
        if (isset($_GET['category'])) {
            $sql = "SELECT * FROM books WHERE CategoryID='$category' ORDER BY ISBN DESC LIMIT 5";
        } else {
            $sql = 'SELECT * FROM books ORDER BY ISBN DESC LIMIT 5';
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="book col-md-2">';
                echo '<a href="chitiet_sach.php?txtISBN=' . $row['ISBN'] . '">';
                echo '<img width="70" height="70" src="images/' .
                    $row['Picture'] .
                    '" alt="">';
                echo '<p>' . $row['Price'] . '</p>';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>Không có sản phẩm nào.</p>';
        }
        ?>
            </div>
        </div>
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
                    <li><a target="#" href="donhang.php" style="color: #000000">Đơn hàng</a></li>

                </ul>
            </div>
            <div class="col">
                <div>
                    <a href="http://online.gov.vn/Home/WebDetails/19168">
                        <img src="./images/bocongthuong.png" width="230" height="90">
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