<?php
session_start(); 
date_default_timezone_set('Asia/Ho_Chi_Minh'); 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<?php

	$tendangnhap = $_REQUEST['txt_tendangnhap'];
	$matkhau = $_REQUEST["txt_matkhau"];
	$vaitro = $_REQUEST["txt_vaitro"];
	
	$thoigian = date("Y-m-d H:i:s");
	
	$conn = mysqli_connect("localhost","root","");
	mysqli_select_db($conn,"quanlydiemsv");
	
	
	
	if($vaitro == "Giảng Viên")
	{
		$sql = "select * from `giangvienlogin` where `tendangnhap` = '$tendangnhap' and `matkhau` = '$matkhau'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
			$_SESSION['user'] = $tendangnhap; 
            $_SESSION['vaitro'] = "GiangVien";
			$sql_log = "INSERT INTO nhatky_truycap (tendangnhap, vaitro, thoi_gian, hanh_dong) VALUES ('$tendangnhap', 'Giảng Viên', '$thoigian', 'Đăng nhập thành công')";
			mysqli_query($conn, $sql_log);
			header("Location: formchinh.php");
		}
		else{
			echo "<h3 align='center' >Sai tài khoản hoặc mật khẩu Giảng Viên!</h3>";
            echo "<p align='center'><a href='dangnhap.php'>Thử lại</a></p>";
		}		
    }else{
		$sql = "select * from `sinhvienlogin` where `tendangnhap` = '$tendangnhap' and `matkhau` = '$matkhau'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0)
		{
			$_SESSION['user'] = $tendangnhap; 
            $_SESSION['vaitro'] = "SinhVien";
			$sql_log = "INSERT INTO nhatky_truycap (tendangnhap, vaitro, thoi_gian, hanh_dong) VALUES ('$tendangnhap', 'Sinh Viên', '$thoigian', 'Đăng nhập thành công')";
			mysqli_query($conn, $sql_log);
			header("Location: formchinhsv.php");
		}
		else{
			echo "<h3 align='center' >Sai tài khoản hoặc mật khẩu Giảng Viên!</h3>";
            echo "<p align='center'><a href='dangnhap.php'>Thử lại</a></p>";
		}		
	}
	
    
	
	?>
</body>
</html>