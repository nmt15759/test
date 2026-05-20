<?php
session_start();
include_once 'db_ketnoi.php';

// Xử lý tìm kiếm
$tukhoa = isset($_GET['search']) ? $_GET['search'] : '';
$where = "";
if ($tukhoa) {
    $where = "WHERE l.ten_lop LIKE '%$tukhoa%' OR l.ma_lop LIKE '%$tukhoa%' OR g.ho_ten LIKE '%$tukhoa%'";
}

// Truy vấn bảng LỚP kết hợp GIẢNG VIÊN
// Sắp xếp theo Thứ (thu) -> Tiết bắt đầu (tiet_bat_dau)
$sql = "SELECT l.*, g.ho_ten 
        FROM lop l 
        LEFT JOIN giangvien g ON l.ma_gv = g.ma_gv 
        $where
        ORDER BY l.thu ASC, l.tiet_bat_dau ASC";

$result = mysqli_query($conn, $sql);

// Mảng ánh xạ thứ sang tên hiển thị
$thu_arr = [
    2 => 'Thứ Hai',
    3 => 'Thứ Ba',
    4 => 'Thứ Tư',
    5 => 'Thứ Năm',
    6 => 'Thứ Sáu',
    7 => 'Thứ Bảy',
    8 => 'Chủ Nhật'
];

// Mảng màu sắc cho từng thứ để dễ nhìn
$color_arr = [
    2 => '#ffc107', // Vàng
    3 => '#17a2b8', // Xanh ngọc
    4 => '#28a745', // Xanh lá
    5 => '#007bff', // Xanh dương
    6 => '#6610f2', // Tím
    7 => '#e83e8c', // Hồng
    8 => '#dc3545'  // Đỏ
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch Học </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    

    <div class="container">
        <h2><i class="fa-solid fa-calendar-days"></i> LỊCH HỌC </h2>

        <div class="search-box" style="text-align: center; margin-bottom: 25px;">
            <form method="GET" action="" style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                <input type="text" name="search" value="<?= htmlspecialchars($tukhoa) ?>" 
                       placeholder="Nhập tên môn, mã lớp hoặc tên GV..." 
                       class="form-control" style="width: 300px; display: inline-block;">
                
                <button type="submit" class="btn btn-view">
                    <i class="fa-solid fa-magnifying-glass"></i> Tra cứu
                </button>
                
                <?php if($tukhoa): ?>
                    <a href="lichhoc.php" class="btn btn-delete"><i class="fa-solid fa-xmark"></i> Xóa lọc</a>
                <?php endif; ?>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="10%">Thứ</th>
                    <th width="10%">Tiết học</th>
                    <th width="10%">Phòng</th>
                    <th width="15%">Mã Lớp</th>
                    <th width="25%">Tên Lớp / Môn Học</th>
                    <th width="20%">Giảng Viên</th>
                    <th width="10%">Niên Khóa</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $thu_so = $row['thu'];
                        $ten_thu = isset($thu_arr[$thu_so]) ? $thu_arr[$thu_so] : "Thứ $thu_so";
                        $mau_thu = isset($color_arr[$thu_so]) ? $color_arr[$thu_so] : "#333";
                ?>
                <tr>
                    <td align="center">
                        <span style="background-color: <?= $mau_thu ?>; color: white; padding: 5px 10px; border-radius: 15px; font-weight: bold; font-size: 13px;">
                            <?= $ten_thu ?>
                        </span>
                    </td>
                    
                    <td align="center" style="font-weight: bold;">
                        <?= $row['tiet_bat_dau'] ?> - <?= $row['tiet_ket_thuc'] ?>
                    </td>

                    <td align="center" style="color: #d63384; font-weight: bold;">
                        <?= $row['phong_hoc'] ?>
                    </td>

                    <td align="center"><?= $row['ma_lop'] ?></td>

                    <td style="font-weight: 500; color: #0d47a1;">
                        <?= $row['ten_lop'] ?>
                    </td>

                    <td>
                        <i class="fa-solid fa-user-tie" style="color: #666;"></i> 
                        <?= $row['ho_ten'] ? $row['ho_ten'] : '<span style="color:#999; font-style:italic;">Chưa phân công</span>' ?>
                    </td>

                    <td align="center"><?= $row['nien_khoa'] ?></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='7' align='center' style='padding: 20px;'>Không tìm thấy lịch học nào phù hợp.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div style="text-align: center; margin-top: 20px;">
            <a href="formchinhsv.php" class="btn btn-home"><i class="fa-solid fa-house"></i> Về Trang Chủ</a>
        </div>
    </div>
</body>
</html>