<?php
session_start();
//echo $_SESSION["Role"];
if(!isset($_SESSION["Name"]))
{
	header("Location:login.php");
}
if($_SESSION["Role"]==2)//Khách hàng
{
	header("Location:trangchu.php");
}

//1-Kết nối cơ sở dữ liệu
include_once("connect.php");?>
<!DOCTYPE html>
<html>

<head>
    <title>Website giới thiệu sản phẩm ...</title>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container ">
        <ul class="nav justify-content-end ">
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
            <li class="nav-item  dropdown">
                <a class="nav-link  dropdown-toggle" data-bs-toggle="dropdown" href="#">Thống kê</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="thongke_anpham.php">Số ấn phẩm theo danh mục</a></li>
                    <li><a class="dropdown-item" href="thongke_doanhthu.php">Doanh thu</a></li>
                    <li><a class="dropdown-item" href="thongke_bieudo.php">Trực quan </a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php?flag=1">Đăng xuất</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><?php echo "Xin chào ".$_SESSION["Name"]."!";?></a>
            </li>
        </ul>