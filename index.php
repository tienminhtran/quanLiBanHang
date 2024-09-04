<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./FONT/fontawesome-free-5.15.4-web/css/all.min.css">
    <link rel="stylesheet" href="./UTIL/bootstrap-4.6.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./CSS/base.min.css">
    <link rel="stylesheet" href="./CSS/header.min.css">
    <link rel="stylesheet" href="./CSS/resp_header.min.css">
    <link rel="stylesheet" href="./CSS/footer.min.css">
    <link rel="stylesheet" href="./CSS/resp_footer.min.css">
    <link rel="stylesheet" href="./CSS/style.min.css">
    <link rel="stylesheet" href="./CSS/login.min.css">
    <link rel="stylesheet" href="./CSS/resp_login.min.css">

    <style>
    .btn-custom-primary {
        background-color: #007bff;
        /* Màu nền của nút Đăng nhập */
        border-color: #007bff;
        /* Màu viền của nút Đăng nhập */
        color: #fff;
        /* Màu chữ của nút Đăng nhập */
    }

    .btn-custom-primary:hover {
        background-color: #0056b3;
        /* Màu nền khi di chuột qua */
        border-color: #0056b3;
        /* Màu viền khi di chuột qua */
    }

    .btn-custom-success {
        background-color: #28a745;
        /* Màu nền của nút Đăng ký */
        border-color: #28a745;
        /* Màu viền của nút Đăng ký */
        color: #fff;
        /* Màu chữ của nút Đăng ký */
    }

    .btn-custom-success:hover {
        background-color: #218838;
        /* Màu nền khi di chuột qua */
        border-color: #1e7e34;
        /* Màu viền khi di chuột qua */
    }

    .btn-block {
        width: 100%;
        /* Đảm bảo nút chiếm toàn bộ chiều rộng của cột */
    }

    .dk {
        margin-bottom: 15px;
        /* Khoảng cách giữa các nút */
    }
    </style>
</head>

<body>
    <div class="loading">
        <div class="boxLoading"></div>
    </div>

    <main class="app">
        <header></header>
        <section>
            <div class="container">
                <div class="row no-gutters">
                    <div class="form">
                        <h3>Đăng nhập hệ thống</h3>
                        <form action="xuly_dangnhap.php" id="login" class="was-validated" method="post">
                            <div class="form-group login-msg">
                                <div class="row no-gutters">
                                    <div class="form-group__item col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-messenger">Vui lòng điền đủ thông tin.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row no-gutters">
                                    <div
                                        class="form-group__item form-group__item--label col col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                        <label for="uname" class="form-label">Username</label>
                                    </div>
                                    <div
                                        class="form-group__item form-group__item--input col col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <input type="text" class="form-control" id="uname" placeholder="Nhập username"
                                            name="uname" required>
                                        <div class="valid-feedback">Hợp lệ.</div>
                                        <div class="invalid-feedback">Vui lòng điền đủ thông tin.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row no-gutters">
                                    <div
                                        class="form-group__item form-group__item--label col col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                        <label for="pwd" class="form-label">Password</label>
                                    </div>
                                    <div
                                        class="form-group__item form-group__item--input col col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <input type="password" class="form-control" id="pwd"
                                            placeholder="Enter password" name="pswd" required>
                                        <div class="valid-feedback">Hợp lệ.</div>
                                        <div class="invalid-feedback">Vui lòng điền đủ thông tin.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row no-gutters">
                                    <div class="col col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12"></div>

                                </div>
                            </div>
                            <div class="container mt-5">
                                <div class="dk">
                                    <button class="btn btn-custom-primary btn-lg btn-block" name="sbDangNhap">
                                        Đăng nhập
                                    </button>
                                </div>
                                <div class="dk">
                                    <a class="btn btn-custom-success btn-lg btn-block" href="registry.php">Đăng ký</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer></footer>
    </main>
    <script>
    window.addEventListener('load', function() {
        let loadingElement = document.querySelector('.loading');
        loadingElement.style.transition = 'opacity 2s ease-out';
        loadingElement.style.opacity = '0';

        setTimeout(function() {
            loadingElement.style.display = 'none';
        }, 500);
    });
    </script>
</body>

</html>

<!-- <div class="container mt-3">
<h3>Đăng nhập hệ thống</h3>
      
  <form action="xuly_dangnhap.php" class="was-validated" method = "post">
    <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Username:</label>
      <input type="text" class="form-control" id="uname" placeholder="Nhập username" name="uname" required>
      <div class="valid-feedback">Hợp lệ.</div>
      <div class="invalid-feedback">Vui lòng điền đủ thông tin.</div>
    </div>
    <div class="mb-3">
      <label for="pwd" class="form-label">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" required>
      <div class="valid-feedback">Hợp lệ.</div>
      <div class="invalid-feedback">Vui lòng điền đủ thông tin.</div>
    </div>
    <div class="form-check mb-3">
      <a " href = "registry.php">Đăng ký</a>
    </div>
  <button type="submit" class="btn btn-primary" name = "sbDangNhap">Đăng nhập</button>
  </form>
</div> -->