<?php
// activities.php
use App\Helpers\UrlHelper;
?>

<div class="bg-gray-50 min-h-screen">
  <!-- Hero Section -->
  <div class="relative bg-teal-600">
    <div class="absolute inset-0 overflow-hidden rounded-md">
      <img src="<?= UrlHelper::image('company/activities-hero.jpg') ?>" alt="Hoạt động công ty Ditravel"
        class="w-full h-full object-cover opacity-40 rounded-md">
    </div>
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 rounded-md">
      <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Hoạt động của Ditravel</h1>
      <p class="mt-6 text-xl text-white max-w-3xl">
        Khám phá những hoạt động, sự kiện và thành tựu mới nhất của chúng tôi trong hành trình phát triển và đóng góp
        cho cộng đồng.
      </p>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Activity Categories -->
    <div class="mb-12">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Danh mục hoạt động</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="<?= UrlHelper::route('activities/category/company-events') ?>"
          class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-teal-100 text-teal-600 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900">Sự kiện công ty</h3>
          <p class="mt-2 text-sm text-gray-500">Các sự kiện nội bộ và hoạt động team building của Ditravel</p>
        </a>

        <a href="<?= UrlHelper::route('activities/category/csr') ?>"
          class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-teal-100 text-teal-600 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900">Trách nhiệm xã hội</h3>
          <p class="mt-2 text-sm text-gray-500">Các hoạt động từ thiện và đóng góp cho cộng đồng</p>
        </a>

        <a href="<?= UrlHelper::route('activities/category/achievements') ?>"
          class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-teal-100 text-teal-600 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900">Thành tựu & Giải thưởng</h3>
          <p class="mt-2 text-sm text-gray-500">Những giải thưởng và thành tựu của Ditravel</p>
        </a>

        <a href="<?= UrlHelper::route('activities/category/development') ?>"
          class="bg-white rounded-lg shadow-sm p-6 text-center hover:shadow-md transition-shadow">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-teal-100 text-teal-600 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900">Phát triển công ty</h3>
          <p class="mt-2 text-sm text-gray-500">Các dự án phát triển và mở rộng của Ditravel</p>
        </a>
      </div>
    </div>

    <!-- Timeline -->
    <div class="mb-16">
      <h2 class="text-2xl font-bold text-gray-900 mb-8">Dấu mốc phát triển</h2>

      <div class="relative border-l-4 border-teal-200 ml-6 pl-8 pb-6">
        <!-- Timeline items -->
        <div class="mb-12 relative">
          <div
            class="absolute -left-14 mt-1.5 w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold">
            2025
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Mở rộng thị trường miền Trung</h3>
          <p class="text-gray-600 mb-4">
            Khai trương văn phòng mới tại Đà Nẵng, đánh dấu bước phát triển quan trọng trong chiến lược mở rộng thị
            trường miền Trung.
          </p>
          <img src="<?= UrlHelper::image('company/timeline-2025.jpg') ?>" alt="Mở rộng thị trường miền Trung"
            class="rounded-lg w-full md:w-2/3 h-64 object-cover">
        </div>

        <div class="mb-12 relative">
          <div
            class="absolute -left-14 mt-1.5 w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold">
            2023
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Ra mắt nền tảng đặt tour trực tuyến</h3>
          <p class="text-gray-600 mb-4">
            Ditravel chính thức ra mắt nền tảng đặt tour trực tuyến, giúp khách hàng dễ dàng tìm kiếm và đặt các dịch vụ
            du lịch một cách nhanh chóng và thuận tiện.
          </p>
          <img src="<?= UrlHelper::image('company/timeline-2023.jpg') ?>" alt="Ra mắt nền tảng đặt tour trực tuyến"
            class="rounded-lg w-full md:w-2/3 h-64 object-cover">
        </div>

        <div class="mb-12 relative">
          <div
            class="absolute -left-14 mt-1.5 w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold">
            2020
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Mở rộng dịch vụ du lịch trong nước</h3>
          <p class="text-gray-600 mb-4">
            Trong bối cảnh đại dịch COVID-19, Ditravel đã nhanh chóng chuyển hướng và mở rộng các dịch vụ du lịch trong
            nước, góp phần thúc đẩy ngành du lịch nội địa phát triển.
          </p>
          <img src="<?= UrlHelper::image('company/timeline-2020.png') ?>" alt="Mở rộng dịch vụ du lịch trong nước"
            class="rounded-lg w-full md:w-2/3 h-64 object-cover">
        </div>

        <div class="relative">
          <div
            class="absolute -left-14 mt-1.5 w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold">
            2018
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Thành lập công ty Ditravel</h3>
          <p class="text-gray-600 mb-4">
            Ditravel được thành lập với sứ mệnh mang đến những trải nghiệm du lịch chất lượng và đáng nhớ cho khách
            hàng, đồng thời góp phần phát triển ngành du lịch Việt Nam.
          </p>
          <img src="<?= UrlHelper::image('company/timeline-2018.png') ?>" alt="Thành lập công ty Ditravel"
            class="rounded-lg w-full md:w-2/3 h-64 object-cover">
        </div>
      </div>
    </div>

    <!-- CSR Activities -->
    <div class="mb-16">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Hoạt động trách nhiệm xã hội</h2>
        <a href="<?= UrlHelper::route('activities/category/csr') ?>"
          class="text-teal-600 hover:text-teal-700 font-medium">
          Xem tất cả <span aria-hidden="true">→</span>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="md:flex">
            <div class="md:flex-shrink-0 md:w-2/5">
              <img class="h-48 w-full object-cover md:h-full" src="<?= UrlHelper::image('company/csr-1.jpg') ?>"
                alt="Chương trình trồng rừng bảo vệ môi trường">
            </div>
            <div class="p-6 md:w-3/5">
              <div class="flex items-center text-sm text-gray-500 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                20/01/2025
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Chương trình trồng rừng bảo vệ môi trường</h3>
              <p class="text-gray-600 mb-4 line-clamp-3">
                Ditravel phối hợp với Sở Nông nghiệp và Phát triển Nông thôn tỉnh Lâm Đồng tổ chức chương trình trồng
                1000 cây xanh tại khu vực rừng phòng hộ Đà Lạt.
              </p>
              <a href="<?= UrlHelper::route('activities/detail/5') ?>"
                class="text-teal-600 hover:text-teal-700 font-medium">
                Đọc thêm <span aria-hidden="true">→</span>
              </a>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="md:flex">
            <div class="md:flex-shrink-0 md:w-2/5">
              <img class="h-48 w-full object-cover md:h-full" src="<?= UrlHelper::image('company/csr-2.jpg') ?>"
                alt="Chương trình tặng quà cho trẻ em vùng cao">
            </div>
            <div class="p-6 md:w-3/5">
              <div class="flex items-center text-sm text-gray-500 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-teal-500" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                15/12/2024
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Chương trình tặng quà cho trẻ em vùng cao</h3>
              <p class="text-gray-600 mb-4 line-clamp-3">
                Ditravel tổ chức chương trình "Mùa đông ấm áp" tặng quà cho hơn 200 em học sinh tại các trường tiểu học
                vùng cao tỉnh Lào Cai.
              </p>
              <a href="<?= UrlHelper::route('activities/detail/6') ?>"
                class="text-teal-600 hover:text-teal-700 font-medium">
                Đọc thêm <span aria-hidden="true">→</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Photo Gallery -->
    <div class="mb-16">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Thư viện hình ảnh</h2>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php
        $galleryImages = [
          ['image' => 'gallery-1.jpg', 'title' => 'Lễ khai trương văn phòng Đà Nẵng'],
          ['image' => 'gallery-2.jpg', 'title' => 'Team building Phú Quốc 2025'],
          ['image' => 'gallery-3.jpg', 'title' => 'Nhận giải thưởng "Doanh nghiệp du lịch tiêu biểu"'],
          ['image' => 'gallery-4.jpg', 'title' => 'Chương trình trao học bổng'],
          ['image' => 'gallery-5.jpg', 'title' => 'Hoạt động trồng cây xanh'],
          ['image' => 'gallery-6.jpg', 'title' => 'Hội nghị khách hàng 2024'],
          ['image' => 'gallery-7.jpg', 'title' => 'Đào tạo nhân viên mới'],
          ['image' => 'gallery-8.jpg', 'title' => 'Tất niên công ty 2024'],
        ];
        
        foreach ($galleryImages as $image):
        ?>
        <div class="relative group overflow-hidden rounded-lg">
          <img src="<?= UrlHelper::image('company/gallery/' . $image['image']) ?>" alt="<?= $image['title'] ?>"
            class="w-full h-40 object-cover group-hover:scale-110 transition-transform duration-300">
          <div
            class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <span class="text-white text-sm font-medium px-2 text-center"><?= $image['title'] ?></span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-6 text-center">
        <a href="<?= UrlHelper::route('activities/gallery') ?>"
          class="inline-flex items-center px-4 py-2 border border-teal-600 text-base font-medium rounded-md text-teal-600 bg-white hover:bg-teal-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
          Xem tất cả hình ảnh
        </a>
      </div>
    </div>

    <!-- Join Our Team -->
    <div class="bg-teal-50 rounded-2xl p-8 md:p-12">
      <div class="md:flex md:items-center md:justify-between">
        <div class="md:w-2/3">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Tham gia cùng Ditravel</h2>
          <p class="text-gray-600 mb-6 md:mb-0 md:pr-8">
            Chúng tôi luôn tìm kiếm những người tài năng và đam mê du lịch để cùng nhau phát triển. Khám phá các cơ hội
            nghề nghiệp tại Ditravel và trở thành một phần của đội ngũ chúng tôi.
          </p>
        </div>
        <div class="md:w-1/3 md:text-right">
          <a href="<?= UrlHelper::route('careers') ?>"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            Xem vị trí tuyển dụng
          </a>
        </div>
      </div>
    </div>
  </div>
</div>