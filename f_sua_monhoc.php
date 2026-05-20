<?php
    $ma = $_GET["ma"]; // Lấy mã môn từ URL
    $conn = mysqli_connect("localhost","root","","quanlydiemsv");
    // Lấy thông tin môn học hiện tại
    $result = mysqli_query($conn, "SELECT * FROM monhoc WHERE ma_mh = '$ma'");
    $row = mysqli_fetch_object($result);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sửa Môn Học</title>
    <link rel="stylesheet" href="giaodien(mh va diem).css">
</head>
<body>
    <form method="post" action="xuly_monhoc.php">
        <table border="1" align="center">
            <thead>
                <tr>
                    <th colspan="2">SỬA THÔNG TIN MÔN HỌC</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mã môn học:</td>
                    <td>
                        <input type="text" name="txtMa" value="<?php echo $row->ma_mh; ?>" readonly class="input-readonly">
                    </td>
                </tr>
                <tr>
                    <td>Tên môn học:</td>
                    <td>
                        <input type="text" name="txtTen" value="<?php echo $row->ten_mh; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Số tín chỉ:</td>
                    <td>
                        <input type="number" name="txtSTC" value="<?php echo $row->so_tin_chi; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="btnCapNhat" value="Cập nhật">
                        <input type="button" value="Hủy" onclick="window.location='quanlymonhoc.php'">
                        || <a href="quanlymonhoc.php">Quay lại</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</body>
</html>