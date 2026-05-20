<?php 
include_once 'db_ketnoi.php';

// 1. Lấy dữ liệu từ URL truyền sang
$get_ma_sv = $_GET['ma_sv'] ?? '';
$get_ma_lop = $_GET['ma_lop'] ?? '';

// 2. Truy vấn dữ liệu cho các ô Select
$ds_sv = mysqli_query($conn, "SELECT ma_sv, ho_ten FROM sinhvien");
$ds_mh = mysqli_query($conn, "SELECT ma_mh, ten_mh FROM monhoc");
$ds_lop = mysqli_query($conn, "SELECT ma_lop, ten_lop FROM lop");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thêm Điểm</title>
    <link rel="stylesheet" href="giaodien(mh va diem).css">
</head>
<body>
<form method="post" action="xuly_diem.php">
  <table border="1" align="center">
    <tr><th colspan="2">THÊM ĐIỂM MỚI</th></tr>
    
    <tr>
        <td>Sinh viên:</td>
        <td>
            <select name="selSV" required>
                <option value="">-- Chọn sinh viên --</option>
                <?php while($r = mysqli_fetch_array($ds_sv)): ?>
                    <option value="<?= $r['ma_sv'] ?>" <?= ($r['ma_sv'] == $get_ma_sv) ? 'selected' : '' ?>>
                        <?= $r['ma_sv'] ?> - <?= $r['ho_ten'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </td>
    </tr>

    <tr>
        <td>Lớp học:</td>
        <td>
            <select name="selLop" required>
                <option value="">-- Chọn mã lớp --</option>
                <?php while($r = mysqli_fetch_array($ds_lop)): ?>
                    <option value="<?= $r['ma_lop'] ?>" <?= ($r['ma_lop'] == $get_ma_lop) ? 'selected' : '' ?>>
                        <?= $r['ma_lop'] ?> - <?= $r['ten_lop'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </td>
    </tr>

    <tr>
        <td>Môn học:</td>
        <td>
            <select name="selMH" required>
                <option value="">-- Chọn môn học --</option>
                <?php while($r = mysqli_fetch_array($ds_mh)): ?>
                    <option value="<?= $r['ma_mh'] ?>">
                        <?= $r['ma_mh'] ?> - <?= $r['ten_mh'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </td>
    </tr>

    <tr><td>TP1 (10%):</td><td><input type="number" step="0.1" name="txtTP1" value="0" min="0" max="10"></td></tr>
    <tr><td>TP2 (30%):</td><td><input type="number" step="0.1" name="txtTP2" value="0" min="0" max="10"></td></tr>
    <tr><td>CK (60%):</td><td><input type="number" step="0.1" name="txtCK" value="0" min="0" max="10"></td></tr>

    <tr>
        <td colspan="2" align="center">
            <input type="submit" name="btnLuuThem" value="Lưu Lại">
            <input type="button" value="Hủy" onclick="window.location='quanlydiem.php'">
        </td>
    </tr>
  </table>
</form>
</body>
</html>