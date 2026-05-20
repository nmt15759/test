<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng Ký Tài Khoản</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .register-container {
            max-width: 500px; /* Giới hạn chiều rộng */
            margin-top: 60px;
        }
    </style>
</head>

<body>

    <div class="container register-container">
        <h2>Đăng Ký Tài Khoản</h2>

        <form name="form_dangky" method="post" action="dangky_xuly.php">
            
            <div class="form-group">
                <label for="reg_user">Tài Khoản:</label>
                <input type="text" id="reg_user" name="txt_tendangnhap" class="form-control" placeholder="Nhập tên tài khoản muốn tạo..." required>
            </div>

            <div class="form-group">
                <label for="reg_pass">Mật Khẩu:</label>
                <input type="password" id="reg_pass" name="txt_matkhau" class="form-control" placeholder="Nhập mật khẩu..." required>
            </div>

            <div class="form-group">
                <label for="reg_role">Vai Trò:</label>
                <select id="reg_role" name="txt_vaitro" class="form-control">
                    <option value="SinhVien">Sinh Viên</option>
                    <option value="GiangVien">Giảng Viên</option>
                </select>
            </div>

            <div class="button-group">
                <a href="dangnhap.php" class="btn btn-home">
                    <i class="fa fa-arrow-left"></i> Quay Lại
                </a>

                <button type="reset" class="btn btn-delete">Xóa Trắng</button>

                <button type="submit" class="btn btn-add">Đăng Ký</button>
            </div>

        </form>
    </div>

</body>
</html>