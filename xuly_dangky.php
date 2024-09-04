// trang nay khong còn dùng nữa
// code cũ
<!-- <?php
	include_once("connect.php");
	$ten = $mk = $q="";
	if(isset($_POST["sbDangKy"]))
	{
		$ten = $_POST["uname"];
		$mk = md5($_POST["pswd"]);
		//$q = $_POST["slQuyen"];
		$q="2";
	}
	$sql = "INSERT INTO accounts(Username, Pass, RoleID) values('$ten','$mk','$q')";
	
	if($conn->query($sql)===TRUE)
	{
		header("Location:login.php");
	}
	else
	{
		echo "Lỗi truy vấn: ".$sql."<br>".$conn->error;
	}
?> -->


// xử lý trùng tên đăng nhập
<?php
include_once("connect.php");

$ten = $mk = $q = "";

if (isset($_POST["sbDangKy"])) {
    $ten = $_POST["uname"];
	$mk = md5($_POST["pswd"]);
    $q = "2"; // Giá trị RoleID mặc định

    // Kiểm tra xem Username đã tồn tại chưa
    $checkSql = "SELECT Username FROM accounts WHERE Username = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param('s', $ten);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Tên đăng nhập đã tồn tại
        echo '<div class="alert alert-danger" role="alert">Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.</div>';
    } else {
        // Thực hiện INSERT nếu Username chưa tồn tại
        $sql = "INSERT INTO accounts (Username, Pass, RoleID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $ten, $mk, $q);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Lỗi truy vấn: ' . $stmt->error . '</div>';
        }
    }

    $checkStmt->close();
    $conn->close();
}
?>