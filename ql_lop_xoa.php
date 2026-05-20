<?php
session_start();
include_once 'db_ketnoi.php';

// Kiểm tra xem có dữ liệu gửi lên không
if (isset($_GET['ma']) && isset($_GET['nk'])) {
    $ma = $_GET['ma'];
    $nk = $_GET['nk'];

    // Câu lệnh xóa
    $sql = "DELETE FROM lop WHERE ma_lop = '$ma' AND nien_khoa = '$nk'";

    if (mysqli_query($conn, $sql)) {
        // --- THÀNH CÔNG: Lưu thông báo vào Session ---
        $_SESSION['thongbao_msg'] = "Đã xóa lớp $ma ($nk) thành công!";
        $_SESSION['thongbao_icon'] = "success"; // Icon tích xanh
    } else {
        // --- THẤT BẠI (Do lỗi SQL hoặc ràng buộc khóa ngoại) ---
        $_SESSION['thongbao_msg'] = "Không thể xóa! Có thể lớp này đang có sinh viên.";
        $_SESSION['thongbao_icon'] = "error"; // Icon dấu X đỏ
    }
}

// Quay về trang quản lý lớp
header("Location: ql_lop.php");
exit();
?>