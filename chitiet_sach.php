<?php
session_start();
//echo $_SESSION["Role"];
//1-Kết nối cơ sở dữ liệu
include_once 'connect.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Website giới thiệu sản phẩm ...</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="trangchu.php">Trang chủ</a>
            </li>
            <li class="nav-item">
            <li><a class="nav-link" href="donhang.php">Đơn hàng</a></li>
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


    </div>
</body>

</html>

<div class="container ">
    <?php
//1 - Nhận mã ISBN được gửi từ liên kết
$isbn = '';
if (isset($_GET['ma'])) {
    $isbn = $_GET['ma'];
}

//2- Select dữ liệu từ bảng books với điều kiện ISBN = $isbn
$isbn = '';
$isbn = $_GET['txtISBN'];
$sql = "SELECT books.ISBN,books.Title,books.Author,books.Price,books.Description,books.Picture,books.Soluong,categories.Name FROM books,categories
	WHERE ISBN = '$isbn' AND books.CategoryID=categories.CategoryID";
$result = $conn->query($sql);

$isbn_val = $cate_val = $title_val = $author_val = $price_val = $des_val = $picture_val = $souong_val =
    '';
//echo $sql;
$row = $result->fetch_assoc();
$isbn_val = $row['ISBN'];
$cate_val = $row['Name'];
$title_val = $row['Title'];
$author_val = $row['Author'];
$price_val = $row['Price'];
$des_val = $row['Description'];
$picture_val = $row['Picture'];
$soluong_val = $row['Soluong'];

$sql2 = "SELECT *FROM Photos WHERE ISBN = '$isbn'";
$result = $conn->query($sql2);
?>

    <!--Thiết kế form chi tiết mua một quyển sách - books-->
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <fieldset>
                <legend>Thông tin sản phẩm:</legend>
                <div class="row">
                    <div class="col-md-6">
                        <img src="images/<?php echo $picture_val; ?>" alt="Ảnh sách" class="img-fluid" width="60%"
                            height="60%">
                        <br><br>
                        <p>
                            <?php while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo "<td><img width='50' height='70' src='images/" .
          $row['Names'] .
          "'></td>";
      echo '</tr>';
      echo '<tr><td>&nbsp&nbsp&nbsp;</td></tr>'; // Thêm khoảng cách sau mỗi ảnh
  } ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h3><?php echo 'Tên sách: ' . $title_val; ?></h3>
                        <p><b>Thông tin tác giả:</b> <?php echo $author_val; ?></p>
                        <p><b>Thể loại:</b> <?php echo $cate_val; ?></p>
                        <p><b>Số lượng tồn:</b> <?php echo $soluong_val; ?></p>
                        <p><b>Giá bán:</b> <?php echo $price_val; ?> VND</p>
                        <p><b>Mô tả sản phẩm:</b></p>
                        <p><?php echo $des_val; ?></p>
                        <form name="frmThemhang" action="giohang.php" method="post">
                            <div class="mb-3 mt-3">
                                <label for="txtSoLuongMua" class="form-label"><b>Nhập số lượng sách cần
                                        mua:</b></label>
                                <input type="text" class="form-control" id="txtSoLuongMua"
                                    placeholder="Nhập số lượng sách cần mua" name="txtSoLuongMua" required>
                            </div>
                            <input type="hidden" name="txtISBN" value="<?php echo $isbn_val; ?>">
                            <input type="hidden" name="slDanhMuc" value="<?php echo $cate_val; ?>">
                            <!-- Các trường thông tin sách .... -->


                            <div class="mb-3 mt-3">
                                <input class="btn btn-danger me-5" type="submit" name="sbThemhang" value="Mua Hàng">
                                <!-- <a class="btn btn-primary" href="trangchu.php">Quay lại trang chủ</a> -->
                            </div>
                        </form>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-sm-2"></div>
    </div>


    <?php include_once 'phanchan.php';
?>
    <div class="container ">
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
</div>