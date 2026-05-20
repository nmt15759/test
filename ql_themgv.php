<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới giảng viên</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <?php include_once 'db_ketnoi.php'; ?>

    <div class="container">
        <h2>THÊM MỚI GIẢNG VIÊN</h2>

        <div style="background: #f8f9fa; padding: 30px; border-radius: 8px; border: 1px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <form action="" method="post">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label>Mã Giảng Viên:</label>
                        <input type="text" name="ma_gv" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tên giảng viên:</label>
                        <input type="text" name="ho_ten" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tuổi:</label>
                        <input type="number" name="tuoi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Số Điện Thoại:</label>
                        <input type="text" name="so_dt" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Lớp phụ trách:</label>
                        <select name="day_lop" class="form-control">
                            <option value="">-- Chọn lớp --</option>
                            <?php
                            $sql_lop = "SELECT ma_lop FROM lop";
                            $result_lop = mysqli_query($conn, $sql_lop);
                            while ($r = mysqli_fetch_assoc($result_lop)) {
                                echo "<option value='" . $r['ma_lop'] . "'>" . $r['ma_lop'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ:</label>
                        <input type="text" name="dia_chi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Quê quán:</label>
                        <input type="text" name="que_quan" class="form-control">
                    </div>
                </div>

                <div style="margin-top: 30px; text-align: center;">
                    <button type="submit" name="btnSubmit" class="btn btn-add">
                        <i class="fa-solid fa-floppy-disk"></i> Lưu dữ liệu
                    </button>
                    <a href="ql_giangvien.php" class="btn btn-delete">
                        <i class="fa-solid fa-ban"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Lưu ý: Đã include db_ketnoi ở trên rồi
        
        $ma_gv = $_POST['ma_gv'];
        $ho_ten = $_POST['ho_ten'];
        $tuoi = !empty($_POST['tuoi']) ? $_POST['tuoi'] : 'NULL';
        $dia_chi = $_POST['dia_chi'];
        $que_quan = $_POST['que_quan'];
        $day_lop = $_POST['day_lop']; // Giá trị này giờ lấy từ <select>
        $email = $_POST['email'];
        $so_dt = $_POST['so_dt'];

        $sql = "INSERT INTO giangvien (ma_gv, ho_ten, tuoi, dia_chi, que_quan, day_lop, email, so_dt) 
                VALUES ('$ma_gv', '$ho_ten', $tuoi, '$dia_chi', '$que_quan', '$day_lop', '$email', '$so_dt')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                alert('✅ Thêm thành công giảng viên: $ho_ten');
                window.location.href='ql_giangvien.php';
            </script>";
        } else {
            echo "<script>alert('❌ Lỗi: " . mysqli_error($conn) . "');</script>";
        }
        mysqli_close($conn);
    }
    ?>
</body>
</html>