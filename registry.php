<!DOCTYPE html>
<html lang="en">
<head>
  <title>Đăng ký tài khoản</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h3>Đăng ký tài khoản mua hàng</h3>
      
  <form action="xuly_dangky.php" class="was-validated" method = "post">
    <div class="mb-3 mt-3">
      <label for="uname" class="form-label">Username (Nên nhập số điện thoại):</label>
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
	<!--
    <div class="form-check mb-3">
     <select name = "slQuyen">
		<?php
			include_once("connect.php");
			$sql = "select *from roles";
			$result = $conn->query($sql);
			
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
					if($row["RoleID"]==2)
					{
						echo "<option value ='".$row["RoleID"]."' selected>";
						echo $row["Name"];
						echo "</option>";

						
					}
					else{
						echo "<option value ='".$row["RoleID"]."'>";
						echo $row["Name"];
						echo "</option>";
					}
				}
			}
			else
			{
				echo "<option value = ''>Chưa có quyền người dùng</option>";
				
			}
			
		?>
	 </select>
	 <?phpecho $sql;?>
    </div>
	-->
	<button type="submit" class="btn btn-primary" name = "sbDangKy">Tạo tài khoản</button>
	<a href="trangchu.php" class="btn btn-primary">Quay lại trang chủ</a>
  </form>
</div>

</body>
</html>
