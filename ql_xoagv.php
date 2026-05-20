<?php
// 1. Kết nối database
include_once 'db_ketnoi.php';

// 2. Kiểm tra mã giảng viên
if (isset($_GET['ma_gv'])) {
    $ma_gv_xoa = mysqli_real_escape_string($conn, $_GET['ma_gv']);

    // 3. Thực hiện lệnh xóa
    $sql_delete = "DELETE FROM giangvien WHERE ma_gv = '$ma_gv_xoa'";

    if (mysqli_query($conn, $sql_delete)) {
        header("Location: ql_giangvien.php?status=deleted");
        exit();
    } else {
        echo "Lỗi khi xóa: " . mysqli_error($conn);
    }
} else {
    echo "Không nhận được mã giảng viên.";
}
?>