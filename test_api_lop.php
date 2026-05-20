<?php
/**
 * File kiểm tra API quản lý lớp học
 * Sử dụng: Mở http://localhost/qldiemsvien/test_api_lop.php để kiểm tra
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm Tra API Quản Lý Lớp Học</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        .form-group {
            margin-bottom: 12px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background: #764ba2;
        }
        .output {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            max-height: 400px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
        .warning {
            color: #ffc107;
        }
        .info {
            color: #17a2b8;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Kiểm Tra API Quản Lý Lớp Học</h1>
        
        <div class="row">
            <!-- GET - Lấy danh sách -->
            <div class="card">
                <h2>📋 1. Lấy Danh Sách Lớp</h2>
                <div class="form-group">
                    <label>Tìm kiếm (tùy chọn):</label>
                    <input type="text" id="getSearchTerm" placeholder="Tên hoặc mã lớp...">
                </div>
                <div class="form-group">
                    <label>Niên khóa (tùy chọn):</label>
                    <input type="text" id="getAcademicYear" placeholder="2023-2024">
                </div>
                <button onclick="getAllClasses()">Lấy Danh Sách</button>
                <div id="output1" class="output" style="margin-top: 10px;"></div>
            </div>

            <!-- GET - Lấy chi tiết -->
            <div class="card">
                <h2>🔍 2. Lấy Chi Tiết Lớp</h2>
                <div class="form-group">
                    <label>Mã lớp:</label>
                    <input type="text" id="getClassId" placeholder="10A1">
                </div>
                <div class="form-group">
                    <label>Niên khóa:</label>
                    <input type="text" id="getClassYear" placeholder="2023-2024">
                </div>
                <button onclick="getClassDetail()">Lấy Chi Tiết</button>
                <div id="output2" class="output" style="margin-top: 10px;"></div>
            </div>

            <!-- POST - Thêm lớp -->
            <div class="card">
                <h2>➕ 3. Thêm Lớp Mới</h2>
                <div class="form-group">
                    <label>Mã lớp:</label>
                    <input type="text" id="postClassId" placeholder="10B1">
                </div>
                <div class="form-group">
                    <label>Tên lớp:</label>
                    <input type="text" id="postClassName" placeholder="Lớp 10B1">
                </div>
                <div class="form-group">
                    <label>Niên khóa:</label>
                    <input type="text" id="postYear" placeholder="2023-2024">
                </div>
                <div class="form-group">
                    <label>Phòng học:</label>
                    <input type="text" id="postRoom" placeholder="P101">
                </div>
                <div class="form-group">
                    <label>Thứ (2-8):</label>
                    <select id="postDay">
                        <option value="">-- Chọn thứ --</option>
                        <option value="2">Thứ 2</option>
                        <option value="3">Thứ 3</option>
                        <option value="4">Thứ 4</option>
                        <option value="5">Thứ 5</option>
                        <option value="6">Thứ 6</option>
                        <option value="7">Thứ 7</option>
                        <option value="8">Chủ Nhật</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tiết bắt đầu:</label>
                    <input type="number" id="postStartPeriod" placeholder="1" min="1">
                </div>
                <div class="form-group">
                    <label>Tiết kết thúc:</label>
                    <input type="number" id="postEndPeriod" placeholder="3" min="1">
                </div>
                <div class="form-group">
                    <label>Mã giáo viên (tùy chọn):</label>
                    <input type="text" id="postTeacherId" placeholder="GV001">
                </div>
                <button onclick="addClass()">Thêm Lớp</button>
                <div id="output3" class="output" style="margin-top: 10px;"></div>
            </div>

            <!-- PUT - Cập nhật lớp -->
            <div class="card">
                <h2>✏️ 4. Cập Nhật Lớp</h2>
                <div class="form-group">
                    <label>Mã lớp:</label>
                    <input type="text" id="putClassId" placeholder="10A1">
                </div>
                <div class="form-group">
                    <label>Niên khóa:</label>
                    <input type="text" id="putYear" placeholder="2023-2024">
                </div>
                <div class="form-group">
                    <label>Tên lớp (mới):</label>
                    <input type="text" id="putClassName" placeholder="Lớp 10A1 - Chuyên toán">
                </div>
                <div class="form-group">
                    <label>Phòng học (mới):</label>
                    <input type="text" id="putRoom" placeholder="P102">
                </div>
                <div class="form-group">
                    <label>Mã giáo viên (mới):</label>
                    <input type="text" id="putTeacherId" placeholder="GV002">
                </div>
                <button onclick="updateClass()">Cập Nhật</button>
                <div id="output4" class="output" style="margin-top: 10px;"></div>
            </div>

            <!-- DELETE - Xóa lớp -->
            <div class="card">
                <h2>🗑️ 5. Xóa Lớp</h2>
                <div class="form-group">
                    <label>Mã lớp:</label>
                    <input type="text" id="deleteClassId" placeholder="10A1">
                </div>
                <div class="form-group">
                    <label>Niên khóa:</label>
                    <input type="text" id="deleteYear" placeholder="2023-2024">
                </div>
                <button onclick="deleteClass()">Xóa Lớp</button>
                <div id="output5" class="output" style="margin-top: 10px;"></div>
            </div>
        </div>

        <!-- Hướng dẫn sử dụng -->
        <div class="card full-width">
            <h2>📖 Hướng Dẫn Sử Dụng</h2>
            <div style="line-height: 1.8; color: #666;">
                <p><strong>1. Lấy Danh Sách Lớp:</strong> Nhập từ khóa tìm kiếm (tùy chọn) và niên khóa, nhấn "Lấy Danh Sách"</p>
                <p><strong>2. Lấy Chi Tiết Lớp:</strong> Nhập mã lớp và niên khóa, nhấn "Lấy Chi Tiết"</p>
                <p><strong>3. Thêm Lớp Mới:</strong> Điền đầy đủ thông tin (mã lớp, tên lớp, niên khóa là bắt buộc), nhấn "Thêm Lớp"</p>
                <p><strong>4. Cập Nhật Lớp:</strong> Nhập mã lớp, niên khóa, và các thông tin cần cập nhật, nhấn "Cập Nhật"</p>
                <p><strong>5. Xóa Lớp:</strong> Nhập mã lớp và niên khóa, nhấn "Xóa Lớp" (lớp không được có sinh viên)</p>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'api_lop.php';

        function logOutput(elementId, message, type = 'info') {
            const element = document.getElementById(elementId);
            const timestamp = new Date().toLocaleTimeString();
            const className = type === 'success' ? 'success' : type === 'error' ? 'error' : type === 'warning' ? 'warning' : 'info';
            element.innerHTML += `<div class="${className}">[${timestamp}] ${message}</div>`;
            element.scrollTop = element.scrollHeight;
        }

        function clearOutput(elementId) {
            document.getElementById(elementId).innerHTML = '';
        }

        // 1. Lấy danh sách
        function getAllClasses() {
            clearOutput('output1');
            logOutput('output1', 'Đang lấy danh sách...', 'info');

            let url = API_URL;
            const searchTerm = document.getElementById('getSearchTerm').value;
            const academicYear = document.getElementById('getAcademicYear').value;

            if (searchTerm) url += `?tim=${encodeURIComponent(searchTerm)}`;
            if (academicYear) url += (searchTerm ? '&' : '?') + `nien_khoa=${encodeURIComponent(academicYear)}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        logOutput('output1', `✓ Lấy danh sách thành công! (${data.data.length} lớp)`, 'success');
                        logOutput('output1', JSON.stringify(data.data, null, 2), 'success');
                    } else {
                        logOutput('output1', `✗ Lỗi: ${data.message}`, 'error');
                    }
                })
                .catch(error => logOutput('output1', `✗ Lỗi mạng: ${error}`, 'error'));
        }

        // 2. Lấy chi tiết
        function getClassDetail() {
            clearOutput('output2');
            const classId = document.getElementById('getClassId').value;
            const classYear = document.getElementById('getClassYear').value;

            if (!classId || !classYear) {
                logOutput('output2', '✗ Vui lòng nhập mã lớp và niên khóa', 'error');
                return;
            }

            logOutput('output2', 'Đang lấy chi tiết...', 'info');

            fetch(`${API_URL}?ma_lop=${encodeURIComponent(classId)}&nien_khoa=${encodeURIComponent(classYear)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        logOutput('output2', `✓ Lấy chi tiết thành công!`, 'success');
                        logOutput('output2', JSON.stringify(data.data, null, 2), 'success');
                    } else {
                        logOutput('output2', `✗ ${data.message}`, 'error');
                    }
                })
                .catch(error => logOutput('output2', `✗ Lỗi: ${error}`, 'error'));
        }

        // 3. Thêm lớp
        function addClass() {
            clearOutput('output3');
            const classId = document.getElementById('postClassId').value;
            const className = document.getElementById('postClassName').value;
            const year = document.getElementById('postYear').value;
            const room = document.getElementById('postRoom').value;
            const day = document.getElementById('postDay').value;
            const startPeriod = document.getElementById('postStartPeriod').value;
            const endPeriod = document.getElementById('postEndPeriod').value;
            const teacherId = document.getElementById('postTeacherId').value;

            if (!classId || !className || !year || !day || !startPeriod || !endPeriod) {
                logOutput('output3', '✗ Vui lòng điền đầy đủ thông tin bắt buộc', 'error');
                return;
            }

            logOutput('output3', 'Đang thêm lớp...', 'info');

            const data = {
                ma_lop: classId,
                ten_lop: className,
                nien_khoa: year,
                phong_hoc: room,
                thu: parseInt(day),
                tiet_bat_dau: parseInt(startPeriod),
                tiet_ket_thuc: parseInt(endPeriod),
                ma_gv: teacherId
            };

            fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        logOutput('output3', `✓ ${data.message}`, 'success');
                        logOutput('output3', JSON.stringify(data.data, null, 2), 'success');
                    } else {
                        logOutput('output3', `✗ ${data.message}`, 'error');
                    }
                })
                .catch(error => logOutput('output3', `✗ Lỗi: ${error}`, 'error'));
        }

        // 4. Cập nhật lớp
        function updateClass() {
            clearOutput('output4');
            const classId = document.getElementById('putClassId').value;
            const year = document.getElementById('putYear').value;
            const className = document.getElementById('putClassName').value;
            const room = document.getElementById('putRoom').value;
            const teacherId = document.getElementById('putTeacherId').value;

            if (!classId || !year) {
                logOutput('output4', '✗ Vui lòng nhập mã lớp và niên khóa', 'error');
                return;
            }

            logOutput('output4', 'Đang cập nhật...', 'info');

            const data = {};
            if (className) data.ten_lop = className;
            if (room) data.phong_hoc = room;
            if (teacherId) data.ma_gv = teacherId;

            if (Object.keys(data).length === 0) {
                logOutput('output4', '✗ Vui lòng điền ít nhất một trường cần cập nhật', 'warning');
                return;
            }

            fetch(`${API_URL}?ma_lop=${encodeURIComponent(classId)}&nien_khoa=${encodeURIComponent(year)}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        logOutput('output4', `✓ ${data.message}`, 'success');
                    } else {
                        logOutput('output4', `✗ ${data.message}`, 'error');
                    }
                })
                .catch(error => logOutput('output4', `✗ Lỗi: ${error}`, 'error'));
        }

        // 5. Xóa lớp
        function deleteClass() {
            clearOutput('output5');
            const classId = document.getElementById('deleteClassId').value;
            const year = document.getElementById('deleteYear').value;

            if (!classId || !year) {
                logOutput('output5', '✗ Vui lòng nhập mã lớp và niên khóa', 'error');
                return;
            }

            if (!confirm('Bạn chắc chắn muốn xóa lớp này? Không thể khôi phục!')) {
                return;
            }

            logOutput('output5', 'Đang xóa...', 'info');

            fetch(`${API_URL}?ma_lop=${encodeURIComponent(classId)}&nien_khoa=${encodeURIComponent(year)}`, {
                method: 'DELETE'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        logOutput('output5', `✓ ${data.message}`, 'success');
                    } else {
                        logOutput('output5', `✗ ${data.message}`, 'error');
                    }
                })
                .catch(error => logOutput('output5', `✗ Lỗi: ${error}`, 'error'));
        }
    </script>
</body>
</html>
