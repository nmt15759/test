package dangkyhocphan;


import java.awt.CardLayout;
import java.awt.Component;


public class MainFrame extends javax.swing.JFrame {

   
   public MainFrame() {
    initComponents();
    this.setTitle("Sinh viên");
     this.setLocationRelativeTo(null);
}


    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        pnlContent = new javax.swing.JPanel();
        jMenuBar1 = new javax.swing.JMenuBar();
        menuDangKyHoc = new javax.swing.JMenu();
        menuDangKy = new javax.swing.JMenu();
        itemDangKyHP = new javax.swing.JMenuItem();
        menuTraCuu = new javax.swing.JMenu();
        itemKetQua = new javax.swing.JMenuItem();
        menuThiLai = new javax.swing.JMenu();
        itemThiLai = new javax.swing.JMenuItem();
        jMenu2 = new javax.swing.JMenu();
        jMenu3 = new javax.swing.JMenu();
        jMenu4 = new javax.swing.JMenu();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);
        setPreferredSize(new java.awt.Dimension(900, 600));
        setResizable(false);

        pnlContent.setLayout(new java.awt.CardLayout());

        menuDangKyHoc.setText("Đăng ký học");

        menuDangKy.setText("Đăng ký");

        itemDangKyHP.setText("Đăng ký học phần");
        itemDangKyHP.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                itemDangKyHPActionPerformed(evt);
            }
        });
        menuDangKy.add(itemDangKyHP);

        menuDangKyHoc.add(menuDangKy);

        menuTraCuu.setText("Tra cứu");
        menuTraCuu.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                menuTraCuuActionPerformed(evt);
            }
        });

        itemKetQua.setText("Kết quả đăng ký");
        itemKetQua.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                itemKetQuaActionPerformed(evt);
            }
        });
        menuTraCuu.add(itemKetQua);

        menuDangKyHoc.add(menuTraCuu);

        menuThiLai.setText("Thi lại");

        itemThiLai.setText("Đăng ký thi lại");
        itemThiLai.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                itemThiLaiActionPerformed(evt);
            }
        });
        menuThiLai.add(itemThiLai);

        menuDangKyHoc.add(menuThiLai);

        jMenuBar1.add(menuDangKyHoc);

        jMenu2.setText("Thời khóa biểu");

        jMenu3.setText("Lịch học");
        jMenu3.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jMenu3MouseClicked(evt);
            }
        });
        jMenu2.add(jMenu3);

        jMenu4.setText("Lịch thi");
        jMenu4.addMouseListener(new java.awt.event.MouseAdapter() {
            public void mouseClicked(java.awt.event.MouseEvent evt) {
                jMenu4MouseClicked(evt);
            }
        });
        jMenu2.add(jMenu4);

        jMenuBar1.add(jMenu2);

        setJMenuBar(jMenuBar1);

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(246, 246, 246)
                .addComponent(pnlContent, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(402, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(86, 86, 86)
                .addComponent(pnlContent, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(294, Short.MAX_VALUE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void itemDangKyHPActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_itemDangKyHPActionPerformed
       new DangKyFrame().setVisible(true);
       this.dispose();
    }//GEN-LAST:event_itemDangKyHPActionPerformed

    private void menuTraCuuActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_menuTraCuuActionPerformed

    }//GEN-LAST:event_menuTraCuuActionPerformed

    private void itemThiLaiActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_itemThiLaiActionPerformed
     new ThiLaiFrame().setVisible(true);
     this.dispose();
    }//GEN-LAST:event_itemThiLaiActionPerformed

    private void itemKetQuaActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_itemKetQuaActionPerformed
       new KetQuaFrame().setVisible(true);
       this.dispose();

    }//GEN-LAST:event_itemKetQuaActionPerformed

    private void jMenu3MouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jMenu3MouseClicked
         new LichHocFrame().setVisible(true);
    this.dispose();
    }//GEN-LAST:event_jMenu3MouseClicked

    private void jMenu4MouseClicked(java.awt.event.MouseEvent evt) {//GEN-FIRST:event_jMenu4MouseClicked
         new LichThiFrame().setVisible(true);
    this.dispose();
    }//GEN-LAST:event_jMenu4MouseClicked

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(MainFrame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(MainFrame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(MainFrame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(MainFrame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new MainFrame().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JMenuItem itemDangKyHP;
    private javax.swing.JMenuItem itemKetQua;
    private javax.swing.JMenuItem itemThiLai;
    private javax.swing.JMenu jMenu2;
    private javax.swing.JMenu jMenu3;
    private javax.swing.JMenu jMenu4;
    private javax.swing.JMenuBar jMenuBar1;
    private javax.swing.JMenu menuDangKy;
    private javax.swing.JMenu menuDangKyHoc;
    private javax.swing.JMenu menuThiLai;
    private javax.swing.JMenu menuTraCuu;
    private javax.swing.JPanel pnlContent;
    // End of variables declaration//GEN-END:variables
}
