<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

	<?php	
	
	$tendangnhap = $_REQUEST["txt_tendangnhap"];
	$matkhau = $_REQUEST["txt_matkhau"];
	$vaitro = $_REQUEST["txt_vaitro"];
	
	$conn = mysqli_connect("localhost","root","");
	mysqli_select_db($conn,"quanlydiemsv");
	$sql = "";
   
	if ($vaitro == "GiangVien") {
		$sql = "INSERT INTO giangvienlogin (tendangnhap, matkhau) VALUES ('$tendangnhap', '$matkhau')";
	} 
	elseif ($vaitro == "SinhVien") {
		$sql = "INSERT INTO sinhvienlogin (tendangnhap, matkhau) VALUES ('$tendangnhap', '$matkhau')";
	}
	
	if ($sql != "") {
		if (mysqli_query($conn, $sql)) {
			echo "<script>alert('Đăng ký thành công! Mời bạn đăng nhập.'); window.location='dangnhap.php';</script>";
		} else {
			echo "<h3 style='color:red; text-align:center;'>Đăng ký thất bại!</h3>";
			echo "<p style='text-align:center;'>Tài khoản '<b>$tendangnhap</b>' đã tồn tại hoặc lỗi hệ thống.</p>";
			echo "<p style='text-align:center;'><a href='dangky.php'>Quay lại</a></p>";
		}
	} else {
		echo "Lỗi: Không xác định được vai trò người dùng (Bạn chưa chọn Sinh viên hay Giảng viên).";
	}
	
	?>
</body>
</html>