<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

include_once 'db_ketnoi.php';

// Hàm trả về JSON response
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Hàm kiểm tra trùng lặp mã lớp
function checkDuplicateLop($conn, $ma_lop, $nien_khoa, $exclude = false) {
    if ($exclude) {
        // Loại trừ bản ghi hiện tại khi cập nhật
        $query = "SELECT ma_lop FROM lop WHERE ma_lop = '$ma_lop' AND nien_khoa != '$nien_khoa'";
    } else {
        $query = "SELECT ma_lop FROM lop WHERE ma_lop = '$ma_lop' AND nien_khoa = '$nien_khoa'";
    }
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Hàm kiểm tra giáo viên tồn tại
function checkGiaoVienExists($conn, $ma_gv) {
    if (empty($ma_gv) || $ma_gv === 'NULL') {
        return true; // Cho phép NULL (lớp không có giáo viên)
    }
    $query = "SELECT ma_gv FROM giangvien WHERE ma_gv = '$ma_gv'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Hàm kiểm tra xung đột lịch học
function checkConflictSchedule($conn, $thu, $tiet_bat_dau, $tiet_ket_thuc, $ma_lop = null, $nien_khoa = null) {
    $query = "SELECT COUNT(*) as count FROM lop 
              WHERE thu = $thu 
              AND ((tiet_bat_dau <= $tiet_ket_thuc AND tiet_ket_thuc >= $tiet_bat_dau))";
    
    if ($ma_lop && $nien_khoa) {
        $query .= " AND NOT (ma_lop = '$ma_lop' AND nien_khoa = '$nien_khoa')";
    }
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        // Liệt kê tất cả lớp học
        if (!isset($_GET['ma_lop']) && !isset($_GET['nien_khoa'])) {
            $tukhoa = $_GET['tim'] ?? '';
            $nien_khoa_filter = $_GET['nien_khoa'] ?? '';
            
            $sql = "SELECT l.*, g.ho_ten as ten_gv FROM lop l 
                    LEFT JOIN giangvien g ON l.ma_gv = g.ma_gv 
                    WHERE 1=1";
            
            if (!empty($tukhoa)) {
                $sql .= " AND (l.ten_lop LIKE '%$tukhoa%' OR l.ma_lop LIKE '%$tukhoa%')";
            }
            
            if (!empty($nien_khoa_filter)) {
                $sql .= " AND l.nien_khoa = '$nien_khoa_filter'";
            }
            
            $sql .= " ORDER BY l.nien_khoa DESC, l.ma_lop ASC";
            
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                jsonResponse(['success' => false, 'message' => 'Lỗi truy vấn: ' . mysqli_error($conn)], 500);
            }
            
            $lop = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $lop[] = $row;
            }
            jsonResponse(['success' => true, 'data' => $lop]);
        } else {
            // Lấy chi tiết một lớp cụ thể
            $ma_lop = $_GET['ma_lop'] ?? null;
            $nien_khoa = $_GET['nien_khoa'] ?? null;
            
            if (!$ma_lop || !$nien_khoa) {
                jsonResponse(['success' => false, 'message' => 'Thiếu mã lớp hoặc niên khóa'], 400);
            }
            
            $sql = "SELECT l.*, g.ho_ten as ten_gv FROM lop l 
                    LEFT JOIN giangvien g ON l.ma_gv = g.ma_gv 
                    WHERE l.ma_lop = '$ma_lop' AND l.nien_khoa = '$nien_khoa'";
            
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                jsonResponse(['success' => false, 'message' => 'Lỗi truy vấn: ' . mysqli_error($conn)], 500);
            }
            
            if (mysqli_num_rows($result) === 0) {
                jsonResponse(['success' => false, 'message' => 'Không tìm thấy lớp'], 404);
            }
            
            $lop = mysqli_fetch_assoc($result);
            jsonResponse(['success' => true, 'data' => $lop]);
        }
        break;

    case 'POST':
        // Thêm lớp học mới
        if (!$input || !isset($input['ma_lop'], $input['ten_lop'], $input['nien_khoa'], $input['thu'], $input['tiet_bat_dau'], $input['tiet_ket_thuc'])) {
            jsonResponse(['success' => false, 'message' => 'Thiếu dữ liệu bắt buộc'], 400);
        }

        $ma_lop = trim($input['ma_lop']);
        $ten_lop = trim($input['ten_lop']);
        $nien_khoa = trim($input['nien_khoa']);
        $phong_hoc = trim($input['phong_hoc'] ?? '');
        $thu = (int)$input['thu'];
        $tiet_bat_dau = (int)$input['tiet_bat_dau'];
        $tiet_ket_thuc = (int)$input['tiet_ket_thuc'];
        $ma_gv = trim($input['ma_gv'] ?? '');

        // Validation
        if (empty($ma_lop) || empty($ten_lop) || empty($nien_khoa)) {
            jsonResponse(['success' => false, 'message' => 'Mã lớp, tên lớp và niên khóa không được để trống'], 400);
        }

        if ($thu < 2 || $thu > 8) {
            jsonResponse(['success' => false, 'message' => 'Thứ phải từ 2 đến 8'], 400);
        }

        if ($tiet_bat_dau < 1 || $tiet_ket_thuc < 1 || $tiet_bat_dau > $tiet_ket_thuc) {
            jsonResponse(['success' => false, 'message' => 'Tiết học không hợp lệ'], 400);
        }

        // Kiểm tra trùng lặp
        if (checkDuplicateLop($conn, $ma_lop, $nien_khoa)) {
            jsonResponse(['success' => false, 'message' => 'Mã lớp đã tồn tại trong niên khóa này'], 409);
        }

        // Kiểm tra giáo viên
        if (!empty($ma_gv) && !checkGiaoVienExists($conn, $ma_gv)) {
            jsonResponse(['success' => false, 'message' => 'Giáo viên không tồn tại'], 404);
        }

        // Chuẩn bị câu lệnh SQL
        $gv_sql = empty($ma_gv) ? "NULL" : "'$ma_gv'";
        $sql = "INSERT INTO lop (ma_lop, ten_lop, nien_khoa, phong_hoc, thu, tiet_bat_dau, tiet_ket_thuc, ma_gv) 
                VALUES ('$ma_lop', '$ten_lop', '$nien_khoa', '$phong_hoc', $thu, $tiet_bat_dau, $tiet_ket_thuc, $gv_sql)";

        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Thêm lớp học thành công', 'data' => ['ma_lop' => $ma_lop, 'nien_khoa' => $nien_khoa]]);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi thêm lớp: ' . mysqli_error($conn)], 500);
        }
        break;

    case 'PUT':
        // Cập nhật thông tin lớp
        $ma_lop = $_GET['ma_lop'] ?? null;
        $nien_khoa = $_GET['nien_khoa'] ?? null;

        if (!$ma_lop || !$nien_khoa) {
            jsonResponse(['success' => false, 'message' => 'Thiếu mã lớp hoặc niên khóa'], 400);
        }

        if (!$input) {
            jsonResponse(['success' => false, 'message' => 'Không có dữ liệu cập nhật'], 400);
        }

        // Kiểm tra lớp tồn tại
        $check_sql = "SELECT * FROM lop WHERE ma_lop = '$ma_lop' AND nien_khoa = '$nien_khoa'";
        $check_result = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($check_result) === 0) {
            jsonResponse(['success' => false, 'message' => 'Lớp không tồn tại'], 404);
        }

        // Cập nhật từng field nếu có
        $updates = [];

        if (isset($input['ten_lop']) && !empty($input['ten_lop'])) {
            $updates[] = "ten_lop = '" . trim($input['ten_lop']) . "'";
        }

        if (isset($input['phong_hoc'])) {
            $updates[] = "phong_hoc = '" . trim($input['phong_hoc']) . "'";
        }

        if (isset($input['thu'])) {
            $thu = (int)$input['thu'];
            if ($thu < 2 || $thu > 8) {
                jsonResponse(['success' => false, 'message' => 'Thứ phải từ 2 đến 8'], 400);
            }
            $updates[] = "thu = $thu";
        }

        if (isset($input['tiet_bat_dau']) && isset($input['tiet_ket_thuc'])) {
            $tiet_bat_dau = (int)$input['tiet_bat_dau'];
            $tiet_ket_thuc = (int)$input['tiet_ket_thuc'];
            if ($tiet_bat_dau < 1 || $tiet_ket_thuc < 1 || $tiet_bat_dau > $tiet_ket_thuc) {
                jsonResponse(['success' => false, 'message' => 'Tiết học không hợp lệ'], 400);
            }
            $updates[] = "tiet_bat_dau = $tiet_bat_dau, tiet_ket_thuc = $tiet_ket_thuc";
        }

        if (isset($input['ma_gv'])) {
            $ma_gv = trim($input['ma_gv']);
            if (!empty($ma_gv) && !checkGiaoVienExists($conn, $ma_gv)) {
                jsonResponse(['success' => false, 'message' => 'Giáo viên không tồn tại'], 404);
            }
            $gv_sql = empty($ma_gv) ? "NULL" : "'$ma_gv'";
            $updates[] = "ma_gv = $gv_sql";
        }

        if (empty($updates)) {
            jsonResponse(['success' => false, 'message' => 'Không có dữ liệu cập nhật'], 400);
        }

        $sql = "UPDATE lop SET " . implode(', ', $updates) . " WHERE ma_lop = '$ma_lop' AND nien_khoa = '$nien_khoa'";
        
        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Cập nhật lớp học thành công']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi cập nhật lớp: ' . mysqli_error($conn)], 500);
        }
        break;

    case 'DELETE':
        // Xóa lớp học
        $ma_lop = $_GET['ma_lop'] ?? null;
        $nien_khoa = $_GET['nien_khoa'] ?? null;

        if (!$ma_lop || !$nien_khoa) {
            jsonResponse(['success' => false, 'message' => 'Thiếu mã lớp hoặc niên khóa'], 400);
        }

        // Kiểm tra xem lớp có sinh viên không
        $check_sinhvien = "SELECT COUNT(*) as count FROM sinhvien WHERE ma_lop = '$ma_lop'";
        $result = mysqli_query($conn, $check_sinhvien);
        $row = mysqli_fetch_assoc($result);
        
        if ($row['count'] > 0) {
            jsonResponse(['success' => false, 'message' => 'Không thể xóa! Lớp này đang có ' . $row['count'] . ' sinh viên'], 409);
        }

        // Xóa lớp
        $sql = "DELETE FROM lop WHERE ma_lop = '$ma_lop' AND nien_khoa = '$nien_khoa'";
        
        if (mysqli_query($conn, $sql)) {
            jsonResponse(['success' => true, 'message' => 'Xóa lớp học thành công']);
        } else {
            jsonResponse(['success' => false, 'message' => 'Lỗi khi xóa lớp: ' . mysqli_error($conn)], 500);
        }
        break;

    default:
        jsonResponse(['success' => false, 'message' => 'Phương thức không được hỗ trợ'], 405);
        break;
}
?>
