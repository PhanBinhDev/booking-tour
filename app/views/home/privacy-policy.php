<?php
// privacy-policy.php
use App\Helpers\UrlHelper;
?>

<div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
    <div class="text-center mb-12">
      <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
        Chính sách bảo mật
      </h1>
      <p class="mt-4 text-lg text-gray-600">
        Cập nhật lần cuối: <?= date('d/m/Y', strtotime('-30 days')) ?>
      </p>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="p-6 sm:p-8">
        <div class="prose prose-teal max-w-none">
          <h2>1. Giới thiệu</h2>
          <p>
            Ditravel ("chúng tôi", "của chúng tôi") cam kết bảo vệ quyền riêng tư của bạn. Chính sách bảo mật này giải
            thích cách chúng tôi thu thập, sử dụng, tiết lộ, lưu trữ và bảo vệ thông tin cá nhân của bạn.
          </p>
          <p>
            Bằng việc sử dụng dịch vụ của chúng tôi, bạn đồng ý với việc thu thập và sử dụng thông tin theo chính sách
            này. Chúng tôi sẽ không sử dụng hoặc chia sẻ thông tin của bạn với bất kỳ ai ngoại trừ như được mô tả trong
            Chính sách Bảo mật này.
          </p>

          <h2>2. Thông tin chúng tôi thu thập</h2>
          <p>Chúng tôi có thể thu thập các loại thông tin sau:</p>
          <ul>
            <li><strong>Thông tin cá nhân:</strong> Họ tên, địa chỉ email, số điện thoại, địa chỉ, ngày sinh, giới tính.
            </li>
            <li><strong>Thông tin thanh toán:</strong> Thông tin thẻ tín dụng/ghi nợ, thông tin tài khoản ngân hàng.
            </li>
            <li><strong>Thông tin hộ chiếu/CMND:</strong> Số hộ chiếu/CMND, ngày cấp, nơi cấp (đối với các tour quốc
              tế).</li>
            <li><strong>Thông tin đặt tour:</strong> Lịch trình, số lượng người, yêu cầu đặc biệt.</li>
            <li><strong>Thông tin thiết bị:</strong> Địa chỉ IP, loại trình duyệt, thiết bị, thời gian truy cập.</li>
            <li><strong>Cookie và công nghệ theo dõi:</strong> Chúng tôi sử dụng cookie và các công nghệ tương tự để cải
              thiện trải nghiệm của bạn.</li>
          </ul>

          <h2>3. Cách chúng tôi sử dụng thông tin</h2>
          <p>Chúng tôi sử dụng thông tin thu thập được để:</p>
          <ul>
            <li>Xử lý và xác nhận đặt tour của bạn</li>
            <li>Cung cấp dịch vụ khách hàng và hỗ trợ</li>
            <li>Gửi thông tin cập nhật về đặt tour và thay đổi lịch trình</li>
            <li>Gửi thông tin về khuyến mãi và ưu đãi (nếu bạn đăng ký)</li>
            <li>Cải thiện dịch vụ và trải nghiệm người dùng</li>
            <li>Phân tích xu hướng và hành vi người dùng</li>
            <li>Ngăn chặn gian lận và bảo mật tài khoản</li>
          </ul>

          <h2>4. Chia sẻ thông tin</h2>
          <p>Chúng tôi có thể chia sẻ thông tin của bạn với:</p>
          <ul>
            <li><strong>Đối tác cung cấp dịch vụ:</strong> Khách sạn, hãng hàng không, công ty vận chuyển, nhà cung cấp
              dịch vụ tour để thực hiện dịch vụ bạn đã đặt.</li>
            <li><strong>Nhà cung cấp dịch vụ thanh toán:</strong> Để xử lý thanh toán của bạn.</li>
            <li><strong>Đối tác tiếp thị:</strong> Chúng tôi có thể chia sẻ thông tin với đối tác tiếp thị để cung cấp
              ưu đãi phù hợp (chỉ khi bạn đồng ý).</li>
            <li><strong>Cơ quan pháp luật:</strong> Khi có yêu cầu hợp pháp từ cơ quan chức năng.</li>
          </ul>
          <p>Chúng tôi không bán thông tin cá nhân của bạn cho bên thứ ba.</p>

          <h2>5. Bảo mật thông tin</h2>
          <p>
            Chúng tôi thực hiện các biện pháp bảo mật hợp lý để bảo vệ thông tin cá nhân của bạn khỏi mất mát, truy cập
            trái phép, tiết lộ, thay đổi hoặc phá hủy. Các biện pháp này bao gồm:
          </p>
          <ul>
            <li>Mã hóa dữ liệu nhạy cảm</li>
            <li>Hạn chế quyền truy cập vào thông tin cá nhân</li>
            <li>Sử dụng kết nối bảo mật SSL</li>
            <li>Thường xuyên cập nhật các biện pháp bảo mật</li>
          </ul>

          <h2>6. Quyền của bạn</h2>
          <p>Bạn có các quyền sau đối với thông tin cá nhân của mình:</p>
          <ul>
            <li>Quyền truy cập và nhận bản sao thông tin của bạn</li>
            <li>Quyền yêu cầu chỉnh sửa thông tin không chính xác</li>
            <li>Quyền yêu cầu xóa thông tin (trong một số trường hợp)</li>
            <li>Quyền hạn chế hoặc phản đối việc xử lý thông tin</li>
            <li>Quyền rút lại sự đồng ý</li>
          </ul>
          <p>Để thực hiện các quyền này, vui lòng liên hệ với chúng tôi theo thông tin ở mục "Liên hệ" bên dưới.</p>

          <h2>7. Lưu trữ dữ liệu</h2>
          <p>
            Chúng tôi lưu trữ thông tin cá nhân của bạn trong thời gian cần thiết để thực hiện các mục đích được nêu
            trong Chính sách Bảo mật này, trừ khi pháp luật yêu cầu hoặc cho phép thời gian lưu trữ lâu hơn.
          </p>

          <h2>8. Thay đổi chính sách bảo mật</h2>
          <p>
            Chúng tôi có thể cập nhật Chính sách Bảo mật này theo thời gian. Chúng tôi sẽ thông báo cho bạn về bất kỳ
            thay đổi nào bằng cách đăng chính sách mới trên trang web của chúng tôi và cập nhật ngày "Cập nhật lần cuối"
            ở đầu trang.
          </p>

          <h2>9. Liên hệ</h2>
          <p>
            Nếu bạn có bất kỳ câu hỏi nào về Chính sách Bảo mật này, vui lòng liên hệ với chúng tôi:
          </p>
          <ul>
            <li>Email: privacy@ditravel.com</li>
            <li>Điện thoại: 1900 1234</li>
            <li>Địa chỉ: 123 Đường Du Lịch, Quận 1, TP. Hồ Chí Minh</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>