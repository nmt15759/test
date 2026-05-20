# API Quản Lý Lớp Học (api_lop.php)

## Mô tả
API này quản lý thông tin các lớp học trong hệ thống quản lý điểm sinh viên.

## URL Cơ bản
```
http://localhost/qldiemsvien/api_lop.php
```

## Các Endpoint

### 1. LẤY DANH SÁCH TẤT CẢ LỚP HỌC
**Method:** `GET`

**URL:**
```
api_lop.php
```

**Query Parameters (tùy chọn):**
- `tim`: Tìm kiếm theo tên hoặc mã lớp
- `nien_khoa`: Lọc theo niên khóa

**Ví dụ cURL:**
```bash
curl -X GET "http://localhost/qldiemsvien/api_lop.php"
curl -X GET "http://localhost/qldiemsvien/api_lop.php?tim=10A1&nien_khoa=2023-2024"
```

**Response thành công (200):**
```json
{
  "success": true,
  "data": [
    {
      "ma_lop": "10A1",
      "ten_lop": "Lớp 10A1",
      "nien_khoa": "2023-2024",
      "phong_hoc": "P101",
      "thu": 2,
      "tiet_bat_dau": 1,
      "tiet_ket_thuc": 3,
      "ma_gv": "GV001",
      "ten_gv": "Nguyễn Văn A"
    }
  ]
}
```

---

### 2. LẤY CHI TIẾT MỘT LỚP HỌC
**Method:** `GET`

**URL:**
```
api_lop.php?ma_lop=10A1&nien_khoa=2023-2024
```

**Query Parameters (bắt buộc):**
- `ma_lop`: Mã lớp
- `nien_khoa`: Niên khóa

**Ví dụ cURL:**
```bash
curl -X GET "http://localhost/qldiemsvien/api_lop.php?ma_lop=10A1&nien_khoa=2023-2024"
```

**Response thành công (200):**
```json
{
  "success": true,
  "data": {
    "ma_lop": "10A1",
    "ten_lop": "Lớp 10A1",
    "nien_khoa": "2023-2024",
    "phong_hoc": "P101",
    "thu": 2,
    "tiet_bat_dau": 1,
    "tiet_ket_thuc": 3,
    "ma_gv": "GV001",
    "ten_gv": "Nguyễn Văn A"
  }
}
```

**Response lỗi (404):**
```json
{
  "success": false,
  "message": "Không tìm thấy lớp"
}
```

---

### 3. THÊM LỚP HỌC MỚI
**Method:** `POST`

**URL:**
```
api_lop.php
```

**Headers:**
```
Content-Type: application/json
```

**Body (JSON):**
```json
{
  "ma_lop": "10A1",
  "ten_lop": "Lớp 10A1",
  "nien_khoa": "2023-2024",
  "phong_hoc": "P101",
  "thu": 2,
  "tiet_bat_dau": 1,
  "tiet_ket_thuc": 3,
  "ma_gv": "GV001"
}
```

**Giải thích các trường:**
- `ma_lop` (string, bắt buộc): Mã lớp duy nhất
- `ten_lop` (string, bắt buộc): Tên lớp
- `nien_khoa` (string, bắt buộc): Niên khóa (ví dụ: "2023-2024")
- `phong_hoc` (string, không bắt buộc): Phòng học
- `thu` (integer, bắt buộc): Ngày học (2-8, trong đó 2=Thứ 2, ..., 8=Chủ Nhật)
- `tiet_bat_dau` (integer, bắt buộc): Tiết bắt đầu
- `tiet_ket_thuc` (integer, bắt buộc): Tiết kết thúc
- `ma_gv` (string, không bắt buộc): Mã giáo viên

**Ví dụ cURL:**
```bash
curl -X POST "http://localhost/qldiemsvien/api_lop.php" \
  -H "Content-Type: application/json" \
  -d '{
    "ma_lop": "10A1",
    "ten_lop": "Lớp 10A1",
    "nien_khoa": "2023-2024",
    "phong_hoc": "P101",
    "thu": 2,
    "tiet_bat_dau": 1,
    "tiet_ket_thuc": 3,
    "ma_gv": "GV001"
  }'
```

**Response thành công (200):**
```json
{
  "success": true,
  "message": "Thêm lớp học thành công",
  "data": {
    "ma_lop": "10A1",
    "nien_khoa": "2023-2024"
  }
}
```

**Response lỗi trùng lặp (409):**
```json
{
  "success": false,
  "message": "Mã lớp đã tồn tại trong niên khóa này"
}
```

---

### 4. CẬP NHẬT THÔNG TIN LỚP HỌC
**Method:** `PUT`

**URL:**
```
api_lop.php?ma_lop=10A1&nien_khoa=2023-2024
```

**Headers:**
```
Content-Type: application/json
```

**Body (JSON) - Chỉ cần các trường cần cập nhật:**
```json
{
  "ten_lop": "Lớp 10A1 - Nâng cao",
  "phong_hoc": "P102",
  "thu": 3,
  "tiet_bat_dau": 2,
  "tiet_ket_thuc": 4,
  "ma_gv": "GV002"
}
```

**Query Parameters (bắt buộc):**
- `ma_lop`: Mã lớp
- `nien_khoa`: Niên khóa

**Ví dụ cURL:**
```bash
curl -X PUT "http://localhost/qldiemsvien/api_lop.php?ma_lop=10A1&nien_khoa=2023-2024" \
  -H "Content-Type: application/json" \
  -d '{
    "ten_lop": "Lớp 10A1 - Nâng cao",
    "ma_gv": "GV002"
  }'
```

**Response thành công (200):**
```json
{
  "success": true,
  "message": "Cập nhật lớp học thành công"
}
```

**Response lỗi không tìm thấy (404):**
```json
{
  "success": false,
  "message": "Lớp không tồn tại"
}
```

---

### 5. XÓA LỚP HỌC
**Method:** `DELETE`

**URL:**
```
api_lop.php?ma_lop=10A1&nien_khoa=2023-2024
```

**Query Parameters (bắt buộc):**
- `ma_lop`: Mã lớp
- `nien_khoa`: Niên khóa

**Ví dụ cURL:**
```bash
curl -X DELETE "http://localhost/qldiemsvien/api_lop.php?ma_lop=10A1&nien_khoa=2023-2024"
```

**Response thành công (200):**
```json
{
  "success": true,
  "message": "Xóa lớp học thành công"
}
```

**Response lỗi - Lớp có sinh viên (409):**
```json
{
  "success": false,
  "message": "Không thể xóa! Lớp này đang có 25 sinh viên"
}
```

**Response lỗi - Lớp không tồn tại (404):**
```json
{
  "success": false,
  "message": "Lớp không tồn tại"
}
```

---

## Mã Lỗi HTTP

| Mã | Ý Nghĩa |
|---|---|
| 200 | Thành công |
| 400 | Yêu cầu không hợp lệ (thiếu dữ liệu, dữ liệu sai định dạng) |
| 404 | Không tìm thấy tài nguyên |
| 405 | Phương thức HTTP không được hỗ trợ |
| 409 | Xung đột (dữ liệu trùng lặp) |
| 500 | Lỗi máy chủ |

---

## Lưu Ý Quan Trọng

1. **Mã lớp và niên khóa tạo ra khóa chính kết hợp** - Một lớp được xác định duy nhất bởi sự kết hợp của mã lớp và niên khóa.

2. **Giáo viên tùy chọn** - Một lớp có thể không có giáo viên được gán (ma_gv = NULL).

3. **Xóa lớp có sinh viên** - API sẽ từ chối xóa lớp nếu lớp đó còn có sinh viên đang học.

4. **Giá trị thứ (thu)**:
   - 2 = Thứ 2
   - 3 = Thứ 3
   - 4 = Thứ 4
   - 5 = Thứ 5
   - 6 = Thứ 6
   - 7 = Thứ 7
   - 8 = Chủ Nhật

5. **An toàn SQL** - API hiện tại sử dụng dạng câu lệnh SQL thuần. Để bảo mật cao hơn, nên sử dụng prepared statements.

6. **Phép toàn CORS** - API cho phép các request từ tất cả origin (Access-Control-Allow-Origin: *). Nên cấu hình lại trong môi trường production.

---

## Ví dụ JavaScript (Fetch API)

### Lấy danh sách lớp
```javascript
fetch('api_lop.php')
  .then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error('Lỗi:', error));
```

### Thêm lớp mới
```javascript
const newClass = {
  ma_lop: "11A1",
  ten_lop: "Lớp 11A1",
  nien_khoa: "2024-2025",
  phong_hoc: "P201",
  thu: 2,
  tiet_bat_dau: 1,
  tiet_ket_thuc: 3,
  ma_gv: "GV001"
};

fetch('api_lop.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(newClass)
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Lỗi:', error));
```

### Cập nhật lớp
```javascript
const updateData = {
  ten_lop: "Lớp 10A1 - Chuyên toán",
  ma_gv: "GV003"
};

fetch('api_lop.php?ma_lop=10A1&nien_khoa=2023-2024', {
  method: 'PUT',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(updateData)
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Lỗi:', error));
```

### Xóa lớp
```javascript
fetch('api_lop.php?ma_lop=10A1&nien_khoa=2023-2024', {
  method: 'DELETE'
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Lỗi:', error));
```
