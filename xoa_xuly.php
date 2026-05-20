<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<?php
	$id_can_xoa = $_REQUEST["id"];
	
	$conn = mysqli_connect("localhost","root","");
	mysqli_select_db($conn, "quanlydiemsv");
	
	$sql_delete = "DELETE FROM `taikhoan` WHERE `id` = '$id_can_xoa'";
	mysqli_query($conn, $sql_delete);
	
	header("Location: qltaikhoan.php");
	?>
</body>
</html>