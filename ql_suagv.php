<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật giảng viên</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <?php
    include_once 'db_ketnoi.php';

    if (!isset($_GET['ma_gv'])) die("Không tìm thấy mã giảng viên.");
    $ma_gv = $_GET['ma_gv'];

    $result = mysqli_query($conn, "SELECT * FROM giangvien WHERE ma_gv = '$ma_gv'");
    $row = mysqli_fetch_assoc($result);

    if (!$row) die("Giảng viên không tồn tại.");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $ho_ten   = $_POST['ho_ten'];
        $tuoi     = !empty($_POST['tuoi']) ? $_POST['tuoi'] : 'NULL';
        $dia_chi  = $_POST['dia_chi'];
        $que_quan = $_POST['que_quan'];
        $day_lop  = $_POST['day_lop'];
        $email    = $_POST['email'];
        $so_dt    = $_POST['so_dt'];

        $sql_update = "UPDATE giangvien SET 
                        ho_ten = '$ho_ten', tuoi = $tuoi, dia_chi = '$dia_chi', 
                        que_quan = '$que_quan', day_lop = '$day_lop', 
                        email = '$email', so_dt = '$so_dt' 
                      WHERE ma_gv = '$ma_gv'";

        if (mysqli_query($conn, $sql_update)) {
            echo "<script>
                alert('✏️ Cập nhật thành công!');
                window.location.href='ql_giangvien.php';
            </script>";
        } else {
            echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
        }
    }
    ?>

    <div class="container">
        <h2>CẬP NHẬT THÔNG TIN</h2>
        
        <div style="background: #fff9c4; padding: 30px; border-radius: 8px; border: 1px solid #f1c40f;">
            <form action="" method="post">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label>Mã Giảng Viên (Không thể sửa):</label>
                        <input type="text" value="<?php echo $row['ma_gv']; ?>" class="form-control" disabled style="background: #eee;">
                    </div>
                    <div class="form-group">
                        <label>Tên giảng viên:</label>
                        <input type="text" name="ho_ten" value="<?php echo $row['ho_ten']; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tuổi:</label>
                        <input type="number" name="tuoi" value="<?php echo $row['tuoi']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Số Điện Thoại:</label>
                        <input type="text" name="so_dt" value="<?php echo $row['so_dt']; ?>" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Lớp dạy:</label>
                        <select name="day_lop" class="form-control">
                            <option value="">-- Chọn lớp phụ trách --</option>
                            <?php
                            $sql_lop = "SELECT ma_lop FROM lop";
                            $res_lop = mysqli_query($conn, $sql_lop);
                            while ($r_lop = mysqli_fetch_assoc($res_lop)) {
                                // Kiểm tra nếu mã lớp trong database trùng với lớp GV đang dạy thì chọn (selected)
                                $selected = ($r_lop['ma_lop'] == $row['day_lop']) ? "selected" : "";
                                echo "<option value='" . $r_lop['ma_lop'] . "' $selected>" . $r_lop['ma_lop'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ:</label>
                        <input type="text" name="dia_chi" value="<?php echo $row['dia_chi']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Quê quán:</label>
                        <input type="text" name="que_quan" value="<?php echo $row['que_quan']; ?>" class="form-control">
                    </div>
                </div>

                <div style="margin-top: 30px; text-align: center;">
                    <button type="submit" name="btnUpdate" class="btn btn-add">
                        <i class="fa-solid fa-check"></i> Cập nhật dữ liệu
                    </button>
                    <a href="ql_giangvien.php" class="btn btn-delete">
                        <i class="fa-solid fa-xmark"></i> Hủy bỏ
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>