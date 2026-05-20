<?php
session_start();
include_once 'db_ketnoi.php';

/* ===== XÓA ===== */
if (isset($_GET['xoa'])) {
    $ma_sv = $_GET['xoa'];
    mysqli_query($conn, "DELETE FROM sinhvien WHERE ma_sv='$ma_sv'");
    $_SESSION['thongbao'] = "🗑️ Đã xóa sinh viên thành công!";
    header("Location: quanlysinhvien.php");
    exit;
}

/* ===== THÊM ===== */
if (isset($_POST['them'])) {
    $ma_sv = $_POST['ma_sv'];
    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $que_quan = $_POST['que_quan'];
    $ma_lop = $_POST['ma_lop'];

    $sql = "INSERT INTO sinhvien VALUES ('$ma_sv','$ho_ten','$ngay_sinh','$gioi_tinh','$que_quan','$ma_lop')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['thongbao'] = "✅ Thêm sinh viên mới thành công!";
    }

    header("Location: quanlysinhvien.php");
    exit;
}

/* ===== CẬP NHẬT ===== */
if (isset($_POST['capnhat'])) {
    $ma_sv = $_POST['ma_sv'];
    $ho_ten = $_POST['ho_ten'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $que_quan = $_POST['que_quan'];
    $ma_lop = $_POST['ma_lop'];

    $sql = "UPDATE sinhvien SET 
            ho_ten='$ho_ten',
            ngay_sinh='$ngay_sinh',
            gioi_tinh='$gioi_tinh',
            que_quan='$que_quan',
            ma_lop='$ma_lop'
            WHERE ma_sv='$ma_sv'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['thongbao'] = "✏️ Cập nhật thông tin thành công!";
    }

    header("Location: quanlysinhvien.php");
    exit;
}