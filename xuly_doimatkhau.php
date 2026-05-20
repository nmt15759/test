<?php
session_start(); 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Xử Lý Đổi</title>
</head>

<?php
	$matkhaucu = $_REQUEST["txt_matkhaucu"];
	$matkhaumoi = $_REQUEST["txt_matkhaumoi"];
	$nhaplai = $_REQUEST["txt_nhaplai"];
	
	$user = $_SESSION['user'];
	$vaitro = $_SESSION['vaitro']; 
	
	$conn = mysqli_connect("localhost","root","");
	
	
	mysqli_select_db($conn,"quanlydiemsv");
	
	if ($vaitro == "GiangVien") {
		$bang = "giangvienlogin";
	} else {
		$bang = "sinhvien";
	}
	
	$sql = "select * from `$bang` where `tendangnhap` = '$user' and `matkhau` = '$matkhaucu'";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) 
	{
		
		if ($matkhaumoi == $nhaplai) {
			
			$sql_capnhat = "update `$bang` set `matkhau` = '$matkhaumoi' where `tendangnhap` = '$user'";
			mysqli_query($conn, $sql_capnhat);
			
			echo "<script>alert('Đổi mật khẩu thành công!'); window.location='dangnhap.php';</script>";
			session_destroy(); 
		} else {
			echo "<script>alert('Mật khẩu mới không trùng khớp!'); window.history.back();</script>";
		}
	} 
	else 
	{
		echo "<script>alert('Mật khẩu cũ không đúng!'); window.history.back();</script>";
	}
	?>
<body>
</body>
</html>