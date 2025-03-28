<?php
// terms.php
use App\Helpers\UrlHelper;
?>

<div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl mx-auto">
    <div class="text-center mb-12">
      <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
        Điều khoản sử dụng
      </h1>
      <p class="mt-4 text-lg text-gray-600">
        Cập nhật lần cuối: <?= date('d/m/Y', strtotime('-45 days')) ?>
      </p>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="p-6 sm:p-8">
        <div class="prose prose-teal max-w-none">
          <h2>1. Giới thiệu</h2>
          <p>
            Chào mừng bạn đến với Ditravel. Các Điều khoản Sử dụng này ("Điều khoản") điều chỉnh việc bạn truy cập và sử
            dụng trang web, ứng dụng di động và dịch vụ của Ditravel (gọi chung là "Dịch vụ").
          </p>
          <p>
            Bằng việc truy cập hoặc sử dụng Dịch vụ của chúng tôi, bạn đồng ý bị ràng buộc bởi các Điều khoản này. Nếu
            bạn không đồng ý với bất kỳ phần nào của các Điều khoản này, bạn không được phép truy cập hoặc sử dụng Dịch
            vụ của chúng tôi.
          </p>

          <h2>2. Tài khoản người dùng</h2>
          <p>
            Khi bạn tạo tài khoản với chúng tôi, bạn phải cung cấp thông tin chính xác, đầy đủ và cập nhật. Bạn chịu
            trách nhiệm bảo mật tài khoản của mình, bao gồm mật khẩu, và bạn chịu trách nhiệm về tất cả hoạt động diễn
            ra dưới tài khoản của mình.
          </p>
          <p>
            Bạn phải thông báo cho chúng tôi ngay lập tức về bất kỳ hành vi sử dụng trái phép tài khoản của bạn hoặc bất
            kỳ vi phạm bảo mật nào khác. Chúng tôi không chịu trách nhiệm về bất kỳ tổn thất nào phát sinh từ việc sử
            dụng trái phép tài khoản của bạn.
          </p>

          <h2>3. Đặt tour và thanh toán</h2>
          <p>
            Khi đặt tour qua Ditravel, bạn đồng ý cung cấp thông tin chính xác và đầy đủ cho tất cả hành khách. Việc xác
            nhận đặt tour phụ thuộc vào tình trạng còn chỗ và các yếu tố khác.
          </p>
          <p>
            Giá tour có thể thay đổi cho đến khi thanh toán đầy đủ. Một số trường hợp, ngay cả sau khi thanh toán, giá
            có thể thay đổi do các yếu tố ngoài tầm kiểm soát của chúng tôi (như thuế, phí sân bay, tỷ giá hối đoái).
          </p>
          <p>
            Bạn phải thanh toán đầy đủ theo lịch thanh toán được quy định. Nếu không thanh toán đúng hạn, đặt tour của
            bạn có thể bị hủy và các khoản đã thanh toán có thể không được hoàn lại.
          </p>

          <h2>4. Chính sách hủy và hoàn tiền</h2>
          <p>
            Chính sách hủy và hoàn tiền của chúng tôi được quy định cụ thể cho từng tour. Vui lòng đọc kỹ chính sách này
            trước khi đặt tour.
          </p>
          <p>
            Nói chung, các khoản hoàn tiền sẽ được xử lý trong vòng 7-14 ngày làm việc và sẽ được hoàn trả theo phương
            thức thanh toán ban đầu khi có thể.
          </p>
          <p>
            Trong trường hợp bất khả kháng (thiên tai, dịch bệnh, bạo loạn, v.v.), chúng tôi có thể áp dụng chính sách
            hủy và hoàn tiền đặc biệt.
          </p>

          <h2>5. Trách nhiệm của người dùng</h2>
          <p>Khi sử dụng Dịch vụ của chúng tôi, bạn đồng ý:</p>
          <ul>
            <li>Tuân thủ tất cả luật pháp và quy định hiện hành</li>
            <li>Cung cấp thông tin chính xác và đầy đủ</li>
            <li>Không sử dụng Dịch vụ cho mục đích bất hợp pháp hoặc trái phép</li>
            <li>Không gửi hoặc tải lên bất kỳ nội dung nào vi phạm quyền của người khác</li>
            <li>Không can thiệp vào hoạt động bình thường của Dịch vụ</li>
            <li>Không cố gắng truy cập trái phép vào hệ thống hoặc mạng của chúng tôi</li>
          </ul>

          <h2>6. Nội dung người dùng</h2>
          <p>
            Khi bạn đăng tải, gửi, hoặc chia sẻ nội dung trên Dịch vụ của chúng tôi (như đánh giá, bình luận, hình ảnh),
            bạn cấp cho chúng tôi quyền sử dụng, sao chép, sửa đổi, phân phối và hiển thị nội dung đó trên Dịch vụ của
            chúng tôi.
          </p>
          <p>
            Bạn chịu trách nhiệm về nội dung bạn đăng tải và đảm bảo rằng bạn có quyền cấp phép cho chúng tôi như đã nêu
            trên.
          </p>

          <h2>7. Giới hạn trách nhiệm</h2>
          <p>
            Trong phạm vi tối đa được pháp luật cho phép, Ditravel và các đối tác của chúng tôi không chịu trách nhiệm
            về bất kỳ thiệt hại trực tiếp, gián tiếp, ngẫu nhiên, đặc biệt, hậu quả hoặc mang tính trừng phạt nào phát
            sinh từ việc sử dụng hoặc không thể sử dụng Dịch vụ của chúng tôi.
          </p>
          <p>
            Chúng tôi không chịu trách nhiệm về chất lượng, an toàn, hợp pháp hoặc bất kỳ khía cạnh nào khác của bất kỳ
            hàng hóa hoặc dịch vụ nào bạn đặt thông qua Dịch vụ của chúng tôi.
          </p>

          <h2>8. Thay đổi điều khoản</h2>
          <p>
            Chúng tôi có thể sửa đổi các Điều khoản này theo thời gian. Nếu chúng tôi thực hiện thay đổi, chúng tôi sẽ
            cung cấp thông báo hợp lý, chẳng hạn như đăng các Điều khoản đã sửa đổi trên trang web của chúng tôi và cập
            nhật ngày "Cập nhật lần cuối".
          </p>
          <p>
            Việc bạn tiếp tục sử dụng Dịch vụ sau khi các Điều khoản đã sửa đổi có hiệu lực đồng nghĩa với việc bạn chấp
            nhận các Điều khoản đã sửa đổi.
          </p>

          <h2>9. Luật áp dụng</h2>
          <p>
            Các Điều khoản này sẽ được điều chỉnh và giải thích theo luật pháp Việt Nam, không áp dụng các nguyên tắc
            xung đột pháp luật.
          </p>

          <h2>10. Liên hệ</h2>
          <p>
            Nếu bạn có bất kỳ câu hỏi nào về các Điều khoản này, vui lòng liên hệ với chúng tôi:
          </p>
          <ul>
            <li>Email: legal@ditravel.com</li>
            <li>Điện thoại: 1900 1234</li>
            <li>Địa chỉ: 123 Đường Du Lịch, Quận 1, TP. Hồ Chí Minh</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>