<?php
session_start();
include_once 'db_ketnoi.php';

// Lấy dữ liệu nhật ký, sắp xếp mới nhất lên đầu
$sql = "SELECT * FROM nhatky_truycap ORDER BY thoi_gian DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhật Ký Hoạt Động</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2><i class="fa-solid fa-clock-rotate-left"></i> NHẬT KÝ HOẠT ĐỘNG HỆ THỐNG</h2>
        
        <div class="search-box" style="text-align: right; margin-bottom: 20px;">
            
        </div>

        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thời gian</th>
                    <th>Tên đăng nhập</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 0;
                if(mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)) {
                        $stt++;
                        // Định dạng ngày giờ Việt Nam
                        $date = date("H:i:s d/m/Y", strtotime($row['thoi_gian']));
                        
                        // Màu sắc cho vai trò (Giảng viên xanh dương, Sinh viên xanh lá)
                        $badge_color = ($row['vaitro'] == 'Giảng Viên') ? '#007bff' : '#28a745';
                ?>
                <tr>
                    <td align="center"><?= $stt ?></td>
                    <td align="center" style="font-weight: 500;"><?= $date ?></td>
                    <td align="center" style="font-weight: bold; color: #333;"><?= $row['tendangnhap'] ?></td>
                    <td align="center">
                        <span style="background: <?= $badge_color ?>; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <?= $row['vaitro'] ?>
                        </span>
                    </td>
                    <td align="center"><?= $row['hanh_dong'] ?></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='5' align='center'>Chưa có nhật ký nào được ghi lại.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="formchinh.php" class="btn btn-home"><i class="fa-solid fa-house"></i> Quay về trang chủ</a>
        </div>
    </div>

</body>
</html>