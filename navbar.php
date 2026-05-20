<div class="header-system">
  
</div>

<nav class="nav-bar">
    <a href="quanlysinhvien.php" class="<?= basename($_SERVER['PHP_SELF']) == 'quanlysinhvien.php' ? 'active' : '' ?>">
        Quản Lý Sinh Viên
    </a>
    <a href="ql_lop.php" class="<?= basename($_SERVER['PHP_SELF']) == 'ql_lop.php' ? 'active' : '' ?>">
        Quản Lý Lớp
    </a>
    <a href="quanlymonhoc.php" class="<?= basename($_SERVER['PHP_SELF']) == 'quanlymonhoc.php' ? 'active' : '' ?>">
        Quản Lý Môn Học
    </a>
    <a href="quanlydiem.php" class="<?= basename($_SERVER['PHP_SELF']) == 'quanlydiem.php' ? 'active' : '' ?>">
        Quản Lý Điểm
    </a>
    <a href="ql_giangvien.php" class="<?= basename($_SERVER['PHP_SELF']) == 'ql_giangvien.php' ? 'active' : '' ?>">
        Quản Lý Giảng Viên
    </a>
    <a href="lichsu.php" class="<?= basename($_SERVER['PHP_SELF']) == 'lichsu.php' ? 'active' : '' ?>">
        Nhật Ký Hoạt Động
    </a>

    <a href="doimatkhau.php" class="<?= basename($_SERVER['PHP_SELF']) == 'doimatkhau.php' ? 'active' : '' ?>">
        Đổi Mật Khẩu
    </a>
    
    <a href="dangnhap.php" class="btn-logout">
        Đăng Xuất
    </a>
</nav>