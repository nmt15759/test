<?php
    include_once 'db_ketnoi.php';
    $result = mysqli_query($conn, "SELECT * FROM monhoc");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản lý môn học</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h2>DANH SÁCH MÔN HỌC</h2>

        <div class="search-box" style="text-align: right; margin-bottom: 20px;">
            <a href="f_them_monhoc.php" class="btn btn-add">
                <i class="fa-solid fa-plus"></i> Thêm môn học mới
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mã Môn</th>
                    <th>Tên Môn Học</th>
                    <th>Số Tín Chỉ</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_object($result)) { ?>
                <tr>
                    <td align="center"><strong><?php echo $row->ma_mh; ?></strong></td>
                    <td><?php echo $row->ten_mh; ?></td>
                    <td align="center"><?php echo $row->so_tin_chi; ?></td>
                    <td align="center">
                        <a href="f_sua_monhoc.php?ma=<?php echo $row->ma_mh; ?>" class="btn btn-edit" style="height: 30px; padding: 0 10px;">
                            <i class="fa-solid fa-pen-to-square"></i> Sửa
                        </a> 
                        
                        <a href="xuly_monhoc.php?ma_xoa=<?php echo $row->ma_mh; ?>" 
                           class="btn btn-delete" style="height: 30px; padding: 0 10px;"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa môn <?php echo $row->ten_mh; ?>?')">
                           <i class="fa-solid fa-trash"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>      
		<a href="formchinh.php" class="btn btn-home"><i class="fa-solid fa-house"></i> Về Trang Chủ</a>
        </div>

</body>
	
</html>