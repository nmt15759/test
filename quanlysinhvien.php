<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* ===== KẾT NỐI DB ===== */
include_once 'db_ketnoi.php'; 

$sv_sua = null;

/* ===== LẤY DỮ LIỆU SỬA ===== */
if (isset($_GET['sua'])) {
    $ma_sv = $_GET['sua'];
    $kq = mysqli_query($conn, "SELECT * FROM sinhvien WHERE ma_sv='$ma_sv'");
    $sv_sua = mysqli_fetch_assoc($kq);
}

$dsGT = ['Nam'=>'Nam', 'Nữ'=>'Nữ'];
$tukhoa = $_GET['tukhoa'] ?? '';
$loc_ma_lop = $_GET['loc_ma_lop'] ?? ''; 
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý sinh viên</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.modal {
    display: <?= $sv_sua ? 'flex' : 'none' ?>; 
    position: fixed; z-index: 1000; left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    align-items: center; justify-content: center;
}
.modal-content {
    background: #fff; padding: 30px; border-radius: 12px;
    width: 90%; max-width: 650px; position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    animation: slideDown 0.4s ease;
}
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-50px); }
    to { opacity: 1; transform: translateY(0); }
}
.close-btn {
    position: absolute; top: 15px; right: 20px;
    font-size: 24px; cursor: pointer; color: #999;
}
.close-btn:hover { color: #ff0000; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; text-align: left; }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
<h2 style="margin-top: 20px;">QUẢN LÝ SINH VIÊN</h2>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

<button class="btn btn-add" onclick="moModal()">
<i class="fa-solid fa-user-plus"></i> Thêm Sinh Viên
</button>

<form method="get" style="display: flex; gap: 10px;">
<select name="loc_ma_lop" class="form-control" style="width: auto;">
<option value="">-- Tất cả lớp --</option>
<?php
$q_lops = mysqli_query($conn, "SELECT ma_lop FROM lop");
while ($rl = mysqli_fetch_assoc($q_lops)) {
    $s = ($loc_ma_lop == $rl['ma_lop']) ? "selected" : "";
    echo "<option value='{$rl['ma_lop']}' $s>{$rl['ma_lop']}</option>";
}
?>
</select>

<input type="text" name="tukhoa" class="form-control" placeholder="Tên hoặc mã SV..." value="<?= $tukhoa ?>" style="width: 200px;">

<button type="submit" class="btn btn-view">
<i class="fa-solid fa-magnifying-glass"></i> Tìm
</button>

<a href="quanlysinhvien.php" class="btn btn-home">
<i class="fa-solid fa-rotate-right"></i>
</a>
</form>
</div>

<table>
<thead>
<tr>
<th>Mã SV</th>
<th>Họ tên</th>
<th>Ngày sinh</th>
<th>Giới tính</th>
<th>Quê quán</th>
<th>Lớp</th>
<th>Hành động</th>
</tr>
</thead>

<tbody>
<?php
$sql = "SELECT * FROM sinhvien WHERE (ma_sv LIKE '%$tukhoa%' OR ho_ten LIKE '%$tukhoa%')";
if ($loc_ma_lop != '') $sql .= " AND ma_lop = '$loc_ma_lop'";
$sql .= " ORDER BY ma_lop, ma_sv";

$ds = mysqli_query($conn, $sql);
while ($r = mysqli_fetch_assoc($ds)) {
?>
<tr>
<td style="font-weight: bold; color: #007bff;"><?= $r['ma_sv'] ?></td>
<td style="text-align: left; padding-left: 15px;"><?= $r['ho_ten'] ?></td>
<td><?= date('d/m/Y', strtotime($r['ngay_sinh'])) ?></td>
<td><?= $r['gioi_tinh'] ?></td>
<td><?= $r['que_quan'] ?></td>
<td><span class="badge" style="background:#eee; padding:5px 10px; border-radius:15px;"><?= $r['ma_lop'] ?></span></td>
<td>
<a class="btn btn-edit" href="?sua=<?= $r['ma_sv'] ?>">
<i class="fa-solid fa-pen-to-square"></i>
</a>

<a class="btn btn-delete" href="javascript:void(0);"
onclick="xacNhanXoa('xuly_sinhvien.php?xoa=<?= $r['ma_sv'] ?>', '<?= $r['ho_ten'] ?>')">
<i class="fa-solid fa-trash"></i>
</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>

<div style="margin-top: 20px;">
<a href="formchinh.php" class="btn btn-home">
<i class="fa-solid fa-house"></i> Về Trang Chủ
</a>
</div>
</div>

<!-- MODAL -->
<div id="formModal" class="modal">
<div class="modal-content">
<span class="close-btn" onclick="dongModal()">&times;</span>

<h3 style="margin-bottom: 25px;">
<i class="fa-solid <?= $sv_sua ? 'fa-user-pen' : 'fa-user-plus' ?>"></i> 
<?= $sv_sua ? 'CẬP NHẬT SINH VIÊN' : 'THÊM SINH VIÊN MỚI' ?>
</h3>

<form method="post" action="xuly_sinhvien.php">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
        
        <div class="form-group">
            <label>Mã Sinh Viên:</label>
            <input type="text" name="ma_sv" class="form-control" required 
                value="<?= $sv_sua['ma_sv'] ?? '' ?>" 
                <?= $sv_sua ? 'readonly style="background:#f1f1f1"' : '' ?>>
        </div>

        <div class="form-group">
            <label>Họ và Tên:</label>
            <input type="text" name="ho_ten" class="form-control" required 
                value="<?= $sv_sua['ho_ten'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label>Ngày sinh:</label>
            <input type="date" name="ngay_sinh" class="form-control" 
                value="<?= $sv_sua['ngay_sinh'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label>Giới tính:</label>
            <select name="gioi_tinh" class="form-control">
                <?php foreach ($dsGT as $k=>$v) {
                    $sel = (($sv_sua['gioi_tinh'] ?? '')==$k) ? "selected" : "";
                    echo "<option value='$k' $sel>$v</option>";
                } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Quê quán:</label>
            <input type="text" name="que_quan" class="form-control" 
                value="<?= $sv_sua['que_quan'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label>Mã lớp:</label>
            <select name="ma_lop" class="form-control">
                <?php
                $lop = mysqli_query($conn,"SELECT ma_lop FROM lop");
                while ($r = mysqli_fetch_assoc($lop)) {
                    $sel = ($sv_sua && $sv_sua['ma_lop']==$r['ma_lop']) ? "selected" : "";
                    echo "<option value='{$r['ma_lop']}' $sel>{$r['ma_lop']}</option>";
                }
                ?>
            </select>
        </div>

    </div>

    <div style="margin-top: 30px; display: flex; justify-content: center; gap: 10px;">
        <?php if ($sv_sua): ?>
            <button type="submit" name="capnhat" class="btn btn-add">
                <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
            </button>
        <?php else: ?>
            <button type="submit" name="them" class="btn btn-add">
                <i class="fa-solid fa-check"></i> Xác nhận thêm
            </button>
        <?php endif; ?>

        <button type="button" class="btn btn-delete" onclick="dongModal()">Hủy bỏ</button>
    </div>
</form>

</form>
</div>
</div>

<script>
function moModal(){
    document.getElementById("formModal").style.display="flex";
}

function dongModal(){
    document.getElementById("formModal").style.display="none";
    <?php if ($sv_sua) echo "window.location.href='quanlysinhvien.php';"; ?>
}

function xacNhanXoa(url, tenSV){
    Swal.fire({
        title: 'Bạn có chắc?',
        text: "Xóa " + tenSV,
        icon: 'warning',
        showCancelButton: true
    }).then((result)=>{
        if(result.isConfirmed){
            window.location.href = url;
        }
    })
}

<?php if (isset($_SESSION['thongbao'])): ?>
Swal.fire({
    icon: 'success',
    text: '<?= $_SESSION['thongbao'] ?>',
    timer: 2000,
    showConfirmButton: false
});
<?php unset($_SESSION['thongbao']); endif; ?>
</script>

</body>
</html>