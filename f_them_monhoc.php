<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thêm Môn Học</title>
    <link rel="stylesheet" href="giaodien(mh va diem).css">
</head>
<body>

<form method="post" action="xuly_monhoc.php">
    <table border="1" align="center">
        <thead>
            <tr>
                <th colspan="2">THÊM MÔN HỌC MỚI</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mã môn học:</td>
                <td><input type="text" name="txtMa" required></td>
            </tr>
            <tr>
                <td>Tên môn học:</td>
                <td><input type="text" name="txtTen" required></td>
            </tr>
            <tr>
                <td>Số tín chỉ:</td>
                <td><input type="number" name="txtSTC"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="btnLuuThem" value="Lưu Lại">
                    <input type="button" value="Hủy" onclick="window.location='quanlymonhoc.php'">
                </td>
            </tr>
        </tbody>
    </table>
</form>

</body>
</html>