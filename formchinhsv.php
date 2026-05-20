<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cổng Sinh Viên</title>
<style>
    /* 1. Thiết lập chung (Full Screen) */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        color: #333;
        line-height: 1.6;
        padding: 0; /* Tràn màn hình */
    }

    /* 2. Header */
    header {
        background: linear-gradient(90deg, #0062cc, #004494); /* Xanh tươi hơn chút cho SV */
        color: white;
        text-align: center;
        padding: 15px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    header h3 {
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 1.4rem;
        margin: 0;
    }
    
    header p {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-top: 5px;
    }

    /* 3. Thanh Menu (Một hàng ngang) */
    .nav-menu {
        display: flex;
        flex-wrap: nowrap; /* Bắt buộc 1 hàng */
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        width: 100%;
    }

    .nav-item {
        flex: 1; /* Chia đều độ rộng màn hình cho các nút */
        text-decoration: none;
        color: #555;
        font-weight: 600;
        padding: 15px 10px;
        text-align: center;
        border-right: 1px solid #eee;
        transition: all 0.2s ease;
        white-space: nowrap; 
    }

    .nav-item:last-child {
        border-right: none;
    }

    /* Hiệu ứng hover */
    .nav-item:hover {
        background-color: #e9ecef;
        color: #0062cc;
    }

    /* Nút đang chọn (Active) - ví dụ đang ở trang chủ */
    .nav-item.active {
        border-bottom: 3px solid #0062cc;
        color: #0062cc;
        background-color: #f8f9fa;
    }

    /* Nút Đăng Xuất */
    .nav-item.logout {
        color: #dc3545;
        background-color: #fff0f1;
    }

    .nav-item.logout:hover {
        background-color: #dc3545;
        color: white;
    }

    /* 4. Nội dung chính */
    .content-area {
        padding: 40px 20px;
        text-align: center;
        color: #6c757d;
        min-height: 80vh;
        max-width: 1000px; /* Giới hạn độ rộng nội dung cho dễ đọc */
        margin: 0 auto;
    }
    
    .welcome-box {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

</style>
</head>

<body>

    <header>
        <h3>CỔNG THÔNG TIN SINH VIÊN</h3>
        <p>&nbsp;</p>
    </header>

    <nav class="nav-menu">
        <a href="index.php" class="nav-item active">Trang Chủ</a> 
        <a href="xemdiem.php" class="nav-item">Xem Điểm</a>
        <a href="lichhoc.php" class="nav-item">Lịch Học</a>
        
        <a href="doimatkhausv.php" class="nav-item">Đổi Mật Khẩu</a>
        <a href="dangnhap.php" class="nav-item logout">Đăng Xuất</a>
    </nav>

    <main class="content-area">
        <div class="welcome-box">
            <h1>Xin chào, Sinh viên!</h1>
            <p>Chọn chức năng "Xem Điểm" trên thanh menu để tra cứu kết quả học tập.</p>
        </div>
    </main>

</body>
</html>