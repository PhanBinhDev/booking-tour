<?php

namespace App\Controllers;

use App\Helpers\UrlHelper;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\Contact;
use App\Models\Categories;
use App\Models\Location;
use App\Models\Favorites;
use App\Models\NewsModel;
use App\Models\PaymentMethod;
use App\Services\StripeService;

class HomeController extends BaseController
{
  private $tourModel;
  private $locationModel;
  private $newsModel;
  private $contactModel;
  private $categoriesModel;
  private $stripeService;
  private $bookingModel;
  private $favoriteModel;
  private $paymentMethodModel;

  function __construct()
  {
    // $route = $this->getRouteByRole();
    // $roleBase = 'user';
    // $role = $this->getRole();
    // if ($role !== $roleBase) {
    //   $this->redirect($route);
    // }

    $this->tourModel = new Tour();
    $this->locationModel = new Location();
    $this->newsModel = new NewsModel();
    $this->contactModel = new Contact();
    $this->categoriesModel = new Categories();
    $this->stripeService = new StripeService();
    $this->bookingModel = new Booking();
    $this->paymentMethodModel = new PaymentMethod();
    $this->newsModel = new NewsModel();
    $this->favoriteModel = new Favorites();
  }
  public function index()
  {
    $categories = $this->categoriesModel->getAll();
    $locations = $this->locationModel->getAll();

    $allTours = $this->tourModel->getTours([], 'default', true, 8);

    // Lấy tour nổi bật
    $allFeaturedTours = $this->tourModel->getFeaturedTours(3, false);

    // Lấy tin tức
    $newsColumns = 'id, title, summary, featured_image, created_at';
    $newsConditions = ['featured' => 1];
    $news = $this->newsModel->getAll($newsColumns, $newsConditions, null, 3);

    $currentUser = $this->getCurrentUser();
    $userFavorites = [];
    if ($currentUser) {
      $userId = $currentUser['id'];
      $userFavorites = $this->favoriteModel->getFavoriteTourIdsByUser($userId);
    }

    $this->view('home/index', [
      'allTours' => $allTours,
      'categories' => $categories,
      'allFeaturedTours' => $allFeaturedTours,
      'news' => $news,
      'locations' => $locations,
      'userFavorites' => $userFavorites
    ]);
  }


  function about()
  {
    $this->view('home/about');
  }

  function contact()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['name'] ?? '';
      $email = $_POST['email'] ?? '';
      $phone = $_POST['phone'] ?? '';
      $subject = $_POST['subject'] ?? '';
      $message = $_POST['message'] ?? '';

      $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message,
      ];
      $this->contactModel->createContact($data);
    }


    $this->view('home/contact');
  }

  function news()
  {
    // Xử lý các tham số từ URL
    $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;
    $tag = isset($_GET['tag']) ? trim($_GET['tag']) : '';
    $search = isset($_GET['s']) ? trim($_GET['s']) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Kích thước trang và vị trí bắt đầu
    $perPage = 6;
    $offset = ($page - 1) * $perPage;

    // Lấy danh sách các danh mục tin tức
    $getActiveCategories = $this->newsModel->getActiveCategories();

    // Lấy tên danh mục hiện tại nếu có
    $currentCategoryName = '';
    if ($categoryId > 0) {
      foreach ($getActiveCategories as $cat) {
        if ($cat['id'] == $categoryId) {
          $currentCategoryName = $cat['name'];
          break;
        }
      }
    }

    // Lấy bài viết
    $newsList = $this->newsModel->getFilteredNews($categoryId, $tag, $search, $perPage, $offset);

    // Tính tổng số bài viết và số trang
    $totalNewsCount = $this->newsModel->countFilteredNews($categoryId, $tag, $search);
    $totalPages = ceil($totalNewsCount / $perPage);

    // Lấy bài nổi bật (chỉ khi không lọc)
    $featuredNews = null;
    if ($page == 1 && empty($categoryId) && empty($tag) && empty($search)) {
      $featuredNews = $this->newsModel->getFeaturedNews();
    }

    // Lấy bài viết xem nhiều nhất
    $topViewedNews = $this->newsModel->getTopViewedNews(5);
    $top1ViewedNews = $this->newsModel->getTopViewedNews(1);
    // echo "<pre>";
    // print_r($top1ViewedNews);die;


    // Lấy danh sách tags phổ biến
    $popularTags = $this->newsModel->getPopularTags(10);

    $this->view('home/news', [
      'getActiveCategories' => $getActiveCategories,
      'newsList' => $newsList,
      'featuredNews' => $featuredNews,
      'topViewedNews' => $topViewedNews,
      'popularTags' => $popularTags,
      'currentCategoryName' => $currentCategoryName,
      'totalNewsCount' => $totalNewsCount,
      'currentPage' => $page,
      'totalPages' => $totalPages,
      'top1ViewedNews' => $top1ViewedNews,
    ]);
  }

  function newsDetail($id)
  {
    // Lấy thông tin bài viết hiện tại
    $news = $this->newsModel->getById($id);

    if (!$news) {
      $this->setFlashMessage('error', 'Không tìm thấy bài viết');
      $this->redirect(UrlHelper::route('home/news'));
      return;
    }

    // Tăng lượt xem cho bài viết
    if (isset($news['views'])) {
      $this->newsModel->incrementViews($id);
      $news['views'] = $news['views'] + 1;
    }

    // Lấy các bài viết xem nhiều nhất
    $topViewedNews = $this->newsModel->getTopViewedNews(3);

    // Lấy các bài viết liên quan (cùng danh mục, không bao gồm bài hiện tại)
    $relatedNews = [];
    if (isset($news['category_id'])) {
      $relatedNews = $this->newsModel->getRelatedNews($news['category_id'], $id, 4);
    }

    // Lấy danh sách danh mục tin tức
    $categories = $this->newsModel->getActiveCategories();

    // Hiển thị view với dữ liệu đầy đủ
    $this->view('home/news-detail', [
      'news' => $news,
      'topViewedNews' => $topViewedNews,
      'relatedNews' => $relatedNews,
      'categories' => $categories
    ]);
  }

  function faq()
  {
    $this->view('home/faq');
  }

  function terms()
  {
    $this->view('home/terms');
  }

  function privacyPolicy()
  {
    $this->view('home/privacy-policy');
  }

  function activities()
  {
    $this->view('home/activities');
  }

  /**
   * Display the tours page with filters and pagination
   * 
   * @return void
   */
  public function tours()
  {
    // Get categories and locations
    $categories = $this->categoriesModel->getAll();
    $locations = $this->locationModel->getAll();

    // Get pagination parameters
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
    $perPage = 9; // Number of tours per page

    // Get filter parameters from URL
    $category_id = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT) ?: null;
    $location_id = filter_input(INPUT_GET, 'location', FILTER_VALIDATE_INT) ?: null;

    // Validate sort option
    $validSortOptions = ['popular', 'price_asc', 'price_desc', 'rating', 'newest'];
    $sort_option = isset($_GET['sort']) && in_array($_GET['sort'], $validSortOptions)
      ? $_GET['sort']
      : 'popular';

    // Process array-type filters
    $price_ranges = [];
    if (isset($_GET['price_range'])) {
      if (is_array($_GET['price_range'])) {
        $price_ranges = $_GET['price_range'];
      } else if ($_GET['price_range'] !== 'all') {
        // Nếu price_range là giá trị đơn (từ radio button) và không phải "all"
        $price_ranges = [$_GET['price_range']];  // Chuyển đổi thành mảng
      }
    }

    $durations = [];
    if (isset($_GET['duration']) && is_array($_GET['duration'])) {
      $durations = $_GET['duration'];
    }

    $ratings = [];
    if (isset($_GET['rating']) && is_array($_GET['rating'])) {
      $ratings = $_GET['rating'];
    }

    // Build filters array
    $filters = [
      'category_id' => $category_id,
      'location_id' => $location_id,
      'price_ranges' => $price_ranges,
      'durations' => $durations,
      'ratings' => $ratings
    ];

    // Add keyword search if provided
    if (!empty($_GET['keyword'])) {
      $filters['keyword'] = trim($_GET['keyword']);
    }

    // Get paginated tours
    $toursData = $this->tourModel->getToursWithPagination(
      $filters,
      $sort_option,
      false,  // onlySalePrice
      $page,
      $perPage
    );

    // Get favorite tours for the current user
    $currentUser = $this->getCurrentUser();
    $userFavorites = [];

    if ($currentUser) {
      $userId = $currentUser['id'];
      $userFavorites = $this->favoriteModel->getFavoriteTourIdsByUser($userId);
    }

    $categoryCounts = [];
    foreach ($categories as $category) {
      $categoryCounts[$category['id']] = $this->tourModel->countToursByCategory($category['id']);
    }

    // Pass all necessary data to the view
    $this->view('home/tours', [
      'allTours' => $toursData['items'],
      'pagination' => $toursData['pagination'],
      'categories' => $categories,
      'categoryCounts' => $categoryCounts,
      'locations' => $locations,
      'currentCategory' => $category_id,
      'selectedSort' => $sort_option,
      'selectedPriceRanges' => $price_ranges,
      'selectedDurations' => $durations,
      'selectedRatings' => $ratings,
      'userFavorites' => $userFavorites,
      'keyword' => $filters['keyword'] ?? ''
    ]);
  }

  function tourDetail($id)
  {
    $tourDetails = $this->tourModel->getTourDetails($id);
    $itinerary = json_decode($tourDetails['itinerary'], true) ?? [];

    // Get tour reviews
    $reviews = $this->tourModel->getTourReviews($id);

    // Get average rating
    $avgRating = 0;
    if (!empty($reviews)) {
      $totalRating = array_sum(array_column($reviews, 'rating'));
      $avgRating = number_format($totalRating / count($reviews), 1);
    }

    // Get available tour dates
    $tourDates = $this->tourModel->getAvailableTourDates($id);

    // Check if user can review
    $canReview = false;
    if (isset($_SESSION['user_id'])) {
      $canReview = $this->tourModel->canUserReviewTour($_SESSION['user_id'], $id);
    }

    $this->view('home/tour-details', [
      'tourDetails' => $tourDetails,
      'itinerary' => $itinerary,
      'reviews' => $reviews,
      'avgRating' => $avgRating,
      'canReview' => $canReview,
      'tourDates' => $tourDates
    ]);
  }

  function bookings($id)
  {
    $tourDetails = $this->tourModel->getTourDetails($id);
    $this->view('home/bookings', ['tourDetails' => $tourDetails]);
  }

  /**
   * Display the booking summary page
   */
  public function summary($tourId)
  {
    // Check if user is logged in
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->setFlashMessage('error', 'Vui lòng đăng nhập để đặt tour');
      $this->redirect(UrlHelper::route('auth/login') . '?redirect=' . urlencode($_SERVER['REQUEST_URI']));
      return;
    }

    // Lấy danh sách phương thức thanh toán từ DB
    $paymentMethods = $this->paymentMethodModel->getAllActive();

    // Get tour details
    $tour = $this->tourModel->getTourDetails($tourId);
    if (!$tour) {
      $this->setFlashMessage('error', 'Tour không tồn tại');
      $this->redirect(UrlHelper::route('home/tours'));
      return;
    }

    // Get URL parameters
    $adults = intval($_GET['adults'] ?? 2);
    $children = intval($_GET['children'] ?? 0);
    $tourDateId = intval($_GET['tour_date_id'] ?? 0);

    // Get tour date details
    $tourDate = null;
    if ($tourDateId) {
      $tourDate = $this->tourModel->getTourDateById($tourDateId);
      if (!$tourDate || $tourDate['status'] !== 'available') {
        $this->setFlashMessage('error', 'Ngày khởi hành không hợp lệ hoặc đã hết chỗ.');
        $this->redirect(UrlHelper::route('home/tours'));
        return;
      }
    }

    // Calculate prices
    $adultPrice = $tourDate['price'] ?? $tour['price'];
    $childPrice = $adultPrice * 0.7; // Child price is 70% of adult price

    $adultTotal = $adults * $adultPrice;
    $childTotal = $children * $childPrice;
    $subtotal = $adultTotal + $childTotal;
    $tax = $subtotal * 0.1; // 10% tax
    $totalAmount = $subtotal + $tax;

    // Pass Stripe publishable key to the view
    $stripePublishableKey = $this->stripeService->getPublishableKey();

    $this->view('home/summary', [
      'tour' => $tour,
      'tourDate' => $tourDate,
      'user' => $currentUser,
      'adults' => $adults,
      'children' => $children,
      'adultPrice' => $adultPrice,
      'childPrice' => $childPrice,
      'adultTotal' => $adultTotal,
      'childTotal' => $childTotal,
      'tax' => $tax,
      'totalAmount' => $totalAmount,
      'stripePublishableKey' => $stripePublishableKey,
      'paymentMethods' => $paymentMethods
    ]);
  }

  /**
   * Xử lý thanh toán lại cho đơn hàng
   * 
   * @param int $bookingId ID của đơn đặt tour
   */
  public function processPayment($bookingId)
  {
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->redirect(UrlHelper::route('auth/login') . '?redirect=' . urlencode($_SERVER['REQUEST_URI']));
      return;
    }

    // Lấy thông tin booking
    $booking = $this->bookingModel->getById($bookingId);

    // Kiểm tra quyền truy cập
    if (!$booking || $booking['user_id'] != $currentUser['id']) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin đặt tour');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    // Kiểm tra trạng thái thanh toán
    if ($booking['payment_status'] === 'paid') {
      $this->setFlashMessage('info', 'Đơn hàng này đã được thanh toán');
      $this->redirect(UrlHelper::route('user/bookings/detail/' . $bookingId));
      return;
    }

    // Lấy thông tin tour và ngày
    $tour = $this->tourModel->getTourDetails($booking['tour_id']);
    $tourDate = $this->tourModel->getTourDateById($booking['tour_date_id']);

    // Lấy hoặc tạo thông tin thanh toán
    $payment = $this->bookingModel->getPaymentByBookingId($bookingId);
    if (!$payment) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin thanh toán');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    // Tạo phiên thanh toán Stripe
    try {
      // Chuẩn bị dữ liệu cho Stripe
      $stripeMetadata = [
        'booking_id' => $booking['id'],
        'booking_number' => $booking['booking_number'],
        'user_id' => $booking['user_id'],
        'tour_id' => $booking['tour_id'],
        'tour_date_id' => $booking['tour_date_id']
      ];

      // Tạo thông tin sản phẩm
      $lineItems = [
        [
          'name' => $tour['title'],
          'description' => "Tour ngày " . date('d/m/Y', strtotime($tourDate['start_date'])) .
            " - Người lớn: {$booking['adults']}, Trẻ em: {$booking['children']}",
          'amount' => $booking['total_price'],
          'currency' => 'vnd',
          'quantity' => 1
        ]
      ];

      // Tạo session Stripe Checkout
      $checkoutSession = $this->stripeService->createCheckoutSession(
        $lineItems,
        $booking['booking_number'],
        $stripeMetadata,
        UrlHelper::getFullUrl('payments/stripe/success/' . $bookingId),
        UrlHelper::getFullUrl('payments/stripe/cancel/' . $bookingId)
      );

      // Cập nhật payment với session id
      $this->bookingModel->updatePayment($payment['id'], [
        'transaction_id' => $checkoutSession->id,
        'payment_data' => json_encode([
          'checkout_session_id' => $checkoutSession->id,
          'checkout_url' => $checkoutSession->url
        ])
      ]);

      // Ghi log payment
      $this->bookingModel->createPaymentLog([
        'payment_id' => $payment['id'],
        'booking_id' => $bookingId,
        'event' => 'checkout_session_created',
        'status' => 'pending',
        'message' => 'Đã tạo phiên thanh toán lại qua Stripe',
        'data' => json_encode([
          'checkout_session_id' => $checkoutSession->id
        ])
      ]);

      // Chuyển hướng đến trang thanh toán Stripe
      $this->redirect($checkoutSession->url);
    } catch (\Exception $e) {
      // Xử lý lỗi
      $this->setFlashMessage('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage());
      $this->bookingModel->createPaymentLog([
        'payment_id' => $payment['id'],
        'booking_id' => $bookingId,
        'event' => 'payment_error',
        'status' => 'error',
        'message' => 'Lỗi tạo phiên thanh toán: ' . $e->getMessage(),
        'data' => json_encode(['error' => $e->getMessage()])
      ]);
      $this->redirect(UrlHelper::route('user/bookings'));
    }
  }

  /**
   * Process booking form submission
   */
  public function process()
  {
    // Check if user is logged in
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->setFlashMessage('error', 'Vui lòng đăng nhập để đặt tour');
      $this->redirect(UrlHelper::route('auth/login'));
      return;
    }

    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      $this->redirect(UrlHelper::route('home'));
      return;
    }

    // Get form data
    $tourId = intval($_POST['tour_id'] ?? 0);
    $tourDateId = intval($_POST['tour_date_id'] ?? 0);
    $adults = intval($_POST['adults'] ?? 0);
    $children = intval($_POST['children'] ?? 0);
    $totalAmount = floatval($_POST['total_amount'] ?? 0);
    $paymentMethod = $_POST['payment_method'] ?? 'bank_transfer';
    $paymentIntentId = $_POST['payment_intent_id'] ?? null;

    // Validate required data
    if (!$tourId || !$tourDateId || $adults < 1 || $totalAmount <= 0) {
      $this->setFlashMessage('error', 'Thiếu thông tin đặt tour. Vui lòng thử lại.');
      die();
      $this->redirect(UrlHelper::route('home/tours'));
      return;
    }

    // Get tour details
    $tour = $this->tourModel->getTourDetails($tourId);
    if (!$tour) {
      $this->setFlashMessage('error', 'Tour không tồn tại');
      $this->redirect(UrlHelper::route('home/tours'));
      return;
    }

    // Get tour date details
    $tourDate = $this->tourModel->getTourDateById($tourDateId);
    if (!$tourDate || $tourDate['status'] !== 'available') {
      $this->setFlashMessage('error', 'Ngày khởi hành không hợp lệ hoặc đã hết chỗ.');
      $this->redirect(UrlHelper::route('home/tours'));
      return;
    }

    // Format passenger data
    $passengersData = [
      'adults' => [],
      'children' => []
    ];

    $adultNames = $_POST['adult_name'] ?? [];
    $adultIds = $_POST['adult_id'] ?? [];
    $adultPassports = $_POST['adult_passport'] ?? [];
    $adultNationalities = $_POST['adult_nationality'] ?? [];
    $adultDobs = $_POST['adult_dob'] ?? [];

    $childNames = $_POST['child_name'] ?? [];
    $childDobs = $_POST['child_dob'] ?? [];
    $childPassports = $_POST['child_passport'] ?? [];
    $childNationalities = $_POST['child_nationality'] ?? [];

    // Xử lý thông tin người lớn
    foreach ($adultNames as $key => $name) {
      if (!empty($name)) {
        $passengersData['adults'][] = [
          'name' => $name,
          'id_number' => $adultIds[$key] ?? '',
          'passport_number' => $adultPassports[$key] ?? '',
          'nationality' => $adultNationalities[$key] ?? '',
          'date_of_birth' => $adultDobs[$key] ?? null
        ];
      }
    }

    // Xử lý thông tin trẻ em
    foreach ($childNames as $key => $name) {
      if (!empty($name)) {
        $passengersData['children'][] = [
          'name' => $name,
          'date_of_birth' => $childDobs[$key] ?? null,
          'passport_number' => $childPassports[$key] ?? '',
          'nationality' => $childNationalities[$key] ?? ''
        ];
      }
    }

    // Validate passenger data
    if (empty($adultNames) || count($adultNames) < $adults) {
      $this->setFlashMessage('error', 'Vui lòng cung cấp đầy đủ thông tin hành khách.');
      $this->redirect(UrlHelper::route('home/bookings/summary/' . $tourId));
      return;
    }

    // Create booking record
    $bookingNumber = 'BK-' . date('ymd') . rand(1000, 9999);
    $bookingData = [
      'booking_number' => $bookingNumber,
      'user_id' => $currentUser['id'] ?? null,
      'tour_id' => $tourId,
      'tour_date_id' => $tourDateId,
      'adults' => $adults,
      'children' => $children,
      'total_price' => $totalAmount,
      'status' => 'pending', // Luôn bắt đầu ở trạng thái pending
      'payment_method' => $paymentMethod,
      'payment_status' => 'pending', // Luôn bắt đầu ở trạng thái pending
      'special_requirements' => $_POST['special_requests'] ?? null
    ];

    // Insert booking into database
    $bookingId = $this->bookingModel->create($bookingData);

    if (!$bookingId) {
      $this->setFlashMessage('error', 'Không thể tạo đơn đặt tour. Vui lòng thử lại.');
      $this->redirect(UrlHelper::route('home/tours'));
      return;
    }

    // Save passengers to booking_customers table
    foreach ($passengersData['adults'] as $adult) {
      $this->bookingModel->addPassenger([
        'booking_id' => $bookingId,
        'full_name' => $adult['name'],
        'type' => 'adult',
        'passport_number' => $adult['passport_number'] ?? null,
        'nationality' => $adult['nationality'] ?? null,
        'date_of_birth' => $adult['date_of_birth'] ?? null
      ]);
    }

    foreach ($passengersData['children'] as $child) {
      $this->bookingModel->addPassenger([
        'booking_id' => $bookingId,
        'full_name' => $child['name'],
        'type' => 'child',
        'date_of_birth' => $child['date_of_birth'] ?? null,
        'passport_number' => $child['passport_number'] ?? null,
        'nationality' => $child['nationality'] ?? null
      ]);
    }

    // Update available seats
    $this->tourModel->updateTourDate($tourDateId, [
      'available_seats' => $tourDate['available_seats'] - ($adults + $children)
    ]);

    $paymentMethodId = $this->paymentMethodModel->getByCode($paymentMethod)['id'];
    $paymentData = [
      'booking_id' => $bookingId,
      'payment_method_id' => $paymentMethodId,
      'amount' => $totalAmount,
      'currency' => 'VND',
      'status' => 'pending',
      'payer_name' => $_POST['fullname'] ?? $currentUser['full_name'],
      'payer_email' => $_POST['email'] ?? $currentUser['email'],
      'payer_phone' => $_POST['phone'] ?? $currentUser['phone']
    ];

    // Tạo record payment
    $paymentId = $this->bookingModel->createPayment($paymentData);

    if (!$paymentId) {
      // Log lỗi
      $this->setFlashMessage('error', 'Có lỗi xảy ra khi xử lý thanh toán. Vui lòng liên hệ hỗ trợ.');
      // $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }
    // Process based on payment method
    switch ($paymentMethod) {
      case 'stripe':
        try {
          // Chuẩn bị dữ liệu cho Stripe
          $stripeMetadata = [
            'booking_id' => $bookingId,
            'booking_number' => $bookingNumber,
            'user_id' => $currentUser['id'] ?? null,
            'tour_id' => $tourId,
            'tour_date_id' => $tourDateId
          ];

          // Tạo thông tin sản phẩm
          $lineItems = [
            [
              'name' => $tour['title'],
              'description' => "Tour ngày " . date('d/m/Y', strtotime($tourDate['start_date'])) .
                " - Người lớn: $adults, Trẻ em: $children",
              'amount' => $totalAmount,
              'currency' => 'vnd',
              'quantity' => 1
            ]
          ];

          // Tạo session Stripe Checkout
          $checkoutSession = $this->stripeService->createCheckoutSession(
            $lineItems,
            $bookingNumber,
            $stripeMetadata,
            UrlHelper::getFullUrl('payments/stripe/success/' . $bookingId),
            UrlHelper::getFullUrl('payments/stripe/cancel/' . $bookingId)
          );

          // Cập nhật payment với session id
          $this->bookingModel->updatePayment($paymentId, [
            'transaction_id' => $checkoutSession->id,
            'payment_data' => json_encode([
              'checkout_session_id' => $checkoutSession->id,
              'checkout_url' => $checkoutSession->url
            ])
          ]);

          // Ghi log payment
          $this->bookingModel->createPaymentLog([
            'payment_id' => $paymentId,
            'booking_id' => $bookingId,
            'event' => 'checkout_session_created',
            'status' => 'pending',
            'message' => 'Đã tạo phiên thanh toán Stripe',
            'data' => json_encode([
              'checkout_session_id' => $checkoutSession->id
            ])
          ]);

          // Chuyển hướng đến trang thanh toán Stripe
          $this->redirect($checkoutSession->url);
        } catch (\Exception $e) {
          // Xử lý lỗi (giữ nguyên phần này)
          $this->setFlashMessage('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage());
          $this->bookingModel->createPaymentLog([
            'payment_id' => $paymentId,
            'booking_id' => $bookingId,
            'event' => 'payment_error',
            'status' => 'error',
            'message' => 'Lỗi tạo phiên thanh toán: ' . $e->getMessage(),
            'data' => json_encode(['error' => $e->getMessage()])
          ]);
          $this->redirect(UrlHelper::route('user/bookings'));
        }
        break;
      case 'bank_transfer':
        $this->setFlashMessage('error', 'Phương thức thanh toán chuyển khoản ngân hàng hiện không khả dụng. Vui lòng chọn phương thức khác.');
        $this->redirect(UrlHelper::route('home/bookings/bank-transfer/' . $bookingId));
        break;
      case 'cash':
        $this->setFlashMessage('success', 'Đặt tour thành công! Vui lòng thanh toán khi bắt đầu tour.');
        $this->redirect(UrlHelper::route('user/bookings'));
        break;
      case 'vnpay':
        // Xử lý thanh toán VNPay
        $this->redirect(UrlHelper::route('payments/vnpay/process/' . $bookingId));
        break;
      case 'momo':
        // Xử lý thanh toán MoMo
        $this->redirect(UrlHelper::route('payments/momo/process/' . $bookingId));
        break;
      case 'paypal':
        // Xử lý thanh toán PayPal
        $this->redirect(UrlHelper::route('payments/paypal/process/' . $bookingId));
        break;
      default:
        $this->setFlashMessage('success', 'Đặt tour thành công! Vui lòng thanh toán theo phương thức bạn đã chọn.');
        $this->redirect(UrlHelper::route('user/bookings'));
        break;
    }
  }

  /**
   * Show bank transfer instructions
   */
  public function bankTransfer($id)
  {
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->redirect(UrlHelper::route('auth/login'));
      return;
    }

    $booking = $this->bookingModel->getById($id);

    if (!$booking || $booking['user_id'] != $currentUser['id']) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin đặt tour');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    $tour = $this->tourModel->getTourDetails($booking['tour_id']);
    $tourDate = $this->tourModel->getTourDateById($booking['tour_date_id']);

    $this->view('home/bank-transfer', [
      'booking' => $booking,
      'tour' => $tour,
      'tourDate' => $tourDate,
      'user' => $currentUser
    ]);
  }

  /**
   * Xử lý khi thanh toán Stripe thành công
   */
  public function stripeSuccess($bookingId)
  {
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->redirect(UrlHelper::route('auth/login'));
      return;
    }

    // Lấy thông tin booking
    $booking = $this->bookingModel->getById($bookingId);
    if (!$booking || $booking['user_id'] != $currentUser['id']) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin đặt tour');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    // Lấy thông tin payment
    $payment = $this->bookingModel->getPaymentByBookingId($bookingId);
    if (!$payment || $payment['status'] !== 'pending') {
      $this->setFlashMessage('info', 'Thanh toán đã được xử lý trước đó');
      $this->redirect(UrlHelper::route('user/bookings/detail/' . $bookingId));
      return;
    }

    // Lấy session_id từ Stripe
    $session_id = $payment['transaction_id'];
    if (!$session_id) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin phiên thanh toán');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    try {
      // Kiểm tra trạng thái thanh toán từ Stripe
      $sessionResponse = $this->stripeService->retrieveSession($session_id);

      // Kiểm tra xem phản hồi có thành công không
      if ($sessionResponse && isset($sessionResponse->payment_status) && $sessionResponse->payment_status === 'paid') {
        // Cập nhật trạng thái booking
        $this->bookingModel->update($bookingId, [
          'status' => 'confirmed',
          'payment_status' => 'paid'
        ]);

        // // Cập nhật trạng thái payment
        // $this->bookingModel->updatePayment($payment['id'], [
        //   'status' => 'completed',
        //   'transaction_id_internal' => $sessionResponse->payment_intent,
        //   'payment_date' => date('Y-m-d H:i:s')
        // ]);

        $this->bookingModel->updatePayment($payment['id'], [
          'status' => 'completed',
          'transaction_id' => $sessionResponse->payment_intent, // Lưu payment_intent vào transaction_id (VARCHAR)
          'payment_date' => date('Y-m-d H:i:s')
        ]);

        // Ghi log thanh toán thành công
        $this->bookingModel->createPaymentLog([
          'payment_id' => $payment['id'],
          'booking_id' => $bookingId,
          'event' => 'paid', // Rút gọn để tránh lỗi nếu trường này có giới hạn kích thước
          'status' => 'done', // Rút gọn để tránh lỗi nếu trường này có giới hạn kích thước
          'message' => 'Thanh toán hoàn tất qua Stripe',
          'data' => json_encode([
            'session_id' => $session_id,
            'payment_intent' => $sessionResponse->payment_intent
          ])
        ]);

        // Lấy thông tin tour và customer
        $tour = $this->tourModel->getTourDetails($booking['tour_id']);
        $tourDate = $this->tourModel->getTourDateById($booking['tour_date_id']);

        // Hiển thị trang thành công
        $this->view('home/stripe-success', [
          'booking' => $booking,
          'payment' => $payment,
          'tour' => $tour,
          'tourDate' => $tourDate
        ]);
      } else {
        throw new \Exception('Phiên thanh toán chưa được hoàn tất');
      }
    } catch (\Exception $e) {
      $this->setFlashMessage('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage());
      $this->redirect(UrlHelper::route('user/bookings'));
    }
  }

  /**
   * Xử lý khi thanh toán Stripe bị hủy
   */
  public function stripeCancel($bookingId)
  {
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->redirect(UrlHelper::route('auth/login'));
      return;
    }

    // Lấy thông tin booking
    $booking = $this->bookingModel->getById($bookingId);
    if (!$booking || $booking['user_id'] != $currentUser['id']) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin đặt tour');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    // Lấy thông tin payment
    $payment = $this->bookingModel->getPaymentByBookingId($bookingId);

    // Ghi log hủy thanh toán
    if ($payment) {
      $this->bookingModel->createPaymentLog([
        'payment_id' => $payment['id'],
        'booking_id' => $bookingId,
        'event' => 'payment_cancelled',
        'status' => 'cancelled',
        'message' => 'Người dùng hủy thanh toán Stripe',
        'data' => json_encode([
          'transaction_id' => $payment['transaction_id']
        ])
      ]);
    }

    // Lấy thông tin tour
    $tour = $this->tourModel->getTourDetails($booking['tour_id']);
    $tourDate = $this->tourModel->getTourDateById($booking['tour_date_id']);

    // Hiển thị trang hủy thanh toán
    $this->view('home/stripe-cancel', [
      'booking' => $booking,
      'payment' => $payment,
      'tour' => $tour,
      'tourDate' => $tourDate
    ]);
  }

  /**
   * Hiển thị chi tiết đặt tour
   * 
   * @param int $bookingId ID của đặt tour
   */
  public function bookingDetail($bookingId)
  {
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->redirect(UrlHelper::route('auth/login'));
      return;
    }

    // Lấy thông tin đặt tour
    $booking = $this->bookingModel->getById($bookingId);
    if (!$booking || $booking['user_id'] != $currentUser['id']) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin đặt tour');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    // Lấy thông tin tour và ngày khởi hành
    $tour = $this->tourModel->getTourDetails($booking['tour_id']);
    $tourDate = $this->tourModel->getTourDateById($booking['tour_date_id']);

    // Lấy thông tin hành khách
    $passengers = $this->bookingModel->getBookingPassengers($bookingId);

    // Lấy thông tin thanh toán
    $payment = $this->bookingModel->getPaymentByBookingId($bookingId);

    // Lấy lịch sử thanh toán
    $paymentLogs = $this->bookingModel->getPaymentLogs($bookingId);

    $this->view('home/booking-detail', [
      'booking' => $booking,
      'tour' => $tour,
      'tourDate' => $tourDate,
      'passengers' => $passengers,
      'payment' => $payment,
      'paymentLogs' => $paymentLogs
    ]);
  }

  /**
   * Xử lý yêu cầu hủy đặt tour
   * 
   * @param int $bookingId ID của đặt tour
   */
  public function cancelBooking($bookingId)
  {
    $currentUser = $this->getCurrentUser();
    if (!$currentUser) {
      $this->redirect(UrlHelper::route('auth/login'));
      return;
    }

    // Lấy thông tin đặt tour
    $booking = $this->bookingModel->getById($bookingId);
    if (!$booking || $booking['user_id'] != $currentUser['id']) {
      $this->setFlashMessage('error', 'Không tìm thấy thông tin đặt tour');
      $this->redirect(UrlHelper::route('user/bookings'));
      return;
    }

    // Kiểm tra nếu đơn đã bị hủy trước đó
    if ($booking['status'] === 'cancelled') {
      $this->setFlashMessage('info', 'Đơn đặt tour này đã được hủy trước đó');
      $this->redirect(UrlHelper::route('user/bookings/detail/' . $bookingId));
      return;
    }

    // Kiểm tra nếu tour đã diễn ra
    $tourDate = $this->tourModel->getTourDateById($booking['tour_date_id']);
    if (strtotime($tourDate['start_date']) <= time()) {
      $this->setFlashMessage('error', 'Không thể hủy tour đã bắt đầu hoặc đã kết thúc');
      $this->redirect(UrlHelper::route('user/bookings/detail/' . $bookingId));
      return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $reason = $_POST['cancel_reason'] ?? '';
      $notes = $_POST['cancel_notes'] ?? '';

      // Ghi nhận lý do hủy
      $cancellationData = [
        'reason' => $reason,
        'notes' => $notes,
        'cancelled_at' => date('Y-m-d H:i:s')
      ];

      // Cập nhật trạng thái booking
      $updated = $this->bookingModel->update($bookingId, [
        'status' => 'cancelled',
        'cancellation_data' => json_encode($cancellationData)
      ]);

      if ($updated) {
        // Cập nhật số chỗ ngồi có sẵn của tour
        $this->tourModel->updateTourDate($booking['tour_date_id'], [
          'available_seats' => $tourDate['available_seats'] + ($booking['adults'] + $booking['children'])
        ]);

        // Xử lý hoàn tiền nếu đã thanh toán
        if ($booking['payment_status'] === 'paid') {
          // Tính phí hủy dựa vào thời gian đến ngày tour
          $daysUntilTour = floor((strtotime($tourDate['start_date']) - time()) / (60 * 60 * 24));
          $refundPercent = $this->calculateRefundPercent($daysUntilTour);

          $payment = $this->bookingModel->getPaymentByBookingId($bookingId);
          if ($payment) {
            $refundAmount = $booking['total_price'] * ($refundPercent / 100);

            // Cập nhật payment
            $this->bookingModel->updatePayment($payment['id'], [
              'status' => 'pending',
              'notes' => "Hoàn tiền {$refundPercent}% = " . number_format($refundAmount) . " VND"
            ]);

            // Ghi log hoàn tiền
            $this->bookingModel->createPaymentLog([
              'payment_id' => $payment['id'],
              'booking_id' => $bookingId,
              'event' => 'refund_request',
              'status' => 'pending',
              'message' => "Yêu cầu hoàn tiền {$refundPercent}% do hủy tour",
              'data' => json_encode([
                'refund_percent' => $refundPercent,
                'refund_amount' => $refundAmount,
                'reason' => $reason,
                'notes' => $notes
              ])
            ]);
          }
        }

        $this->setFlashMessage('success', 'Yêu cầu hủy đặt tour đã được ghi nhận thành công');
      } else {
        $this->setFlashMessage('error', 'Có lỗi xảy ra khi hủy đặt tour. Vui lòng thử lại');
      }

      $this->redirect(UrlHelper::route('user/bookings/detail/' . $bookingId));
      return;
    }

    // Lấy thông tin tour
    $tour = $this->tourModel->getTourDetails($booking['tour_id']);

    // Hiển thị form xác nhận hủy tour
    $this->view('home/cancel-booking', [
      'booking' => $booking,
      'tour' => $tour,
      'tourDate' => $tourDate
    ]);
  }

  /**
   * Tính phần trăm hoàn tiền dựa vào thời gian đến ngày khởi hành
   * 
   * @param int $daysUntilTour Số ngày còn lại cho đến ngày khởi hành
   * @return int Phần trăm hoàn tiền
   */
  private function calculateRefundPercent($daysUntilTour)
  {
    // Chính sách hoàn tiền:
    // - Hủy trước 30 ngày: hoàn 90%
    // - Hủy trước 15-29 ngày: hoàn 70%
    // - Hủy trước 7-14 ngày: hoàn 50%
    // - Hủy trước 3-6 ngày: hoàn 30%
    // - Hủy trước 1-2 ngày: hoàn 10%
    // - Hủy trong ngày tour: không hoàn tiền

    if ($daysUntilTour >= 30) {
      return 90;
    } elseif ($daysUntilTour >= 15) {
      return 70;
    } elseif ($daysUntilTour >= 7) {
      return 50;
    } elseif ($daysUntilTour >= 3) {
      return 30;
    } elseif ($daysUntilTour >= 1) {
      return 10;
    } else {
      return 0;
    }
  }
}
