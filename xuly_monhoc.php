<?php
include_once 'db_ketnoi.php';

// 1. THÊM MỚI (Có kiểm tra trùng mã)
if (isset($_POST['btnLuuThem'])) {
    $ma = $_POST['txtMa']; $ten = $_POST['txtTen']; $stc = $_POST['txtSTC'];

    // Kiểm tra trùng nhanh bằng mysqli_num_rows
    if (mysqli_num_rows(mysqli_query($conn, "SELECT ma_mh FROM monhoc WHERE ma_mh='$ma'")) > 0) {
        echo "<script>alert('Lỗi: Mã môn học [$ma] đã tồn tại!'); window.history.back();</script>";
    }
    else if (mysqli_num_rows(mysqli_query($conn, "SELECT ten_mh FROM monhoc WHERE ten_mh='$ten'")) > 0) {
        echo "<script>alert('Lỗi: Tên môn học [$ten] đã tồn tại!'); window.history.back();</script>";
    }
     else {
        $sql = "INSERT INTO monhoc VALUES ('$ma', '$ten', '$stc')";
        if (mysqli_query($conn, $sql)) echo "<script>alert('Thêm thành công!'); window.location='quanlymonhoc.php';</script>";
    }
}

// 2. CẬP NHẬT
if (isset($_POST['btnCapNhat'])) {
    $ma = $_POST['txtMa']; $ten = $_POST['txtTen']; $stc = $_POST['txtSTC'];
    if (mysqli_num_rows(mysqli_query($conn, "SELECT ten_mh FROM monhoc WHERE ten_mh='$ten' AND ma_mh != '$ma'")) > 0) {
        echo "<script>alert('Lỗi: Tên môn học [$ten] đã tồn tại!'); window.history.back();</script>";
    } else {
        $sql = "UPDATE monhoc SET ten_mh='$ten', so_tin_chi='$stc' WHERE ma_mh='$ma'";
        if (mysqli_query($conn, $sql)) 
            echo "<script>alert('Đã cập nhật!'); window.location='quanlymonhoc.php';</script>";
    }
}

// 3. XÓA
if (isset($_GET['ma_xoa'])) {
    mysqli_query($conn, "DELETE FROM monhoc WHERE ma_mh = '".$_GET['ma_xoa']."'");
    header("location:quanlymonhoc.php");
}
?>