<?php
namespace App\Helpers;

class EmailHelper {
    /**
     * Gửi email xác thực
     * 
     * @param string $email Email người nhận
     * @param string $username Tên người dùng
     * @param string $token Token xác thực
     * @return bool Kết quả gửi email
     */
    public static function sendVerificationEmail($email, $username, $token) {
        $subject = "Xác thực tài khoản - Di Travel";
        
        $verificationUrl = PUBLIC_URL . "/verify-email?token=" . $token;
        
        $message = "
        <html>
        <head>
            <title>Xác thực tài khoản</title>
        </head>
        <body>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='" . PUBLIC_URL . "/assets/images/logo.png' alt='Di Travel Logo' style='max-width: 150px;'>
                </div>
                
                <div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                    <h2 style='color: #333; margin-top: 0;'>Xác thực tài khoản</h2>
                    
                    <p>Xin chào $username,</p>
                    
                    <p>Cảm ơn bạn đã đăng ký tài khoản tại Di Travel. Để hoàn tất quá trình đăng ký, vui lòng xác thực email của bạn bằng cách nhấp vào nút bên dưới:</p>
                    
                    <p style='text-align: center;'>
                        <a href='$verificationUrl' style='display: inline-block; background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Xác thực tài khoản</a>
                    </p>
                    
                    <p>Hoặc bạn có thể sao chép và dán liên kết sau vào trình duyệt của mình:</p>
                    
                    <p style='background-color: #e9ecef; padding: 10px; border-radius: 3px;'>$verificationUrl</p>
                    
                    <p>Liên kết này sẽ hết hạn sau 24 giờ.</p>
                    
                    <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
                </div>
                
                <div style='margin-top: 20px; text-align: center; color: #6c757d; font-size: 12px;'>
                    <p>© " . date('Y') . " Di Travel. Tất cả các quyền được bảo lưu.</p>
                    <p>Địa chỉ: 123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh, Việt Nam</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return self::sendEmail($email, $subject, $message);
    }
    
    /**
     * Gửi email đặt lại mật khẩu
     * 
     * @param string $email Email người nhận
     * @param string $username Tên người dùng
     * @param string $token Token đặt lại mật khẩu
     * @return bool Kết quả gửi email
     */
    public static function sendPasswordResetEmail($email, $username, $token) {
        $subject = "Đặt lại mật khẩu - Di Travel";
        
        $resetUrl = PUBLIC_URL . "/reset-password?token=" . $token;
        
        $message = "
        <html>
        <head>
            <title>Đặt lại mật khẩu</title>
        </head>
        <body>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='" . PUBLIC_URL . "/assets/images/logo.png' alt='Di Travel Logo' style='max-width: 150px;'>
                </div>
                
                <div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                    <h2 style='color: #333; margin-top: 0;'>Đặt lại mật khẩu</h2>
                    
                    <p>Xin chào $username,</p>
                    
                    <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Để đặt lại mật khẩu, vui lòng nhấp vào nút bên dưới:</p>
                    
                    <p style='text-align: center;'>
                        <a href='$resetUrl' style='display: inline-block; background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Đặt lại mật khẩu</a>
                    </p>
                    
                    <p>Hoặc bạn có thể sao chép và dán liên kết sau vào trình duyệt của mình:</p>
                    
                    <p style='background-color: #e9ecef; padding: 10px; border-radius: 3px;'>$resetUrl</p>
                    
                    <p>Liên kết này sẽ hết hạn sau 1 giờ.</p>
                    
                    <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này và mật khẩu của bạn sẽ không bị thay đổi.</p>
                </div>
                
                <div style='margin-top: 20px; text-align: center; color: #6c757d; font-size: 12px;'>
                    <p>© " . date('Y') . " Di Travel. Tất cả các quyền được bảo lưu.</p>
                    <p>Địa chỉ: 123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh, Việt Nam</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        return self::sendEmail($email, $subject, $message);
    }
    
    /**
     * Gửi email
     * 
     * @param string $to Email người nhận
     * @param string $subject Tiêu đề
     * @param string $message Nội dung
     * @return bool Kết quả gửi email
     */
    private static function sendEmail($to, $subject, $message) {
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            'From: Di Travel <no-reply@ditravel.com>',
            'Reply-To: support@ditravel.com',
            'X-Mailer: PHP/' . phpversion()
        ];
        
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
}