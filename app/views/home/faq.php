<?php
// faq.php
use App\Helpers\UrlHelper;
?>

<div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
    <div class="text-center mb-12">
      <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
        Câu hỏi thường gặp
      </h1>
      <p class="mt-4 text-lg text-gray-600">
        Giải đáp những thắc mắc phổ biến nhất của khách hàng về dịch vụ của Ditravel
      </p>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="divide-y divide-gray-200">
        <!-- FAQ Item 1 -->
        <div class="p-6">
          <h3 class="text-lg font-medium text-teal-600">
            Làm thế nào để đặt tour trên Ditravel?
          </h3>
          <div class="mt-2 text-gray-700">
            <p>Để đặt tour trên Ditravel, bạn có thể thực hiện theo các bước sau:</p>
            <ol class="list-decimal pl-5 mt-2 space-y-1">
              <li>Truy cập trang web Ditravel và tìm kiếm tour phù hợp</li>
              <li>Chọn tour bạn muốn đặt và nhấp vào nút "Đặt ngay"</li>
              <li>Điền thông tin cá nhân và thông tin liên hệ</li>
              <li>Chọn phương thức thanh toán và hoàn tất đặt tour</li>
              <li>Kiểm tra email xác nhận đặt tour</li>
            </ol>
          </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="p-6">
          <h3 class="text-lg font-medium text-teal-600">
            Chính sách hủy tour của Ditravel như thế nào?
          </h3>
          <div class="mt-2 text-gray-700">
            <p>Chính sách hủy tour của chúng tôi như sau:</p>
            <ul class="list-disc pl-5 mt-2 space-y-1">
              <li>Hủy trước 30 ngày: Hoàn tiền 100% (trừ phí đặt cọc)</li>
              <li>Hủy từ 15-29 ngày: Hoàn tiền 70%</li>
              <li>Hủy từ 7-14 ngày: Hoàn tiền 50%</li>
              <li>Hủy từ 3-6 ngày: Hoàn tiền 30%</li>
              <li>Hủy trong vòng 48 giờ: Không hoàn tiền</li>
            </ul>
            <p class="mt-2">Lưu ý: Một số tour đặc biệt có thể có chính sách hủy riêng, vui lòng kiểm tra thông tin chi
              tiết khi đặt tour.</p>
          </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="p-6">
          <h3 class="text-lg font-medium text-teal-600">
            Tôi có cần visa khi đi tour nước ngoài không?
          </h3>
          <div class="mt-2 text-gray-700">
            <p>Đối với các tour quốc tế, yêu cầu visa phụ thuộc vào quốc gia bạn đến:</p>
            <ul class="list-disc pl-5 mt-2 space-y-1">
              <li>Một số quốc gia miễn visa cho công dân Việt Nam trong thời gian nhất định</li>
              <li>Một số quốc gia yêu cầu visa nhưng có thể xin visa khi đến (visa on arrival)</li>
              <li>Một số quốc gia yêu cầu visa phải được xin trước</li>
            </ul>
            <p class="mt-2">Khi bạn đặt tour, chúng tôi sẽ thông báo yêu cầu visa và hỗ trợ bạn trong quá trình xin visa
              nếu cần.</p>
          </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="p-6">
          <h3 class="text-lg font-medium text-teal-600">
            Tôi có thể thanh toán bằng những phương thức nào?
          </h3>
          <div class="mt-2 text-gray-700">
            <p>Ditravel chấp nhận nhiều phương thức thanh toán khác nhau:</p>
            <ul class="list-disc pl-5 mt-2 space-y-1">
              <li>Thẻ tín dụng/ghi nợ (Visa, Mastercard, JCB)</li>
              <li>Chuyển khoản ngân hàng</li>
              <li>Ví điện tử (MoMo, ZaloPay, VNPay)</li>
              <li>Thanh toán tại văn phòng Ditravel</li>
              <li>Trả góp qua các ngân hàng đối tác</li>
            </ul>
          </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="p-6">
          <h3 class="text-lg font-medium text-teal-600">
            Tôi có thể đặt tour theo yêu cầu riêng không?
          </h3>
          <div class="mt-2 text-gray-700">
            <p>Có, Ditravel cung cấp dịch vụ thiết kế tour theo yêu cầu riêng của khách hàng. Để đặt tour theo yêu cầu,
              bạn có thể:</p>
            <ul class="list-disc pl-5 mt-2 space-y-1">
              <li>Liên hệ trực tiếp với chúng tôi qua hotline 1900 1234</li>
              <li>Gửi yêu cầu qua email info@ditravel.com</li>
              <li>Sử dụng mẫu "Yêu cầu tour" trên trang web của chúng tôi</li>
            </ul>
            <p class="mt-2">Đội ngũ tư vấn viên của chúng tôi sẽ liên hệ với bạn trong vòng 24 giờ để tư vấn và thiết kế
              tour phù hợp với nhu cầu của bạn.</p>
          </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="p-6">
          <h3 class="text-lg font-medium text-teal-600">
            Ditravel có chương trình khách hàng thân thiết không?
          </h3>
          <div class="mt-2 text-gray-700">
            <p>Có, Ditravel có chương trình khách hàng thân thiết với nhiều ưu đãi hấp dẫn:</p>
            <ul class="list-disc pl-5 mt-2 space-y-1">
              <li>Tích điểm cho mỗi đơn hàng</li>
              <li>Đổi điểm lấy ưu đãi và giảm giá</li>
              <li>Quà tặng sinh nhật</li>
              <li>Ưu tiên khi có tour mới và khuyến mãi</li>
              <li>Dịch vụ chăm sóc khách hàng VIP</li>
            </ul>
            <p class="mt-2">Để tham gia chương trình, bạn chỉ cần đăng ký tài khoản trên website của chúng tôi.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-10 text-center">
      <p class="text-gray-600">Bạn không tìm thấy câu trả lời cho thắc mắc của mình?</p>
      <a href="<?= UrlHelper::route('home/contact') ?>"
        class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700">
        Liên hệ với chúng tôi
      </a>
    </div>
  </div>
</div>