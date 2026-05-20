<?php
header("Content-Type: application/json; charset=UTF-8");
include_once 'db_ketnoi.php';

$method = $_SERVER['REQUEST_METHOD'];

/* ===== HÀM LẤY DỮ LIỆU ===== */
function getInput() {
    $raw = file_get_contents("php://input");

    // Nếu có JSON
    if (!empty($raw)) {
        $data = json_decode($raw, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }
    }

    // fallback form-data
    if (!empty($_POST)) {
        return $_POST;
    }

    return [];
}

/* ===== RESPONSE ===== */
function response($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/* ================= API ================= */
switch ($method) {

    /* ===== GET: DANH SÁCH ===== */
 case 'GET':
    $tukhoa = $_GET['tukhoa'] ?? '';
    $ma_lop = $_GET['ma_lop'] ?? '';
    $ma_sv = $_GET['ma_sv'] ?? '';

    $sql = "SELECT * FROM sinhvien WHERE 1";

    if ($ma_sv != '') {
        $sql .= " AND ma_sv='$ma_sv'";
    }

    if ($tukhoa != '') {
        $sql .= " AND (ma_sv LIKE '%$tukhoa%' OR ho_ten LIKE '%$tukhoa%')";
    }

    if ($ma_lop != '') {
        $sql .= " AND ma_lop='$ma_lop'";
    }

    $rs = mysqli_query($conn, $sql);

    if (!$rs) {
        response(["error" => mysqli_error($conn)], 500);
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($rs)) {
        $data[] = $row;
    }

    response($data); // QUAN TRỌNG
    break; // QUAN TRỌNG

    /* ===== POST: THÊM ===== */
    case 'POST':
        $input = getInput();

        // DEBUG (bỏ khi chạy thật)
        // response(["debug" => $input]);

        if (empty($input)) {
            response(["error" => "Không nhận được dữ liệu"], 400);
        }

        $ma_sv = $input['ma_sv'] ?? '';
        $ho_ten = $input['ho_ten'] ?? '';
        $ngay_sinh = $input['ngay_sinh'] ?? '';
        $gioi_tinh = $input['gioi_tinh'] ?? '';
        $que_quan = $input['que_quan'] ?? '';
        $ma_lop = $input['ma_lop'] ?? '';

        if ($ma_sv == '' || $ma_lop == '') {
            response([
                "error" => "Thiếu dữ liệu",
                "data_nhan_duoc" => $input
            ], 400);
        }

        $sql = "INSERT INTO sinhvien VALUES (
            '$ma_sv','$ho_ten','$ngay_sinh','$gioi_tinh','$que_quan','$ma_lop'
        )";

        if (mysqli_query($conn, $sql)) {
            response(["message" => "Thêm sinh viên thành công"]);
        } else {
            response(["error" => mysqli_error($conn)], 500);
        }
        break;

    /* ===== PUT: CẬP NHẬT ===== */
    case 'PUT':
    $input = getInput();

    if (empty($input)) {
        response(["error" => "Không nhận được dữ liệu"], 400);
    }

    $ma_sv = $input['ma_sv'] ?? '';

    if ($ma_sv == '') {
        response(["error" => "Thiếu mã sinh viên"], 400);
    }

    $sql = "UPDATE sinhvien SET 
        ho_ten='{$input['ho_ten']}',
        ngay_sinh='{$input['ngay_sinh']}',
        gioi_tinh='{$input['gioi_tinh']}',
        que_quan='{$input['que_quan']}',
        ma_lop='{$input['ma_lop']}'
    WHERE ma_sv='$ma_sv'";

    if (mysqli_query($conn, $sql)) {

        if (mysqli_affected_rows($conn) > 0) {
            response(["message" => "Cập nhật thành công"]);
        } else {
            response([
                "warning" => "Không có dữ liệu nào được cập nhật",
                "reason" => "Có thể mã SV không tồn tại hoặc dữ liệu không thay đổi"
            ]);
        }

    } else {
        response(["error" => mysqli_error($conn)], 500);
    }
    break;

    /* ===== DELETE: XOÁ ===== */
    case 'DELETE':

    // Nhận cả GET và JSON (pro hơn)
    $input = getInput();
    $ma_sv = $_GET['ma_sv'] ?? ($input['ma_sv'] ?? '');

    if ($ma_sv == '') {
        response(["error" => "Thiếu mã sinh viên"], 400);
    }

    $sql = "DELETE FROM sinhvien WHERE ma_sv='$ma_sv'";

    if (mysqli_query($conn, $sql)) {

        if (mysqli_affected_rows($conn) > 0) {
            response(["message" => "Xóa thành công"]);
        } else {
            response([
                "warning" => "Không tìm thấy sinh viên để xóa"
            ]);
        }

    } else {
        response(["error" => mysqli_error($conn)], 500);
    }
    break;
}
?>