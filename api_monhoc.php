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

// Hàm kiểm tra trùng lặp
function checkDuplicate($conn, $field, $value, $excludeMa = null) {
    $query = "SELECT ma_mh FROM monhoc WHERE $field = '$value'";
    if ($excludeMa) {
        $query .= " AND ma_mh != '$excludeMa'";
    }
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        // Liệt kê tất cả môn học
        $result = mysqli_query($conn, "SELECT * FROM monhoc ORDER BY ma_mh ASC");
        $monhoc = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $monhoc[] = $row;
        }
        jsonResponse(['success' => true, 'data' => $monhoc]);
        break;

    case 'POST':
        // Thêm môn học mới
        if (!$input || !isset($input['ma_mh'], $input['ten_mh'], $input['so_tin_chi'])) {
            jsonResponse(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc'], 400);
        }

        $ma = trim($input['ma_mh']);
        $ten = trim($input['ten_mh']);
        $stc = (int)$input['so_tin_chi'];

        if (empty($ma) || empty($ten) || $stc < 0) {
            jsonResponse(['success' => false, 'message' => 'Dữ liệu không hợp lệ'], 400);
        }

        if (checkDuplicate($conn, 'ma_mh', $ma)) {
            jsonResponse(['success' => false, 'message' => 'Mã môn học đã tồn tại'], 409);
        }

        if (checkDuplicate($conn, 'ten_mh', $ten)) {
            jsonResponse(['success' => false, 'message' => 'Tên môn học đã tồn tại'], 409);
        }

        $sql = "INSERT INTO monhoc (ma_mh, ten_mh, so_tin_chi) VALUES ('$ma', '$ten', '$stc')";
        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Thêm môn học thành công', 'data' => ['ma_mh' => $ma]]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi thêm môn học'], 500);
        }
        break;

    case 'PUT':
        // Cập nhật môn học
        $ma = $_GET['ma_mh'] ?? null;
        if (!$ma || !$input || !isset($input['ten_mh'], $input['so_tin_chi'])) {
            jsonResponse(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc'], 400);
        }

        $ten = trim($input['ten_mh']);
        $stc = (int)$input['so_tin_chi'];

        if (empty($ten) || $stc < 0) {
            jsonResponse(['success' => false, 'message' => 'Dữ liệu không hợp lệ'], 400);
        }

        if (checkDuplicate($conn, 'ten_mh', $ten, $ma)) {
            jsonResponse(['success' => false, 'message' => 'Tên môn học đã tồn tại'], 409);
        }

        $sql = "UPDATE monhoc SET ten_mh='$ten', so_tin_chi='$stc' WHERE ma_mh='$ma'";
        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Cập nhật môn học thành công']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi cập nhật môn học'], 500);
        }
        break;

    case 'DELETE':
        // Xóa môn học
        $ma = $_GET['ma_mh'] ?? null;
        if (!$ma) {
            jsonResponse(['success' => false, 'message' => 'Thiếu mã môn học'], 400);
        }

        $sql = "DELETE FROM monhoc WHERE ma_mh = '$ma'";
        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Xóa môn học thành công']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi xóa môn học'], 500);
        }
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Phương thức không được hỗ trợ'], 405);
        break;
}
?>