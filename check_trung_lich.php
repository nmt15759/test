<?php
    // Kết nối Database thông qua file dùng chung
    include("db_ketnoi.php"); 

    // Nhận dữ liệu từ trình duyệt gửi lên
    $ma = $_GET['ma'] ?? '';
    $ten = $_GET['ten'] ?? '';
    $nk = $_GET['nk'] ?? '';
    $old_nk = $_GET['old_nk'] ?? ''; 
    $phong = $_GET['phong'] ?? '';
    $thu = (int)($_GET['thu'] ?? 0);
    $s1 = (int)($_GET['s1'] ?? 0);
    $e1 = (int)($_GET['e1'] ?? 0);
    $gv = $_GET['gv'] ?? '';
    $mode = $_GET['mode'] ?? 'add'; 
	if ($s1 > $e1) {
    die("Lỗi: Tiết bắt đầu ($s1) phải nhỏ hơn hoặc bằng tiết kết thúc ($e1)!");
}
   
    // Nghĩa là: Chỉ tìm những lớp KHÁC mà bị trùng thông tin với lớp hiện tại
    $where_exclude = ($mode == 'edit') ? " AND NOT (ma_lop = '$ma' AND nien_khoa = '$old_nk')" : "";

    // 1. Kiểm tra trùng Mã + Niên khóa
    $sql_id = "SELECT ma_lop FROM lop WHERE ma_lop = '$ma' AND nien_khoa = '$nk' $where_exclude";
    $res_id = mysqli_query($conn, $sql_id);
    if(mysqli_num_rows($res_id) > 0) {
        die("Mã lớp '$ma' đã tồn tại trong niên khóa '$nk'!");
    }

    // 2. Kiểm tra trùng Tên + Niên khóa
    $sql_ten = "SELECT ten_lop FROM lop WHERE ten_lop = '$ten' AND nien_khoa = '$nk' $where_exclude";
    $res_ten = mysqli_query($conn, $sql_ten);
    if(mysqli_num_rows($res_ten) > 0) {
        die("Tên lớp '$ten' đã tồn tại trong niên khóa '$nk'!");
    }

    // 3. Kiểm tra trùng lịch (Phòng HOẶC Giảng viên) vào cùng Thứ + Tiết
    $sql_lich = "SELECT ten_lop FROM lop 
                 WHERE (phong_hoc = '$phong' OR ma_gv = '$gv') 
                 AND thu = $thu 
                 AND ($s1 <= tiet_ket_thuc AND $e1 >= tiet_bat_dau)
                 $where_exclude";

    $res_lich = mysqli_query($conn, $sql_lich);
    if (mysqli_num_rows($res_lich) > 0) {
        $row = mysqli_fetch_object($res_lich);
        die("Trùng lịch với lớp: " . $row->ten_lop);
    }

    // Nếu vượt qua hết các kiểm tra trên
    echo "ok";
?>