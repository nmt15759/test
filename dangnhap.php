<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập hệ thống</title>
	 
    <link rel="stylesheet" href="style.css">
    
    <style>
        .login-container {
            max-width: 500px; /* Giới hạn chiều rộng form đăng nhập */
            margin-top: 80px; /* Đẩy xuống giữa màn hình một chút */
        }
        .login-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container login-container">
        <h2>Đăng Nhập Tài Khoản</h2>
        
        <form name="form_dangnhap" method="post" action="dangnhap_xuly.php">
            
            <div class="form-group">
                <label for="user">Tài Khoản:</label>
                <input type="text" id="user" name="txt_tendangnhap" class="form-control" placeholder="Nhập tên đăng nhập..." required>
            </div>
            
            <div class="form-group">
                <label for="pass">Mật khẩu:</label>
                <input type="password" id="pass" name="txt_matkhau" class="form-control" placeholder="Nhập mật khẩu...">
            </div>

            <div class="form-group">
                <label for="role">Vai Trò:</label>
                <select id="role" name="txt_vaitro" class="form-control">
                    <option value="Sinh Viên">Sinh Viên</option>
                    <option value="Giảng Viên">Giảng Viên</option>
                </select>
            </div>

            <div class="button-group login-actions">
                <a href="dangky.php" class="btn btn-view">
                    <i class="fa fa-user-plus"></i> Đăng Ký
                </a>

                <div>
                    <button type="reset" class="btn btn-delete">Xóa Trắng</button>
                    
                    <button type="submit" class="btn btn-add">Đăng Nhập</button>
                </div>
            </div>

        </form>
    </div>

</body>
</html>