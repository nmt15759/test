<?php
    session_start();
    
    // Nhận dữ liệu từ form
    $ma = $_POST["txt_ma"];
    $ten = $_POST["txt_ten"];
    $nk = $_POST["txt_nienkhoa"];
    $old_nk = $_POST["old_nk"]; 
    $phong = $_POST["txt_phong"];
    $thu = (int)$_POST["txt_thu"];
    $s1 = (int)$_POST["txt_s1"];
    $e1 = (int)$_POST["txt_e1"];
    $gv = $_POST["sel_gv"];

    include("db_ketnoi.php");

    // Kiểm tra trùng lịch (Loại trừ chính nó)
    $sql_check = "SELECT ten_lop FROM lop 
                  WHERE (phong_hoc = '$phong' OR ma_gv = '$gv') AND thu = $thu 
                  AND (ma_lop != '$ma' OR nien_khoa != '$old_nk')
                  AND ($s1 <= tiet_ket_thuc AND $e1 >= tiet_bat_dau)";
    
    $res = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($res) > 0) {
        echo "<script>alert('Lỗi: Trùng lịch dạy hoặc phòng học!'); window.history.back();</script>";
        exit();
    }

    // Cập nhật dữ liệu theo Mã và Niên khóa cũ
    $sql = "UPDATE `lop` SET 
            `ten_lop`='$ten', 
            `nien_khoa`='$nk', 
            `phong_hoc`='$phong', 
            `thu`=$thu, 
            `tiet_bat_dau`=$s1, 
            `tiet_ket_thuc`=$e1, 
            `ma_gv`='$gv' 
            WHERE `ma_lop`='$ma' AND `nien_khoa`='$old_nk'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: ql_lop.php");
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
?>