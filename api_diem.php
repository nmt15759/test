<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once 'db_ketnoi.php';

// Hàm trả về JSON response
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

// Hàm kiểm tra điểm hợp lệ (0-10)
function validateDiem($tp1, $tp2, $ck) {
    return ($tp1 >= 0 && $tp1 <= 10) && ($tp2 >= 0 && $tp2 <= 10) && ($ck >= 0 && $ck <= 10);
}

// Hàm tính điểm tổng
function tinhDiemTong($tp1, $tp2, $ck) {
    return round(($tp1 * 0.1) + ($tp2 * 0.3) + ($ck * 0.6), 1);
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        // Liệt kê điểm với lọc
        $ma_sv = $_GET['ma_sv'] ?? '';
        $ma_lop = $_GET['ma_lop'] ?? '';

        $conditions = [];
        if ($ma_sv) $conditions[] = "ma_sv = '$ma_sv'";
        if ($ma_lop) $conditions[] = "ma_lop = '$ma_lop'";
        $where = count($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

        $result = mysqli_query($conn, "SELECT * FROM diem $where ORDER BY ma_sv ASC, ma_mh ASC");
        $diem = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $row['diem_tong'] = tinhDiemTong($row['diem_tp1'], $row['diem_tp2'], $row['diem_ck']);
            $diem[] = $row;
        }
        jsonResponse(['success' => true, 'data' => $diem]);
        break;

    case 'POST':
        // Thêm điểm mới
        if (!$input || !isset($input['ma_sv'], $input['ma_lop'], $input['ma_mh'], $input['diem_tp1'], $input['diem_tp2'], $input['diem_ck'])) {
            jsonResponse(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc'], 400);
        }

        $ma_sv = trim($input['ma_sv']);
        $ma_lop = trim($input['ma_lop']);
        $ma_mh = trim($input['ma_mh']);
        $tp1 = (float)$input['diem_tp1'];
        $tp2 = (float)$input['diem_tp2'];
        $ck = (float)$input['diem_ck'];

        if (empty($ma_sv) || empty($ma_lop) || empty($ma_mh) || !validateDiem($tp1, $tp2, $ck)) {
            jsonResponse(['success' => false, 'message' => 'Dữ liệu không hợp lệ'], 400);
        }

        // Kiểm tra trùng lặp
        $check = mysqli_query($conn, "SELECT id FROM diem WHERE ma_sv = '$ma_sv' AND ma_mh = '$ma_mh'");
        if (mysqli_num_rows($check) > 0) {
            jsonResponse(['success' => false, 'message' => 'Sinh viên đã có điểm môn học này'], 409);
        }

        $sql = "INSERT INTO diem (ma_sv, ma_lop, ma_mh, diem_tp1, diem_tp2, diem_ck) VALUES ('$ma_sv', '$ma_lop', '$ma_mh', '$tp1', '$tp2', '$ck')";
        if (mysqli_query($conn, $sql)) {
            $id = mysqli_insert_id($conn);
            jsonResponse(['success' => true, 'message' => 'Thêm điểm thành công', 'data' => ['id' => $id]]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi thêm điểm'], 500);
        }
        break;

    case 'PUT':
        // Cập nhật điểm
        $id = $_GET['id'] ?? null;
        if (!$id || !$input || !isset($input['diem_tp1'], $input['diem_tp2'], $input['diem_ck'])) {
            jsonResponse(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc'], 400);
        }

        $tp1 = (float)$input['diem_tp1'];
        $tp2 = (float)$input['diem_tp2'];
        $ck = (float)$input['diem_ck'];

        if (!validateDiem($tp1, $tp2, $ck)) {
            jsonResponse(['success' => false, 'message' => 'Điểm không hợp lệ (0-10)'], 400);
        }

        $sql = "UPDATE diem SET diem_tp1='$tp1', diem_tp2='$tp2', diem_ck='$ck' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Cập nhật điểm thành công']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi cập nhật điểm'], 500);
        }
        break;

    case 'DELETE':
        // Xóa điểm
        $id = $_GET['id'] ?? null;
        if (!$id) {
            jsonResponse(['success' => false, 'message' => 'Thiếu ID điểm'], 400);
        }

        $sql = "DELETE FROM diem WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Xóa điểm thành công']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi xóa điểm'], 500);
        }
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Phương thức không được hỗ trợ'], 405);
        break;
}
?>