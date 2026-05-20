<?php 
include_once 'db_ketnoi.php';

// 1. XỬ LÝ THÊM MỚI
if (isset($_POST['btnLuuThem'])) {
    $ma_sv = $_POST['selSV'];
    $ma_lop = $_POST['selLop']; // Nhận giá trị mã lớp từ form
    $ma_mh = $_POST['selMH'];
    $tp1 = $_POST['txtTP1'];
    $tp2 = $_POST['txtTP2'];
    $ck = $_POST['txtCK'];

    // --- KIỂM TRA ĐIỂM (0 đến 10) ---
    if ($tp1 < 0 || $tp1 > 10 || $tp2 < 0 || $tp2 > 10 || $ck < 0 || $ck > 10) {
        echo "<script>alert('Lỗi: Điểm phải nằm trong khoảng từ 0 đến 10!'); window.history.back();</script>";
        exit;
    }

    // --- KIỂM TRA TRÙNG (Mã SV và Mã MH) ---
    // Kiểm tra xem sinh viên đã có điểm môn này trong bảng 'diem' chưa
    $check = mysqli_query($conn, "SELECT id FROM diem WHERE ma_sv = '$ma_sv' AND ma_mh = '$ma_mh'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Lỗi: Sinh viên này đã có điểm môn học này rồi!'); window.history.back();</script>";
        exit;
    }

    // --- THỰC HIỆN INSERT ---
    // Cập nhật câu lệnh SQL để chèn thêm cột ma_lop
    $sql = "INSERT INTO diem (ma_sv, ma_lop, ma_mh, diem_tp1, diem_tp2, diem_ck) 
            VALUES ('$ma_sv', '$ma_lop', '$ma_mh', '$tp1', '$tp2', '$ck')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thêm thành công!'); window.location='quanlydiem.php';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// 2. XỬ LÝ CẬP NHẬT (Sửa trực tiếp trên bảng)
if (isset($_POST['btn_luu'])) {
    $id = $_POST['btn_luu'];
    // Lấy dữ liệu từ mảng input theo ID dòng tương ứng
    $tp1 = $_POST['diem_tp1'][$id];
    $tp2 = $_POST['diem_tp2'][$id];
    $ck = $_POST['diem_ck'][$id];

    if ($tp1 < 0 || $tp1 > 10 || $tp2 < 0 || $tp2 > 10 || $ck < 0 || $ck > 10) {
        echo "<script>alert('Lỗi: Điểm sửa đổi không hợp lệ (0-10)!'); window.location='quanlydiem.php';</script>";
        exit;
    }

    // Cập nhật các cột điểm mới (diem_tp1, diem_tp2, diem_ck)
    $sql = "UPDATE diem SET diem_tp1 ='$tp1', diem_tp2='$tp2', diem_ck='$ck' WHERE id='$id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Đã cập nhật!'); window.location='quanlydiem.php';</script>";
    }
}

// 3. XỬ LÝ XÓA
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    // Xóa dòng dựa trên ID khóa chính
    mysqli_query($conn, "DELETE FROM diem WHERE id='$id'");
    header("Location: quanlydiem.php");
}
?>