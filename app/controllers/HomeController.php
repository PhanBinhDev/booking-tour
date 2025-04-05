<?php

namespace App\Controllers;

use App\Helpers\UrlHelper;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\Contact;
use App\Models\Categories;
use App\Models\Location;
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
  }
  function index()
  {
    $categories = $this->categoriesModel->getAll();
    $locations = $this->locationModel->getAll();
    $currentDate = date('Y-m-d');

    $join = [
      "JOIN tour_categories ON tour_categories.id = tours.category_id",
      "JOIN locations ON locations.id = tours.location_id",
      "LEFT JOIN (
      SELECT tour_id, AVG(rating) as avg_rating, COUNT(*) as review_count 
      FROM tour_reviews 
      GROUP BY tour_id
      ) as tr ON tr.tour_id = tours.id",
      "LEFT JOIN tour_dates ON tour_dates.tour_id = tours.id",
      "LEFT JOIN (SELECT tour_id, image_id FROM tour_images WHERE is_featured = 1) AS tour_images ON tour_images.tour_id = tours.id",
      "LEFT JOIN images ON tour_images.image_id = images.id"
    ];

    $conditions = ["tours.status" => "active", "tours.sale_price" => "> 0"];

    $columns = "tours.id, tours.description, 
              tour_images.tour_id, tour_images.image_id,
              images.cloudinary_url,
              tr.avg_rating, 
              tr.review_count,
              tours.title, tours.price, tours.duration, tours.sale_price,
              MIN(CASE WHEN tour_dates.start_date >= '$currentDate' THEN tour_dates.start_date ELSE NULL END) as next_start_date,
              MIN(CASE WHEN tour_dates.end_date >= '$currentDate' THEN tour_dates.end_date ELSE NULL END) as next_end_date,
              COUNT(DISTINCT tour_dates.id) as date_count,
              GROUP_CONCAT(DISTINCT CONCAT(tour_dates.start_date, '|', tour_dates.end_date) ORDER BY tour_dates.start_date) as all_dates,
              tour_categories.name AS category_name, 
              locations.name AS location_name";

    $orderBy = 'tours.id DESC';
    $groupBy =  "GROUP BY tours.id,tour_images.tour_id, tour_images.image_id, images.cloudinary_url, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name";

    $groupBy =  "GROUP BY tours.id,tour_images.tour_id, tour_images.image_id, images.cloudinary_url, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name";


    $allTours = $this->tourModel->getAll(
      $columns,
      $conditions,
      $orderBy,
      8,
      null,
      $join,
      $groupBy
    );

    $condition = ["tours.status" => "active", "tours.featured" => "1"];

    $allFeaturedTours = $this->tourModel->getAll(
      $columns,
      $condition,
      $orderBy,
      3,
      null,
      $join,
      $groupBy
    );

    $newsColumns = 'id, title, summary, featured_image, created_at';
    $newsConditions = ['featured' => 1];

    $news = $this->newsModel->getAll($newsColumns, $newsConditions, null, 3);

    $this->view('home/index', [
      'allTours' => $allTours,
      'categories' => $categories,
      'allFeaturedTours' => $allFeaturedTours,
      'news' => $news,
      'locations' => $locations
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

  public function news()
  {
    $newsList = $this->newsModel->getAllNews();

    // echo "<pre>";
    // print_r($newsList);
    // echo "</pre>";
    // die();
    $getActiveCategories = $this->newsModel->getActiveCategories();

    // Lấy 3 bài viết có lượt xem cao nhất
    $topViewedNews = $this->newsModel->getTopViewedNews(3);

    // Lấy 1 bài viết nổi bật (featured = 1) được tạo sớm nhất
    $featuredNews = $this->newsModel->getOldestFeaturedNews();

    $this->view('home/news', [
      'newsList' => $newsList,
      'getActiveCategories' => $getActiveCategories,
      'topViewedNews' => $topViewedNews,
      'featuredNews' => $featuredNews
    ]);
  }

  function newsDetail($id)
  {
    $news = $this->newsModel->getById($id);
    $topViewedNews = $this->newsModel->getTopViewedNews(3);
    var_dump($news);
    $this->view('home/news-detail', [
      'news' => $news,
      'topViewedNews' => $topViewedNews
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

  function tours()
  {
    $categories = $this->categoriesModel->getAll();
    $currentDate = date('Y-m-d');

    $category_id = isset($_GET['category']) && $_GET['category'] !== 'Tất cả danh mục' ?
      filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT) : null;
    $location_id = isset($_GET['location']) && $_GET['location'] !== 'Tất cả địa điểm' ?
      filter_input(INPUT_GET, 'location', FILTER_VALIDATE_INT) : null;
    $sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'popular';
    $price_ranges = isset($_GET['price_range']) ? $_GET['price_range'] : [];
    $durations = isset($_GET['duration']) ? $_GET['duration'] : [];
    $ratings = isset($_GET['rating']) ? $_GET['rating'] : [];

    $join = [
      "JOIN tour_categories ON tour_categories.id = tours.category_id",
      "JOIN locations ON locations.id = tours.location_id",
      "LEFT JOIN (
      SELECT tour_id, AVG(rating) as avg_rating, COUNT(*) as review_count 
      FROM tour_reviews 
      GROUP BY tour_id
      ) as tr ON tr.tour_id = tours.id",
      "LEFT JOIN tour_dates ON tour_dates.tour_id = tours.id",
      "LEFT JOIN (SELECT tour_id, image_id FROM tour_images WHERE is_featured = 1) AS tour_images ON tour_images.tour_id = tours.id",
      "LEFT JOIN images ON tour_images.image_id = images.id"
    ];

    $conditions = ["tours.status" => "active"];

    if ($category_id) {
      $conditions["tours.category_id"] = $category_id;
    }

    if ($location_id) {
      $conditions["tours.location_id"] = $location_id;
    }


    $columns = "tours.id, tour_images.tour_id, tour_images.image_id,
            images.cloudinary_url,
            tr.avg_rating, 
            tr.review_count,
            tours.title, tours.price, tours.duration, tours.sale_price,
            MIN(CASE WHEN tour_dates.start_date >= '$currentDate' THEN tour_dates.start_date ELSE NULL END) as next_start_date,
            MIN(CASE WHEN tour_dates.end_date >= '$currentDate' THEN tour_dates.end_date ELSE NULL END) as next_end_date,
            COUNT(DISTINCT tour_dates.id) as date_count,
            GROUP_CONCAT(DISTINCT CONCAT(tour_dates.start_date, '|', tour_dates.end_date) ORDER BY tour_dates.start_date) as all_dates,
            tour_categories.name AS category_name, 
            locations.name AS location_name";

    $orderBy = 'tours.id DESC';
    switch ($sort_option) {
      case 'popular':
        $orderBy = 'tr.review_count DESC, tr.avg_rating DESC';
        break;
      case 'price_asc':
        $orderBy = 'CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END ASC';
        break;
      case 'price_desc':
        $orderBy = 'CASE WHEN tours.sale_price > 0 THEN tours.sale_price ELSE tours.price END DESC';
        break;
      case 'rating':
        $orderBy = 'tr.avg_rating DESC, tr.review_count DESC';
        break;
    }
    $groupBy =  "GROUP BY tours.id,tour_images.tour_id, tour_images.image_id,images.cloudinary_url, tr.avg_rating, tr.review_count, tours.title, tours.price, tours.duration, tours.sale_price, tour_categories.name, locations.name";


    $allTours = $this->tourModel->getAll(
      $columns,
      $conditions,
      $orderBy,
      null,
      null,
      $join,
      $groupBy
    );

    $this->view('home/tours', [
      'allTours' => $allTours,
      'categories' => $categories,
      'currentCategory' => $category_id,
      'selectedSort' => $sort_option,
      'selectedPriceRanges' => $price_ranges,
      'selectedDurations' => $durations,
      'selectedRatings' => $ratings
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
      var_dump($e->getMessage());
      die();
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
