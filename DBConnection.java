package dangkyhocphan;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DBConnection {
 public static Connection getConnection() {
    Connection conn = null;
    try {
        // Thử cả 2 cách khai báo Driver cũ và mới
        try {
            Class.forName("com.mysql.cj.jdbc.Driver"); // Bản mới
        } catch (ClassNotFoundException e) {
            Class.forName("com.mysql.jdbc.Driver");    // Bản cũ
        }
        
        String url = "jdbc:mysql://localhost:3306/qlddh_vutiendung";
        String user = "root";
        String pass = ""; 
        
        conn = DriverManager.getConnection(url, user, pass);
    } catch (Exception e) {
        System.out.println("Lỗi kết nối chi tiết: " + e.getMessage());
    }
    return conn;
}

    static class getConnection {

        public getConnection() {
        }
    }
}