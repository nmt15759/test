<?php 
include_once 'db_ketnoi.php'; 

if(isset($_GET['delete_id'])) { include 'xuly_diem.php'; }

// 1. Lấy giá trị lọc từ URL
$current_sv = $_GET['ma_sv_search'] ?? '';
$current_lop = $_GET['ma_lop_search'] ?? '';

// 2. Lấy danh sách Lớp học
$ds_lop = mysqli_query($conn, "SELECT ma_lop, ten_lop FROM lop ORDER BY ma_lop ASC");
// 3. Lọc danh sách sinh viên theo Lớp đang chọn từ bảng SINHVIEN
$filter_sv = $current_lop ? "WHERE ma_lop = '$current_lop'" : "";
$ds_sv = mysqli_query($conn, "SELECT ma_sv, ho_ten FROM sinhvien $filter_sv ORDER BY ma_sv ASC");
// 4. Xây dựng câu lệnh SQL cho bảng điểm
$conditions = [];
if ($current_sv) $conditions[] = "ma_sv = '$current_sv'";
if ($current_lop) $conditions[] = "ma_lop = '$current_lop'";
$where = count($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

$result = mysqli_query($conn, "SELECT * FROM diem $where ORDER BY ma_sv ASC, ma_mh ASC");
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản Lý Điểm</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>HỆ THỐNG QUẢN LÝ ĐIỂM</h2>

        <div class="search-box" style="text-align: center; margin-bottom: 25px; background: #f4f7f6; padding: 20px; border-radius: 8px;">
            <form method="GET" action="" style="display: flex; justify-content: center; align-items: center; gap: 15px; flex-wrap: wrap;">
                
                <div class="filter-group">
                    <label style="font-weight: bold;">Lớp học:</label>
                    <select name="ma_lop_search" class="form-control" style="width: auto; display: inline-block;" onchange="this.form.submit()">
                        <option value="">-- Tất cả lớp --</option>
                        <?php while($lp = mysqli_fetch_array($ds_lop)): ?>
                            <option value="<?= $lp['ma_lop'] ?>" <?= ($lp['ma_lop'] == $current_lop) ? 'selected' : '' ?>>
                                <?= $lp['ma_lop'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="filter-group">
    <label style="font-weight: bold;">Sinh viên:</label>
    <select name="ma_sv_search" class="form-control" style="width: auto; display: inline-block;">
        <option value="">-- Tất cả sinh viên --</option>
        <?php while($sv = mysqli_fetch_array($ds_sv)): ?>
            <option value="<?= $sv['ma_sv'] ?>" <?= ($sv['ma_sv'] == $current_sv) ? 'selected' : '' ?>>
                <?= $sv['ma_sv'] ?> - <?= $sv['ho_ten'] ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

                <button type="submit" class="btn btn-view">
                    <i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm
                </button>
                
                <a href="quanlydiem.php" class="btn btn-delete" style="text-decoration: none; background-color: #6c757d;">
                    <i class="fa-solid fa-rotate-left"></i> Làm mới
                </a>
            </form>
        </div>

        <div class="action-bar">
    <a href="f_them_diem.php?ma_sv=<?= $current_sv ?>&ma_lop=<?= $current_lop ?>" class="btn btn-add">
        <i class="fa-solid fa-plus"></i> Thêm điểm
    </a>
</div>

        <form method="POST" action="xuly_diem.php"> 
            <table>
                <thead>
                    <tr>
                        <th>STT</th> 
                        <th>Mã SV</th>
                        <th>Mã Lớp</th>
                        <th>Mã Môn</th>
                        <th>TP1</th>
                        <th>TP2</th>
                        <th>CK</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stt = 1; 
                    if(mysqli_num_rows($result) > 0):
                        while($row = mysqli_fetch_object($result)): 
                            $diem_tong = ($row->diem_tp1 * 0.1) + ($row->diem_tp2 * 0.3) + ($row->diem_ck * 0.6);
                    ?>
                    <tr>
                        <td align="center"><?= $stt++ ?></td> 
                        <td align="center" style="font-weight:bold; color: #007bff;"><?= $row->ma_sv ?></td>
                        <td align="center"><?= $row->ma_lop ?></td>
                        <td align="center"><?= $row->ma_mh ?></td>
                        
                        <td align="center">
                            <input type="number" step="0.1" min="0" max="10" name="diem_tp1[<?= $row->id ?>]" value="<?= $row->diem_tp1 ?>" class="form-control" style="width: 65px; text-align: center;">
                        </td>
                        <td align="center">
                            <input type="number" step="0.1" min="0" max="10" name="diem_tp2[<?= $row->id ?>]" value="<?= $row->diem_tp2 ?>" class="form-control" style="width: 65px; text-align: center;">
                        </td>
                        <td align="center">
                            <input type="number" step="0.1" min="0" max="10" name="diem_ck[<?= $row->id ?>]" value="<?= $row->diem_ck ?>" class="form-control" style="width: 65px; text-align: center;">
                        </td>

                        <td align="center" style="font-weight:bold; color: #dc3545; background-color: #f8faf9;">
                            <?= number_format($diem_tong, 1) ?>
                        </td>
                        
                        <td align="center">
                            <button type="submit" name="btn_luu" value="<?= $row->id ?>" class="btn btn-add" style="padding: 5px 10px; font-size: 13px;">
                                <i class="fa-solid fa-floppy-disk"></i> Lưu
                            </button>
                            
                            <a href="xuly_diem.php?delete_id=<?= $row->id ?>&ma_sv_search=<?= $current_sv ?>&ma_lop_search=<?= $current_lop ?>" 
                               class="btn btn-delete" style="padding: 5px 10px; font-size: 13px;" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa dòng này?')">
                               <i class="fa-solid fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; 
                    else: ?>
                        <tr><td colspan="9" align="center">Không tìm thấy kết quả phù hợp.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
        <a href="formchinh.php" class="btn btn-home" style="margin-top: 20px;"><i class="fa-solid fa-house"></i> Về Trang Chủ</a>
    </div>
</body>
</html>