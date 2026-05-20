<?php
include_once 'db_ketnoi.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // ===== GET =====
    case 'GET':
        $tukhoa = $_GET['tukhoa'] ?? '';
        $sql = "SELECT * FROM sinhvien 
                WHERE ma_sv LIKE '%$tukhoa%' 
                OR ho_ten LIKE '%$tukhoa%' 
                ORDER BY ma_lop, ma_sv";

        $result = mysqli_query($conn, $sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        echo json_encode($data);
        break;

    // ===== POST (THÊM) =====
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        $sql = "INSERT INTO sinhvien VALUES (
            '{$input['ma_sv']}',
            '{$input['ho_ten']}',
            '{$input['ngay_sinh']}',
            '{$input['gioi_tinh']}',
            '{$input['que_quan']}',
            '{$input['ma_lop']}'
        )";

        mysqli_query($conn, $sql);
        echo json_encode(["message" => "Thêm thành công"]);
        break;

    // ===== PUT (SỬA) =====
    case 'PUT':
        $input = json_decode(file_get_contents("php://input"), true);

        $sql = "UPDATE sinhvien SET 
            ho_ten='{$input['ho_ten']}',
            ngay_sinh='{$input['ngay_sinh']}',
            gioi_tinh='{$input['gioi_tinh']}',
            que_quan='{$input['que_quan']}',
            ma_lop='{$input['ma_lop']}'
            WHERE ma_sv='{$input['ma_sv']}'";

        mysqli_query($conn, $sql);
        echo json_encode(["message" => "Cập nhật thành công"]);
        break;

    // ===== DELETE =====
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $input);

        $sql = "DELETE FROM sinhvien WHERE ma_sv='{$input['ma_sv']}'";

        mysqli_query($conn, $sql);
        echo json_encode(["message" => "Xóa thành công"]);
        break;
}