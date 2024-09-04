<?php
session_start();
//echo $_SESSION["Role"];
//1-Kết nối cơ sở dữ liệu
include_once 'connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
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
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="trangchu.php">Trang chủ</a>
            </li>
            <!-- <li class="nav-item">
            <li><a class="nav-link" href="donhang.php">Đơn hàng</a></li>
            </li> -->
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
// session_start();


// //1- Kết nối cơ sở dữ liệu
// include_once("connect.php");

//2- Viết câu truy vấn
	$isbn="";
if(isset($_POST['sbThemhang'])) {
	$isbn = $_POST['txtISBN']; 					//lấy được ISBN
    $soLuongMua = $_POST['txtSoLuongMua'];    //lấy được số lượng sách mua
    $dateTran = date("Y-m-d");
    $amount = "1";
    $accountId = $_SESSION["Account"];
	$name= $_SESSION["Name"];
}
?>

    <table class="table table-hover" style="text-align: center;" border='5'>
        <tr>
            <th>Tài khoản đặt hàng</th>
            <th>ISBN</th>
            <th>Tựa đề</th>
            <th>Giá</th>
            <th>Số lượng tồn kho</th>
            <th>Số lượng đặt</th>
            <th>Thanh toán</th>
        </tr>
        <?php
		//Select dữ liệu từ bảng books
		//1- Kết nối cơ sở dữ liệu
		include_once("connect.php");
		
		//2- Viết câu truy vấn
		$sql = "SELECT * FROM books WHERE ISBN = '$isbn'";
		
		//3-Thực thi câu truy vấn, nhận kết quả trả về
		$result = $conn->query($sql);
		
		//4 - Kiểm tra dữ liệu và hiển kết quả nếu có mẩu tin
		if($result->num_rows>0)
		{
			//Có mẩu tin >>Hiển thị từng mẩu tin
			while($row = $result->fetch_assoc())
			{
				echo "<tr>";
				echo "<td>".$name."</td>";
				echo "<td>".$row["ISBN"]."</td>";
				echo "<td>".$row["Title"]."</td>";
				echo "<td>".$row["Price"]."</td>";
				echo "<td>".$row["Soluong"]."</td>";
				echo "<td>".$soLuongMua."</td>";
				echo "<td>";
				?>

        <a href="
    hoadon_thanhtoan.php?ma=<?php echo $row["ISBN"];?>&slm=<?php echo $soLuongMua;?>&gia=<?php echo $row["Price"];?>">
            Thanh
            toán</a>
        <?php
				echo "</td>";
				echo "</tr>";
			}
		}
		else
		{
			//0 có mẩu tin
			echo "0 có quyển sách nào trong giỏ";
		}
		
	?>

    </table>
    <!-- <h3><a class="btn btn-primary" href="trangchu.php">Quay lại trang chủ</a></h3> -->
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
            <a target="#" href="https://www.w3schools.com/bootstrap4/bootstrap_get_started.asp" style="color: #000000">
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
            <div>
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