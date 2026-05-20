<?php
include_once 'db_ketnoi.php';

$key = isset($_GET["search"]) ? mysqli_real_escape_string($conn, $_GET["search"]) : "";

// Câu lệnh SQL lấy dữ liệu
$sql = "SELECT * FROM giangvien";
if ($key != "") {
    $sql = "SELECT * FROM giangvien WHERE ho_ten LIKE '%$key%' OR day_lop LIKE '%$key%'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý giảng viên</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2>DANH SÁCH GIẢNG VIÊN</h2>

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <a href="ql_themgv.php" class="btn btn-add">
                <i class="fa-solid fa-plus"></i> Thêm giảng viên
            </a>

            <div class="search-box">
                <form method="get">
                    <input type="text" name="search" placeholder="Tìm tên hoặc lớp..." 
                           value="<?php echo htmlspecialchars($key); ?>" 
                           style="padding: 8px 15px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
                    <button type="submit" class="btn btn-view">
                        <i class="fa-solid fa-magnifying-glass"></i> Tìm
                    </button>
                    <a href="ql_giangvien.php" class="btn btn-home">
                        <i class="fa-solid fa-rotate"></i> Tất cả
                    </a>
                </form>
            </div>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; text-align: center; border-radius: 5px;">
                🗑️ Đã xóa giảng viên thành công!
            </div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Mã GV</th>
                        <th>Họ tên</th>
                        <th>Tuổi</th>
                        <th>Địa chỉ</th>
                        <th>Quê quán</th>
                        <th>Dạy lớp</th>
                        <th>Email</th> 
                        <th>SĐT</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td style="font-weight: bold; color: #007bff;"><?php echo $row["ma_gv"]; ?></td>
                            <td><?php echo $row["ho_ten"]; ?></td>
                            <td align="center"><?php echo $row["tuoi"]; ?></td>
                            <td><?php echo $row["dia_chi"]; ?></td>
                            <td><?php echo $row["que_quan"]; ?></td>
                            <td align="center"><span style="background:#e9ecef; padding: 3px 8px; border-radius: 4px; font-weight: 600; font-size: 13px;"><?php echo $row["day_lop"]; ?></span></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["so_dt"]; ?></td>
                            <td align="center">
                                <a href="ql_suagv.php?ma_gv=<?php echo $row['ma_gv']; ?>" class="btn btn-edit" style="padding: 5px 10px; font-size: 13px;">
                                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                                </a>
                                
                                <a href="ql_xoagv.php?ma_gv=<?php echo $row['ma_gv']; ?>" class="btn btn-delete" style="padding: 5px 10px; font-size: 13px;"
                                   onclick="return confirm('Bạn có chắc chắn muốn xoá giảng viên <?php echo $row['ho_ten']; ?>?')">
                                    <i class="fa-solid fa-trash"></i> Xoá
                                </a>
                            </td> 
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
		<a href="formchinh.php" class="btn btn-home"><i class="fa-solid fa-house"></i> Về Trang Chủ</a>
        <?php else: ?>
            <p style="text-align: center; color: red;">Không tìm thấy dữ liệu giảng viên nào.</p>
        <?php endif; ?>
    </div>
</body>
</html>