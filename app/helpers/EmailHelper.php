<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper
{
    // SMTP configuration
    private static $smtpHost = 'smtp.resend.com';
    private static $smtpPort = 587;
    private static $smtpUsername = 'resend';
    private static $smtpPassword = 're_CDGLoX4X_AGeFRyviihehvQSzXqMoq8Cr'; // Your Resend API key
    private static $fromEmail = 'no-reply@binh-dev.io.vn';
    private static $fromName = 'Di Travel';

    /**
     * Gửi email xác thực
     * 
     * @param string $email Email người nhận
     * @param string $username Tên người dùng
     * @param string $token Token xác thực
     * @return array Kết quả gửi email
     */
    public static function sendVerificationEmail($email, $username, $token)
    {
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
     * Gửi email phản hồi liên hệ với thiết kế chuyên nghiệp
     * 
     * @param string $to Email người nhận
     * @param string $name Tên người nhận
     * @param string $subject Tiêu đề
     * @param string $messageContent Nội dung
     * @return array Kết quả gửi email
     */
    public static function sendContactReply($to, $name, $subject, $messageContent)
    {
        $currentYear = date('Y');
        $message = "
            <!DOCTYPE html>
            <html>
            <head>
                <title>{$subject}</title>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
            </head>
            <body style=\"font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333333; background-color: #f5f5f5; margin: 0; padding: 0;\">
                <!-- Main Container -->
                <div style=\"max-width: 650px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 20px; margin-bottom: 20px;\">
                    
                    <!-- Header with Gradient -->
                    // <div style=\"background: linear-gradient(135deg, #06beb6 0%, #48b1bf 100%); padding: 30px 20px; text-align: center;\">
                    //     <img src=\"https://res.cloudinary.com/dr1naxx72/image/upload/v1743134201/logo_rbocpz.png\" alt=\"Di Travel Logo\" style=\"max-width: 180px; height: auto;\">
                    // </div>

                    <div style=\"display: inline-block; background-color: white; padding: 7px 18px; border-radius: 40px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);\">
                        <img src=\"https://res.cloudinary.com/dr1naxx72/image/upload/v1743134201/logo_rbocpz.png\" alt=\"Di Travel Logo\"
                            style=\"max-width: 150px; height: auto; vertical-align: middle;\">
                    </div>
                    
                    <!-- Content Section -->
                    <div style=\"padding: 30px 40px;\">
                        <!-- Greeting -->
                        <div style=\"border-bottom: 1px solid #eaeaea; padding-bottom: 20px; margin-bottom: 20px;\">
                            <h1 style=\"color: #06beb6; font-size: 24px; font-weight: 600; margin-top: 0; margin-bottom: 15px;\">{$subject}</h1>
                            <p style=\"font-size: 16px; margin-bottom: 0; color: #555555;\">Xin chào <strong>{$name}</strong>,</p>
                        </div>
                        
                        <!-- Message Content -->
                        <div style=\"background-color: #f9f9f9; border-left: 4px solid #06beb6; padding: 20px; margin: 25px 0; border-radius: 4px;\">
                            " . nl2br(htmlspecialchars($messageContent)) . "
                        </div>
                        
                        <!-- Signature -->
                        <div style=\"margin-top: 30px;\">
                            <p style=\"margin-bottom: 5px;\">Trân trọng,</p>
                            <p style=\"margin-top: 0; font-weight: 600; color: #06beb6;\">Đội ngũ Di Travel</p>
                        </div>
                        
                        <!-- Call to Action -->
                        <div style=\"text-align: center; margin-top: 35px;\">
                            <p style=\"font-size: 14px; color: #777777; margin-bottom: 15px;\">Nếu bạn có thêm câu hỏi hoặc cần hỗ trợ:</p>
                            <a href=\"https://ditravel.com/contact\" style=\"display: inline-block; background-color: #06beb6; color: white; text-decoration: none; padding: 10px 25px; border-radius: 4px; font-weight: 500; letter-spacing: 0.5px;\">Liên Hệ Hỗ Trợ</a>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div style=\"background-color: #333333; color: #ffffff; padding: 25px 40px; text-align: center;\">
                        <div style=\"margin-bottom: 20px;\">
                            <!-- Social Media Icons -->
                            <a href=\"#\" style=\"display: inline-block; margin: 0 10px;\">
                                <img src=\"https://cdn-icons-png.flaticon.com/128/1384/1384053.png\" alt=\"Facebook\" width=\"24\" height=\"24\">
                            </a>
                            <a href=\"#\" style=\"display: inline-block; margin: 0 10px;\">
                                <img src=\"https://cdn-icons-png.flaticon.com/128/3670/3670151.png\" alt=\"Instagram\" width=\"24\" height=\"24\">
                            </a>
                            <a href=\"#\" style=\"display: inline-block; margin: 0 10px;\">
                                <img src=\"https://cdn-icons-png.flaticon.com/128/733/733579.png\" alt=\"Twitter\" width=\"24\" height=\"24\">
                            </a>
                        </div>
                        
                        <p style=\"font-size: 13px; color: #aaaaaa; margin-bottom: 5px;\">© {$currentYear} Di Travel. Tất cả các quyền được bảo lưu.</p>
                        <p style=\"font-size: 13px; color: #aaaaaa; margin-top: 0;\">Địa chỉ: 123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh, Việt Nam</p>
                        
                        <div style=\"margin-top: 15px; font-size: 12px;\">
                            <a href=\"#\" style=\"color: #06beb6; text-decoration: none; margin: 0 10px;\">Chính sách bảo mật</a>
                            <a href=\"#\" style=\"color: #06beb6; text-decoration: none; margin: 0 10px;\">Điều khoản sử dụng</a>
                            <a href=\"#\" style=\"color: #06beb6; text-decoration: none; margin: 0 10px;\">Hủy đăng ký</a>
                        </div>
                    </div>
                </div>
            </body>
            </html>
        ";

        return self::sendEmail($to, $subject, $message);
    }

    /**
     * Phương thức gửi email sử dụng SMTP thông qua PHPMailer
     * 
     * @param string $to Email người nhận
     * @param string $subject Tiêu đề
     * @param string $message Nội dung
     * @return array Kết quả với thông tin thành công hoặc lỗi
     */
    public static function sendEmail($to, $subject, $message)
    {
        try {
            // Kiểm tra email hợp lệ
            if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
                error_log("Địa chỉ email không hợp lệ: $to");
                return [
                    'success' => false,
                    'error' => 'Địa chỉ email không hợp lệ'
                ];
            }

            // Kiểm tra tiêu đề và nội dung
            if (empty($subject) || empty($message)) {
                error_log("Tiêu đề hoặc nội dung email trống");
                return [
                    'success' => false,
                    'error' => 'Tiêu đề hoặc nội dung email không được để trống'
                ];
            }

            // Khởi tạo PHPMailer
            $mail = new PHPMailer(true);

            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = self::$smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = self::$smtpUsername;
            $mail->Password = self::$smtpPassword;
            $mail->SMTPSecure = 'tls';
            $mail->Port = self::$smtpPort;
            $mail->CharSet = 'UTF-8';

            // Cấu hình debug cho môi trường phát triển
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                $mail->SMTPDebug = 2; // Chế độ debug chi tiết
                $mail->Debugoutput = function ($str, $level) {
                    error_log("PHPMailer [$level]: $str");
                };
            }

            // Thiết lập email
            $mail->setFrom(self::$fromEmail, self::$fromName);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Gửi email
            $mail->send();

            // Log thông tin thành công trong môi trường phát triển
            if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
                error_log("Email sent successfully to: $to");
            }

            // Trả về kết quả thành công
            return [
                'success' => true,
                'message' => 'Email sent successfully'
            ];
        } catch (Exception $e) {
            $errorMessage = $mail->ErrorInfo ?? $e->getMessage();
            error_log("PHPMailer error: " . $errorMessage);

            return [
                'success' => false,
                'error' => 'Không thể gửi email',
                'debug' => $errorMessage
            ];
        }
    }
    public static function sendPasswordResetEmail($email, $username, $token)
    {
        $subject = "Đặt lại mật khẩu - Di Travel";

        $resetUrl = UrlHelper::route('/auth/reset-password/' . $token);
        // echo $resetUrl; die();
        $message = "
            <html>
            <head>
                <title>Đặt lại mật khẩu</title>         
            </head>
            <body>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;'>
                    <div style=\"background: linear-gradient(135deg, #06beb6 0%, #48b1bf 100%); padding: 30px 20px; text-align: center;\">
                        <img src=\"https://res.cloudinary.com/dr1naxx72/image/upload/v1743134201/logo_rbocpz.png\" alt=\"Di Travel Logo\" style=\"max-width: 180px; height: auto;\">
                    </div>
                    
                    <div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                        <h2 style='color: #333; margin-top: 0;'>Đặt lại mật khẩu</h2>
                        
                        <p>Xin chào $username,</p>
                        
                        <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Để đặt lại mật khẩu, vui lòng nhấp vào nút bên dưới:</p>
                        
                        <p style='text-align: center;'>
                            <a href='http://localhost$resetUrl' style='display: inline-block; background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Đặt lại mật khẩu</a>
                        </p>
                        
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
}
