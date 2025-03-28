<?php

use App\Helpers\UrlHelper;

$title = 'Giới Thiệu - Di Travel';
$activePage = 'about';
?>

<div class="py-8 md:py-12">
  <!-- Hero Section -->
  <div class="relative mb-16">
    <div class="w-full h-[300px] md:h-[400px] bg-cover bg-center bg-teal-500"
      style="background-image: url('<?= UrlHelper::image('about-hero.jpg') ?>')">
      <div class="absolute inset-0 bg-black opacity-50"></div>
      <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white px-4">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Về Di Travel</h1>
          <p class="text-xl md:text-2xl max-w-3xl mx-auto">Khám phá thế giới cùng chúng tôi, từng hành trình một</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Our Story Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-10">
    <div class="flex flex-col md:flex-row items-center gap-12">
      <div class="md:w-1/2">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Câu Chuyện Của Chúng Tôi</h2>
        <div class="prose max-w-none">
          <p class="text-gray-600 mb-4">
            Được thành lập vào năm 2015, <span class="text-teal-600 font-semibold">Di Travel</span> bắt đầu với một tầm
            nhìn đơn giản: mang đến những trải nghiệm du lịch phi thường cho tất cả mọi người. Từ một đội ngũ nhỏ gồm
            những người đam mê du lịch, chúng tôi đã phát triển thành một công ty du lịch uy tín kết nối hàng nghìn du
            khách đến với các điểm đến trên khắp thế giới.
          </p>
          <p class="text-gray-600 mb-4">
            Tên gọi "Di Travel" bắt nguồn từ từ "đi" trong tiếng Việt - thể hiện triết lý của chúng tôi rằng những
            khoảnh khắc tuyệt vời nhất trong cuộc sống đến từ việc bước ra thế giới và trải nghiệm những nền văn hóa,
            phong cảnh và cuộc phiêu lưu mới.
          </p>
          <p class="text-gray-600">
            Ngày nay, chúng tôi tự hào cung cấp các tour du lịch được lựa chọn kỹ lưỡng đến hơn 50 quốc gia, với các
            hướng dẫn viên địa phương chuyên nghiệp, những người chia sẻ niềm đam mê của chúng tôi về trải nghiệm du
            lịch chân thực. Dù bạn đang tìm kiếm sự thư giãn trên những bãi biển nguyên sơ, đắm mình trong văn hóa tại
            các thành phố lịch sử, hay phiêu lưu trong những cảnh quan thiên nhiên tuyệt đẹp, Di Travel là người bạn
            đồng hành đáng tin cậy cho những hành trình ý nghĩa.
          </p>
        </div>
      </div>
      <div class="md:w-1/2">
        <img src="<?= UrlHelper::image('banner-auth.png') ?>" alt="Đội ngũ Di Travel"
          class="rounded-lg shadow-lg w-full h-[400px] object-cover" />
      </div>
    </div>
  </div>

  <!-- Our Values Section -->
  <div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Giá Trị Cốt Lõi</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Value 1 -->
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-teal-100 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Trải Nghiệm Chân Thực</h3>
          <p class="text-gray-600">
            Chúng tôi tin vào du lịch kết nối bạn với văn hóa địa phương và tạo ra những kỷ niệm ý nghĩa vượt xa những
            điểm tham quan du lịch thông thường.
          </p>
        </div>

        <!-- Value 2 -->
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-teal-100 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Du Lịch Có Trách Nhiệm</h3>
          <p class="text-gray-600">
            Chúng tôi cam kết thực hiện các hoạt động bền vững, tôn trọng cộng đồng địa phương và bảo tồn vẻ đẹp tự
            nhiên của các điểm đến.
          </p>
        </div>

        <!-- Value 3 -->
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-teal-100 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-3">Dịch Vụ Cá Nhân Hóa</h3>
          <p class="text-gray-600">
            Mỗi du khách đều là duy nhất, đó là lý do tại sao chúng tôi cung cấp sự quan tâm cá nhân và điều chỉnh trải
            nghiệm phù hợp với sở thích và nhu cầu của bạn.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Why Choose Us Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Tại Sao Chọn Di Travel</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Reason 1 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Đặt Tour An Toàn 100%</h3>
        <p class="text-gray-600 text-center">
          Thanh toán và thông tin cá nhân của bạn luôn được bảo vệ với hệ thống đặt tour an toàn của chúng tôi.
        </p>
      </div>

      <!-- Reason 2 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Hỗ Trợ 24/7</h3>
        <p class="text-gray-600 text-center">
          Đội ngũ dịch vụ khách hàng tận tâm của chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc với bất kỳ câu hỏi hoặc thắc
          mắc nào.
        </p>
      </div>

      <!-- Reason 3 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Đảm Bảo Giá Tốt Nhất</h3>
        <p class="text-gray-600 text-center">
          Chúng tôi cung cấp giá cả cạnh tranh và sẽ đáp ứng bất kỳ ưu đãi tương đương nào cho cùng một tour và điều
          kiện.
        </p>
      </div>

      <!-- Reason 4 -->
      <div class="flex flex-col items-center">
        <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center">Hướng Dẫn Viên Chuyên Nghiệp</h3>
        <p class="text-gray-600 text-center">
          Các hướng dẫn viên am hiểu của chúng tôi cung cấp góc nhìn nội địa và đảm bảo bạn trải nghiệm bản chất chân
          thực của mỗi điểm đến.
        </p>
      </div>
    </div>
  </div>

  <!-- Team Section -->
  <div class="bg-gray-50 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Đội Ngũ Của Chúng Tôi</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Team Member 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="<?= UrlHelper::image('team-1.jpg') ?>" alt="Thành viên đội ngũ"
            class="w-full h-64 object-cover object-center" />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">Nguyễn Văn Minh</h3>
            <p class="text-teal-600 mb-3">Nhà Sáng Lập & CEO</p>
            <p class="text-gray-600 text-sm">
              Với hơn 15 năm kinh nghiệm trong ngành du lịch, niềm đam mê khám phá của Minh đã dẫn đến sự ra đời của Di
              Travel.
            </p>
          </div>
        </div>

        <!-- Team Member 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="<?= UrlHelper::image('team-2.jpg') ?>" alt="Thành viên đội ngũ"
            class="w-full h-64 object-cover object-center" />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">Trần Thị Lan</h3>
            <p class="text-teal-600 mb-3">Giám Đốc Điều Hành</p>
            <p class="text-gray-600 text-sm">
              Lan đảm bảo mỗi tour đều diễn ra suôn sẻ, kết hợp sự lên kế hoạch tỉ mỉ với hiểu biết sâu sắc về nhu cầu
              của du khách.
            </p>
          </div>
        </div>

        <!-- Team Member 3 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="<?= UrlHelper::image('team-3.jpg') ?>" alt="Thành viên đội ngũ"
            class="w-full h-64 object-cover object-center" />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">Lê Quang Hải</h3>
            <p class="text-teal-600 mb-3">Quản Lý Phát Triển Tour</p>
            <p class="text-gray-600 text-sm">
              Kinh nghiệm du lịch qua hơn 70 quốc gia giúp Hải tạo ra những lịch trình độc đáo, nắm bắt được tinh hoa
              của mỗi điểm đến.
            </p>
          </div>
        </div>

        <!-- Team Member 4 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="<?= UrlHelper::image('team-4.jpg') ?>" alt="Thành viên đội ngũ"
            class="w-full h-64 object-cover object-center" />
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-1">Phạm Thu Hà</h3>
            <p class="text-teal-600 mb-3">Giám Đốc Trải Nghiệm Khách Hàng</p>
            <p class="text-gray-600 text-sm">
              Sự tận tâm của Hà đối với dịch vụ xuất sắc đảm bảo mỗi du khách đều nhận được sự chăm sóc cá nhân từ lúc
              đặt tour đến khi trở về.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Testimonials Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Khách Hàng Nói Gì Về Chúng Tôi</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Testimonial 1 -->
      <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="flex items-center mb-4">
          <div class="text-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
        <p class="text-gray-600 italic mb-4">
          "Chuyến đi gia đình của chúng tôi đến Vịnh Hạ Long thật hoàn hảo. Hướng dẫn viên rất am hiểu, chỗ ở tuyệt vời,
          và lịch trình cho phép chúng tôi trải nghiệm cả những điểm tham quan phổ biến lẫn những địa điểm ẩn."
        </p>
        <div class="flex items-center">
          <img src="<?= UrlHelper::image('testimonial-1.jpg') ?>" alt="Khách hàng"
            class="w-12 h-12 rounded-full mr-4 object-cover" />
          <div>
            <h4 class="font-semibold text-gray-800">David Chen</h4>
            <p class="text-gray-500 text-sm">Singapore</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="flex items-center mb-4">
          <div class="text-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
        <p class="text-gray-600 italic mb-4">
          "Chuyến đi gia đình của chúng tôi đến Vịnh Hạ Long thật hoàn hảo. Hướng dẫn viên rất am hiểu, chỗ ở tuyệt vời,
          và lịch trình cho phép chúng tôi trải nghiệm cả những điểm tham quan phổ biến lẫn những địa điểm ẩn."
        </p>
        <div class="flex items-center">
          <img src="<?= UrlHelper::image('testimonial-1.jpg') ?>" alt="Khách hàng"
            class="w-12 h-12 rounded-full mr-4 object-cover" />
          <div>
            <h4 class="font-semibold text-gray-800">David Chen</h4>
            <p class="text-gray-500 text-sm">Singapore</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-8 rounded-lg shadow-md">
        <div class="flex items-center mb-4">
          <div class="text-teal-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
              <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
        <p class="text-gray-600 italic mb-4">
          "Hết nước chấm..."
        </p>
        <div class="flex items-center">
          <img src="<?= UrlHelper::image('testimonial-1.jpg') ?>" alt="Khách hàng"
            class="w-12 h-12 rounded-full mr-4 object-cover" />
          <div>
            <h4 class="font-semibold text-gray-800">Bình Dev</h4>
            <p class="text-gray-500 text-sm">Vietnam</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>