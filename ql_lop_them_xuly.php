<?php
    $ma = $_POST["txt_ma"];
    $ten = $_POST["txt_ten"];
    $nk = $_POST["txt_nienkhoa"];
    $phong = $_POST["txt_phong"];
    $thu = (int)$_POST["txt_thu"];
    $s1 = (int)$_POST["txt_s1"];
    $e1 = (int)$_POST["txt_e1"];
    $gv = $_POST["sel_gv"];

    $conn = mysqli_connect("localhost","root","","quanlydiemsv");
    mysqli_set_charset($conn, "utf8");

    // Xử lý giá trị giáo viên để tránh lỗi SQL Khóa ngoại
    $gv_sql = ($gv == "") ? "NULL" : "'$gv'";

    $sql = "INSERT INTO `lop` (`ma_lop`, `ten_lop`, `nien_khoa`, `phong_hoc`, `thu`, `tiet_bat_dau`, `tiet_ket_thuc`, `ma_gv`) 
            VALUES ('$ma', '$ten', '$nk', '$phong', $thu, $s1, $e1, $gv_sql)";

    if(mysqli_query($conn, $sql)) {
        header("Location: ql_lop.php");
    } else {
        echo "Lỗi hệ thống: " . mysqli_error($conn);
    }
?>