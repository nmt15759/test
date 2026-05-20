<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
	 
    <title>Đổi Mật Khẩu</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .change-pass-container {
            max-width: 500px; /* Giới hạn chiều rộng để form không bị bè ra */
            margin-top: 60px;
        }
    </style>
</head>

<body>

    <div class="container change-pass-container">
        <h2>Đổi Mật Khẩu</h2>

        <form name="doimatkhau" method="post" action="xuly_doimatkhau.php">
            
            <div class="form-group">
                <label for="old_pass">Mật khẩu cũ:</label>
                <input type="password" id="old_pass" name="txt_matkhaucu" class="form-control" placeholder="Nhập mật khẩu hiện tại..." required>
            </div>

            <div class="form-group">
                <label for="new_pass">Mật khẩu mới:</label>
                <input type="password" id="new_pass" name="txt_matkhaumoi" class="form-control" placeholder="Nhập mật khẩu mới..." required>
            </div>

            <div class="form-group">
                <label for="confirm_pass">Nhập lại mật khẩu mới:</label>
                <input type="password" id="confirm_pass" name="txt_nhaplai" class="form-control" placeholder="Xác nhận lại mật khẩu..." required>
            </div>

            <div class="button-group">
                <a href="formchinhsv.php" class="btn btn-home">
                    <i class="fa fa-arrow-left"></i> Quay Lại
                </a>

                <button type="reset" class="btn btn-delete">Xóa Trắng</button>

                <button type="submit" class="btn btn-add">Lưu Thay Đổi</button>
            </div>

        </form>
    </div>

</body>
</html>