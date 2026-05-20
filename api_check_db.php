<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include_once 'db_ketnoi.php';

// Hàm trả về JSON response
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    jsonResponse(['success' => false, 'message' => 'Chỉ hỗ trợ phương thức GET'], 405);
}

// Kiểm tra kết nối database
if ($conn) {
    // Thử query đơn giản
    $result = mysqli_query($conn, "SELECT 1");
    if ($result) {
        jsonResponse(['success' => true, 'message' => 'Kết nối database thành công']);
    } else {
        jsonResponse(['success' => false, 'message' => 'Kết nối database thất bại: ' . mysqli_error($conn)], 500);
    }
} else {
    jsonResponse(['success' => false, 'message' => 'Không thể kết nối database'], 500);
}
?>