<?php session_start(); ?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản Lý Lớp Học</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	
    <?php include 'navbar.php'; ?>
	
	<div class="container">
        <h2>DANH SÁCH LỚP HỌC</h2>

        <div class="search-box">
<!--TÌM-->
           <form method="get"> 
                <input type="text" name="txt_tim" placeholder="Tìm tên hoặc mã lớp...">
                <button type="submit" class="btn btn-add">Tìm kiếm</button>
            </form>
        </div>

        <?php
            include("db_ketnoi.php");

            $ma_edit = $_GET['ma_edit'] ?? "";
            $nk_edit = $_GET['nk_edit'] ?? "";
            $tukhoa = $_GET['txt_tim'] ?? "";

            $ds_gv = mysqli_query($conn, "SELECT * FROM giangvien");
            $gv_list = [];
            while($g = mysqli_fetch_object($ds_gv)) { $gv_list[] = $g; }

            $sql = "SELECT l.*, g.ho_ten FROM lop l 
                    LEFT JOIN giangvien g ON l.ma_gv = g.ma_gv 
                    WHERE l.ten_lop LIKE '%$tukhoa%' OR l.ma_lop LIKE '%$tukhoa%'";
            $result = mysqli_query($conn, $sql);
        ?>
<!--SỬA-->
        <form method="post" action="ql_lop_sua_xuly.php">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã Lớp</th>
                    <th>Tên Lớp</th>
                    <th>Niên Khóa</th>
                    <th>Phòng</th>
                    <th>Lịch Học</th>
                    <th>Giáo Viên</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
				if (mysqli_num_rows($result) == 0) {
            echo "<tr>";
            echo "<td colspan='8' align='center' style='color: red; padding: 20px; font-weight: bold;'>";
            echo " Không tìm thấy dữ liệu nào phù hợp với từ khóa: '$tukhoa'";
            echo "</td>";
            echo "</tr>";
        }
        
                    $stt = 0;
                    $ten_thu = [2=>"Thứ 2", 3=>"Thứ 3", 4=>"Thứ 4", 5=>"Thứ 5", 6=>"Thứ 6", 7=>"Thứ 7", 8=>"Chủ Nhật"];
                    while($row = mysqli_fetch_object($result)) {
                        $stt++;
/* chế độ sửa */ if ($row->ma_lop == $ma_edit && $row->nien_khoa == $nk_edit) { 
                ?>
                    <tr style="background-color: #fff9c4;">
                        <input type="hidden" name="old_nk" id="old_nk" value="<?php echo $row->nien_khoa; ?>">
                        <td align="center"><?php echo $stt; ?></td>
                        <td><input type="text" name="txt_ma" id="ma_edit" value="<?php echo $row->ma_lop; ?>" readonly style="background:#eee; width:70px;"></td>
                        <td><input type="text" name="txt_ten" value="<?php echo $row->ten_lop; ?>" class="form-control" required></td>
                        <td><input type="text" name="txt_nienkhoa" value="<?php echo $row->nien_khoa; ?>" class="form-control" required></td>
                        <td><input type="text" name="txt_phong" id="phong_edit" value="<?php echo $row->phong_hoc; ?>" class="form-control"></td>
                        <td>
                            <select name="txt_thu" id="thu_edit" class="form-control" style="margin-bottom:5px;">
                                <?php for($i=2;$i<=8;$i++) echo "<option value='$i' ".($row->thu==$i?'selected':'').">".$ten_thu[$i]."</option>"; ?>
                            </select>
                            Tiết: <input type="number" name="txt_s1" id="s1_edit" value="<?php echo $row->tiet_bat_dau; ?>" style="width:35px;"> - 
                            <input type="number" name="txt_e1" id="e1_edit" value="<?php echo $row->tiet_ket_thuc; ?>" style="width:35px;">
                            <br><small id="msg-edit-error" style="color:red; font-weight:bold;"></small>
                        </td>
                        <td>
                            <select name="sel_gv" id="gv_edit" class="form-control">
                                <?php foreach($gv_list as $gv) echo "<option value='$gv->ma_gv' ".($row->ma_gv==$gv->ma_gv?'selected':'').">$gv->ho_ten</option>"; ?>
                            </select>
                        </td>
                        <td align="center">
                            <button type="submit" id="btn-save" class="btn btn-add">Lưu</button>
                            <a href="ql_lop.php" class="btn btn-delete">Hủy</a>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td align="center"><?php echo $stt; ?></td>
                        <td><strong><?php echo $row->ma_lop; ?></strong></td>
                        <td><?php echo $row->ten_lop; ?></td>
                        <td align="center"><?php echo $row->nien_khoa; ?></td>
                        <td align="center"><?php echo $row->phong_hoc; ?></td>
                        <td><?php echo $ten_thu[$row->thu] ?? ''; ?> (Tiết: <?php echo $row->tiet_bat_dau; ?>-<?php echo $row->tiet_ket_thuc; ?>)</td>
                        <td><?php echo $row->ho_ten; ?></td>
                        <td align="center">
                            <a href="ql_lop.php?ma_edit=<?php echo $row->ma_lop; ?>&nk_edit=<?php echo $row->nien_khoa; ?>" class="btn btn-edit">Sửa</a>
                            <a href="javascript:void(0)" class="btn btn-delete" onclick="confirmDelete('<?php echo $row->ma_lop; ?>', '<?php echo $row->nien_khoa; ?>')">Xóa</a>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
        </form>

        <div class="navigation-group">
            <a href="ql_lop_them.php" class="btn btn-add"><i class="fa-solid fa-plus"></i> Thêm Lớp</a>
            <a href="formchinh.php" class="btn btn-home"><i class="fa-solid fa-house"></i> Về Trang Chủ</a>
        </div>
    </div>

    <script>
    function checkEditLive() {
    let ma = document.getElementById('ma_edit').value;
    let p = document.getElementById('phong_edit').value;
    let t = document.getElementById('thu_edit').value;
    let s = document.getElementById('s1_edit').value;
    let e = document.getElementById('e1_edit').value;
    let gv = document.getElementById('gv_edit').value;
    
    // Lấy niên khóa hiện tại đang gõ và niên khóa gốc ban đầu
    let current_nk = document.querySelector('input[name="txt_nienkhoa"]').value;
    let old_nk = document.getElementById('old_nk').value;

    // Gửi kèm mode=edit và old_nk sang file kiểm tra
    fetch(`check_trung_lich.php?mode=edit&ma=${ma}&nk=${current_nk}&old_nk=${old_nk}&phong=${p}&thu=${t}&s1=${s}&e1=${e}&gv=${gv}`)
    .then(r => r.text()).then(data => {
        let msg = document.getElementById('msg-edit-error');
        let btn = document.getElementById('btn-save');
        if(data.trim() !== 'ok') {
            msg.innerHTML = " " + data;
            btn.disabled = true;
            btn.style.opacity = '0.5';
        } else {
            msg.innerHTML = "";
            btn.disabled = false;
            btn.style.opacity = '1';
        }
		if (parseInt(s) > parseInt(e)) {
			msg.innerHTML = " Tiết bắt đầu không thể lớn hơn tiết kết thúc!";
			btn.disabled = true;
			return; // Dừng lại
}
    });
}

    // Gắn sự kiện lắng nghe cho các ô nhập liệu
    if(document.getElementById('phong_edit')) {
        ['phong_edit', 'thu_edit', 's1_edit', 'e1_edit', 'gv_edit'].forEach(id => {
            document.getElementById(id).addEventListener('input', checkEditLive);
            document.getElementById(id).addEventListener('change', checkEditLive);
        });
    }

    // 2. Hàm xác nhận xóa
    function confirmDelete(ma, nk) {
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: `Lớp ${ma} niên khóa ${nk} sẽ bị xóa vĩnh viễn!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `ql_lop_xoa.php?ma=${ma}&nk=${nk}`;
            }
        });
    }
    </script>
	<?php
    // Kiểm tra nếu có thông báo trong Session
    if (isset($_SESSION['thongbao_msg'])) {
        $msg = $_SESSION['thongbao_msg'];
        $icon = $_SESSION['thongbao_icon'];
    ?>
        <script>
            Swal.fire({
                title: 'Thông báo',
                text: '<?php echo $msg; ?>',
                icon: '<?php echo $icon; ?>', 
                confirmButtonText: 'OK',
                timer: 5000, 
                timerProgressBar: true
            });
        </script>
    <?php
        // Hiện xong thì xóa thông báo để không hiện lại khi F5
        unset($_SESSION['thongbao_msg']);
        unset($_SESSION['thongbao_icon']);
    }
    ?>
    </body>
</html>
</body>
</html>