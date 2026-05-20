<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Thêm Lớp Học Mới</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container" style="max-width: 600px;">
        <h3><i class="fa-solid fa-plus-circle"></i> Thêm Lớp Học Mới</h3>
        
        <form id="formThemLop" method="post" action="ql_lop_them_xuly.php">
            <div class="form-group">
                <label>Mã lớp:</label>
                <input type="text" name="txt_ma" id="txt_ma" class="form-control" placeholder="Ví dụ: CNTT3">
            </div>

            <div class="form-group">
                <label>Tên lớp:</label>
                <input type="text" name="txt_ten" id="txt_ten" class="form-control">
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Niên khóa:</label>
                    <input type="text" name="txt_nienkhoa" id="txt_nk" class="form-control" placeholder="Ví dụ : K74">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Phòng học:</label>
                    <input type="text" name="txt_phong" id="txt_phong" class="form-control" placeholder="Ví dụ : Phòng 402">
                </div>
            </div>

            <div style="display: flex; gap: 10px; align-items: flex-end;">
                <div class="form-group" style="flex: 2;">
                    <label>Thứ:</label>
                    <select name="txt_thu" id="txt_thu" class="form-control">
                        <option value="">-- Chọn thứ --</option>
                        <?php for($i=2; $i<=7; $i++) echo "<option value='$i'>Thứ $i</option>"; ?>
                        <option value="8">Chủ Nhật</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 1.5;">
                    <label>Thời gian:</label>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        Tiết: <input type="number" name="txt_s1" id="txt_s1" class="form-control" min="1" max="12" value="1">
                        đến <input type="number" name="txt_e1" id="txt_e1" class="form-control" min="1" max="12" value="3">
                    </div>
                </div>
            </div>
            
            <small id="error-msg" style="color: red; font-weight: bold; display: block; margin-top: 5px; margin-bottom: 10px;"></small>

            <div class="form-group">
                <label>Giáo viên dạy:</label>
                <select name="sel_gv" id="sel_gv" class="form-control">
                    <option value="">-- Chọn giáo viên --</option>
                    <?php 
                        include("db_ketnoi.php");
                        $ds_gv = mysqli_query($conn, "SELECT * FROM giangvien");
                        while($gv = mysqli_fetch_object($ds_gv)) {
                            echo "<option value='$gv->ma_gv'>$gv->ho_ten</option>";
                        }
                    ?>
                </select>
            </div>

            <div style="text-align: center; margin-top: 30px; display: flex; justify-content: center; gap: 10px;">
                <button type="button" onclick="handleSave()" class="btn btn-add" style="width: 150px;">Lưu Thông Tin</button>
                <a href="ql_lop.php" class="btn btn-delete" style="width: 100px; text-align: center;">Hủy</a>
            </div>
        </form>
    </div>

    <script>
    function handleSave() {
        // thu thập dữ liệu từ các ô nhập liệu
        let ma = document.getElementById('txt_ma').value.trim();
        let ten = document.getElementById('txt_ten').value.trim();
        let nk = document.getElementById('txt_nk').value.trim();
        let phong = document.getElementById('txt_phong').value.trim();
        let thu = document.getElementById('txt_thu').value;
        let s1 = document.getElementById('txt_s1').value;
        let e1 = document.getElementById('txt_e1').value;
        let gv = document.getElementById('sel_gv').value;
        
        let msg = document.getElementById('error-msg');

        //Kiểm tra bỏ trống
        if (ma === "" || ten === "" || nk === "" || phong === "" || thu === "" || gv === "") {
            msg.innerHTML = " Vui lòng nhập đầy đủ tất cả các thông tin!";
            return; // Dừng lại, không cho lưu
        }

        //Nếu đã nhập đủ, thực hiện kiểm tra trùng qua AJAX
        msg.innerHTML = "Đang kiểm tra dữ liệu...";
        // Kiểm tra tiết bắt đầu phải <= tiết kết thúc
		if (parseInt(s1) > parseInt(e1)) {
			msg.innerHTML = " Tiết bắt đầu phải nhỏ hơn hoặc bằng tiết kết thúc!";
			return; // Dừng lại không cho gửi dữ liệu
}
        fetch(`check_trung_lich.php?mode=add&ma=${ma}&ten=${ten}&nk=${nk}&phong=${phong}&thu=${thu}&s1=${s1}&e1=${e1}&gv=${gv}`)
            .then(res => res.text())
            .then(data => {
                if (data.trim() !== 'ok') {
                    // Nếu có lỗi trùng (mã, tên hoặc lịch) hiện chữ đỏ
                    msg.innerHTML = "⚠️ " + data;
                } else {
                    // Nếu mọi thứ đều ổn, gửi form đi
                    msg.innerHTML = "";
                    document.getElementById('formThemLop').submit();
                }
            })
            .catch(error => {
                msg.innerHTML = " Có lỗi xảy ra khi kết nối máy chủ!";
            });
    }

    // Xóa thông báo lỗi khi người dùng bắt đầu gõ lại để cho "gọn"
    ['txt_ma', 'txt_ten', 'txt_nk', 'txt_phong', 'txt_thu', 'sel_gv'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => {
            document.getElementById('error-msg').innerHTML = "";
        });
    });
    </script>
</body>
</html>