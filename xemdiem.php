<?php
include_once 'db_ketnoi.php';

// 1. Lấy danh sách Sinh viên cho Combo box tìm kiếm
$ds_sv = mysqli_query($conn, "SELECT DISTINCT ma_sv FROM diem ORDER BY ma_sv ASC");

// 2. Xử lý Lọc tìm kiếm
$current_search = isset($_GET['ma_sv_search']) ? $_GET['ma_sv_search'] : '';
$where = $current_search ? "WHERE ma_sv = '$current_search'" : "";

// Truy vấn dữ liệu điểm
$result = mysqli_query($conn, "SELECT * FROM diem $where ORDER BY ma_sv ASC");
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Xem Điểm Sinh Viên</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="container">
        <h2><i class="fa-solid fa-list-check"></i> BẢNG ĐIỂM SINH VIÊN</h2>

        <div class="search-box" style="text-align: center; margin-bottom: 25px;">
            <form method="GET" action="" style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                <label style="font-weight: bold;">Chọn sinh viên:</label>
                <select name="ma_sv_search" class="form-control" style="width: auto; display: inline-block;">
                    <option value="">-- Tất cả sinh viên --</option>
                    <?php while($sv = mysqli_fetch_array($ds_sv)): ?>
                        <option value="<?= $sv['ma_sv'] ?>" <?= ($sv['ma_sv'] == $current_search) ? 'selected' : '' ?>>
                            <?= $sv['ma_sv'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" class="btn btn-view">
                    <i class="fa-solid fa-magnifying-glass"></i> Xem điểm
                </button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã SV</th>
                    <th>Mã Môn</th>
                    <th>Chuyên cần</th>
                    <th>Giữa kỳ</th>
                    <th>Cuối kỳ</th>
                    <th>Tổng kết (10/20/70)</th> </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_object($result)):
                        // --- TÍNH ĐIỂM TỔNG KẾT ---
                        // Công thức: 10% Chuyên cần + 20% Giữa kỳ + 70% Cuối kỳ
                        $cc = $row->diem_chuyen_can;
                        $gk = $row->diem_giua_ky;
                        $ck = $row->diem_cuoi_ky;
                        
                        // Kiểm tra nếu có đủ điểm mới tính, tránh lỗi
                        if(is_numeric($cc) && is_numeric($gk) && is_numeric($ck)){
                            $tong_ket = ($cc * 0.1) + ($gk * 0.2) + ($ck * 0.7);
                            $tong_ket = round($tong_ket, 1); // Làm tròn 1 số thập phân
                        } else {
                            $tong_ket = "";
                        }
                        
                        // Tô màu điểm nếu dưới 4.0 (Rớt môn)
                        $color_tk = ($tong_ket != "" && $tong_ket < 4.0) ? "red" : "#28a745";
                ?>
                <tr>
                    <td align="center"><?= $stt++ ?></td>
                    <td align="center" style="font-weight:bold; color: #007bff;"><?= $row->ma_sv ?></td>
                    <td align="center"><?= $row->ma_mh ?></td>

                    <td align="center"><?= $cc ?></td>
                    <td align="center"><?= $gk ?></td>
                    <td align="center"><?= $ck ?></td>

                    <td align="center" style="font-weight:bold; color: <?= $color_tk ?>;">
                        <?= $tong_ket ?>
                    </td>
                </tr>
                <?php
                    endwhile;
                } else {
                    echo "<tr><td colspan='7' align='center'>Chưa có dữ liệu điểm nào.</td></tr>";
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