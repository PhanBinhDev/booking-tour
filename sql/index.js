const { faker } = require('@faker-js/faker/locale/vi')
const fs = require('fs')

// Cấu hình để tạo dữ liệu tiếng Việt
faker.locale = 'vi'

// Tạo dữ liệu cho bảng roles
const roles = [
  {
    id: 1,
    name: 'admin',
    description: 'Quản trị viên hệ thống, có tất cả quyền hạn'
  },
  {
    id: 2,
    name: 'moderator',
    description: 'Quản lý nội dung, duyệt bài và thông tin tour'
  },
  {
    id: 3,
    name: 'user',
    description: 'Người dùng thông thường, có thể đặt tour và xem thông tin'
  }
]

// Tạo dữ liệu cho bảng permissions
const permissions = [
  {
    id: 1,
    name: 'user_view',
    description: 'Xem thông tin người dùng',
    category: 'user'
  },
  {
    id: 2,
    name: 'user_create',
    description: 'Tạo người dùng mới',
    category: 'user'
  },
  {
    id: 3,
    name: 'user_edit',
    description: 'Chỉnh sửa thông tin người dùng',
    category: 'user'
  },
  {
    id: 4,
    name: 'user_delete',
    description: 'Xóa người dùng',
    category: 'user'
  },
  {
    id: 5,
    name: 'tour_view',
    description: 'Xem thông tin tour',
    category: 'tour'
  },
  { id: 6, name: 'tour_create', description: 'Tạo tour mới', category: 'tour' },
  {
    id: 7,
    name: 'tour_edit',
    description: 'Chỉnh sửa thông tin tour',
    category: 'tour'
  },
  { id: 8, name: 'tour_delete', description: 'Xóa tour', category: 'tour' },
  {
    id: 9,
    name: 'booking_view',
    description: 'Xem thông tin đặt tour',
    category: 'booking'
  },
  {
    id: 10,
    name: 'booking_create',
    description: 'Tạo đặt tour mới',
    category: 'booking'
  },
  {
    id: 11,
    name: 'booking_edit',
    description: 'Chỉnh sửa thông tin đặt tour',
    category: 'booking'
  },
  {
    id: 12,
    name: 'booking_delete',
    description: 'Xóa đặt tour',
    category: 'booking'
  },
  { id: 13, name: 'news_view', description: 'Xem tin tức', category: 'news' },
  {
    id: 14,
    name: 'news_create',
    description: 'Tạo tin tức mới',
    category: 'news'
  },
  {
    id: 15,
    name: 'news_edit',
    description: 'Chỉnh sửa tin tức',
    category: 'news'
  },
  { id: 16, name: 'news_delete', description: 'Xóa tin tức', category: 'news' },
  {
    id: 17,
    name: 'review_approve',
    description: 'Duyệt đánh giá',
    category: 'review'
  },
  {
    id: 18,
    name: 'settings_edit',
    description: 'Cấu hình hệ thống',
    category: 'settings'
  }
]

// Tạo dữ liệu cho bảng role_permissions
const rolePermissions = [
  // Admin có tất cả quyền
  ...permissions.map((permission) => ({
    role_id: 1,
    permission_id: permission.id
  })),

  // Moderator có quyền xem người dùng, quản lý tour, xem booking, quản lý tin tức, duyệt đánh giá
  { role_id: 2, permission_id: 1 }, // user_view
  { role_id: 2, permission_id: 5 }, // tour_view
  { role_id: 2, permission_id: 6 }, // tour_create
  { role_id: 2, permission_id: 7 }, // tour_edit
  { role_id: 2, permission_id: 9 }, // booking_view
  { role_id: 2, permission_id: 13 }, // news_view
  { role_id: 2, permission_id: 14 }, // news_create
  { role_id: 2, permission_id: 15 }, // news_edit
  { role_id: 2, permission_id: 17 }, // review_approve

  // User chỉ có quyền xem tour, đặt tour, xem tin tức
  { role_id: 3, permission_id: 5 }, // tour_view
  { role_id: 3, permission_id: 10 }, // booking_create
  { role_id: 3, permission_id: 13 } // news_view
]

// Tạo dữ liệu mẫu cho bảng users
const users = [
  // Admin
  {
    id: 1,
    username: 'admin',
    email: 'admin@dulichviet.com',
    password: '$2a$10$xJwpX5E2iG7fzLlJT0WFpuZGKw/0Xm/k7qXdqFoBkizCwPEuJfEgW', // "password123"
    full_name: 'Nguyễn Quản Trị',
    phone: '0987654321',
    address: 'Số 123 Đường Lê Lợi, Quận 1, TP.HCM',
    avatar:
      'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?w=150&h=150&fit=crop',
    role_id: 1,
    status: 'active',
    email_verified: true,
    last_login: '2023-06-15 08:30:00'
  },
  // Moderator
  {
    id: 2,
    username: 'moderator',
    email: 'mod@dulichviet.com',
    password: '$2a$10$xJwpX5E2iG7fzLlJT0WFpuZGKw/0Xm/k7qXdqFoBkizCwPEuJfEgW', // "password123"
    full_name: 'Trần Kiểm Duyệt',
    phone: '0976543210',
    address: 'Số 45 Đường Nguyễn Huệ, Quận 1, TP.HCM',
    avatar:
      'https://images.unsplash.com/photo-1557862921-37829c790f19?w=150&h=150&fit=crop',
    role_id: 2,
    status: 'active',
    email_verified: true,
    last_login: '2023-06-14 14:45:00'
  }
]

// Ảnh đại diện từ Unsplash
const avatarImages = [
  'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1633332755192-727a05c4013d?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=150&h=150&fit=crop',
  'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=150&h=150&fit=crop'
]

// Tạo thêm 10 người dùng thông thường
for (let i = 3; i <= 12; i++) {
  const gender = faker.person.sex()
  const firstName = faker.person.firstName(gender)
  const lastName = faker.person.lastName(gender)
  const fullName = `${lastName} ${firstName}`

  users.push({
    id: i,
    username: faker.internet.userName({ firstName, lastName }).toLowerCase(),
    email: faker.internet.email({ firstName, lastName }).toLowerCase(),
    password: '$2a$10$xJwpX5E2iG7fzLlJT0WFpuZGKw/0Xm/k7qXdqFoBkizCwPEuJfEgW', // "password123"
    full_name: fullName,
    phone: faker.phone.number('09########'),
    address: `${faker.location.streetAddress()}, ${faker.location.city()}`,
    avatar: avatarImages[i % avatarImages.length],
    role_id: 3,
    status: 'active',
    email_verified: faker.datatype.boolean(),
    last_login: faker.date
      .recent({ days: 30 })
      .toISOString()
      .slice(0, 19)
      .replace('T', ' ')
  }) // Closing brace for the loop that adds users
}

// Tạo dữ liệu cho bảng user_profiles
const userProfiles = users.map((user) => {
  const gender =
    user.id % 3 === 0 ? 'female' : user.id % 3 === 1 ? 'male' : 'other'
  return {
    user_id: user.id,
    bio:
      user.id <= 2
        ? `Chuyên gia du lịch với nhiều năm kinh nghiệm`
        : `Yêu thích khám phá những điểm đến mới`,
    date_of_birth: faker.date
      .birthdate({ min: 18, max: 65, mode: 'age' })
      .toISOString()
      .split('T')[0],
    gender: gender,
    website: user.id <= 2 ? 'https://dulichviet.com' : null,
    facebook: faker.internet.userName(),
    twitter: faker.internet.userName(),
    instagram: faker.internet.userName(),
    preferences: JSON.stringify({
      notification_email: true,
      notification_sms: false,
      preferred_categories: [1, 3, 5]
    })
  }
})

// Tạo dữ liệu cho bảng tour_categories
const tourCategories = [
  {
    id: 1,
    name: 'Tour Biển',
    slug: 'tour-bien',
    description: 'Các tour du lịch biển đảo tuyệt đẹp',
    image:
      'https://images.unsplash.com/photo-1540202404-a2f29016b523?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 2,
    name: 'Tour Núi',
    slug: 'tour-nui',
    description: 'Khám phá vẻ đẹp của núi rừng Việt Nam',
    image:
      'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 3,
    name: 'Tour Văn Hóa',
    slug: 'tour-van-hoa',
    description: 'Khám phá văn hóa bản địa đặc sắc',
    image:
      'https://images.unsplash.com/photo-1528127269322-539801943592?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 4,
    name: 'Tour Ẩm Thực',
    slug: 'tour-am-thuc',
    description: 'Trải nghiệm ẩm thực đặc sản vùng miền',
    image:
      'https://images.unsplash.com/photo-1511690656952-34342bb7c2f2?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 5,
    name: 'Tour Miền Bắc',
    slug: 'tour-mien-bac',
    description: 'Khám phá vẻ đẹp của miền Bắc Việt Nam',
    image:
      'https://images.unsplash.com/photo-1528127269322-539801943592?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 6,
    name: 'Tour Miền Trung',
    slug: 'tour-mien-trung',
    description: 'Khám phá vẻ đẹp của miền Trung Việt Nam',
    image:
      'https://images.unsplash.com/photo-1559628233-100c798642d4?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 7,
    name: 'Tour Miền Nam',
    slug: 'tour-mien-nam',
    description: 'Khám phá vẻ đẹp của miền Nam Việt Nam',
    image:
      'https://images.unsplash.com/photo-1583417319070-4a69db38a482?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 8,
    name: 'Tour Tâm Linh',
    slug: 'tour-tam-linh',
    description: 'Hành trình tới các địa điểm tâm linh nổi tiếng',
    image:
      'https://images.unsplash.com/photo-1518562180175-34a163b1a9a6?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  }
]

// Tạo dữ liệu cho bảng locations với nhiều địa điểm hơn và ảnh thật
const locations = [
  {
    id: 1,
    name: 'Hà Nội',
    slug: 'ha-noi',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 21.0285,
    longitude: 105.8542,
    image:
      'https://images.unsplash.com/photo-1509030450996-04d5c6bbb887?w=800&h=600&fit=crop',
    description:
      'Thủ đô ngàn năm văn hiến với nhiều di tích lịch sử và văn hóa',
    status: 'active'
  },
  {
    id: 2,
    name: 'Hạ Long',
    slug: 'ha-long',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 20.9595,
    longitude: 107.0477,
    image:
      'https://images.unsplash.com/photo-1573270689103-d7a4e42b609a?w=800&h=600&fit=crop',
    description:
      'Vịnh Hạ Long - Kỳ quan thiên nhiên thế giới với hàng nghìn hòn đảo đá vôi',
    status: 'active'
  },
  {
    id: 3,
    name: 'Sa Pa',
    slug: 'sa-pa',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 22.3364,
    longitude: 103.8438,
    image:
      'https://images.unsplash.com/photo-1577948000111-9c970dfe3743?w=800&h=600&fit=crop',
    description:
      'Thị trấn trong sương với ruộng bậc thang và văn hóa dân tộc đặc sắc',
    status: 'active'
  },
  {
    id: 4,
    name: 'Huế',
    slug: 'hue',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 16.4678,
    longitude: 107.5957,
    image:
      'https://images.unsplash.com/photo-1558159264-4e3ee3ed5de3?w=800&h=600&fit=crop',
    description:
      'Cố đô Huế với hệ thống di tích cung đình và ẩm thực cung đình tinh tế',
    status: 'active'
  },
  {
    id: 5,
    name: 'Đà Nẵng',
    slug: 'da-nang',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 16.0544,
    longitude: 108.2022,
    image:
      'https://images.unsplash.com/photo-1559628233-eb1b1a45564b?w=800&h=600&fit=crop',
    description:
      'Thành phố đáng sống với bãi biển đẹp, cầu Rồng và núi Ngũ Hành Sơn',
    status: 'active'
  },
  {
    id: 6,
    name: 'Hội An',
    slug: 'hoi-an',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 15.8801,
    longitude: 108.338,
    image:
      'https://images.unsplash.com/photo-1540300587943-5e9a6d2de6cc?w=800&h=600&fit=crop',
    description: 'Phố cổ Hội An với kiến trúc cổ và đèn lồng rực rỡ',
    status: 'active'
  },
  {
    id: 7,
    name: 'Nha Trang',
    slug: 'nha-trang',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 12.2388,
    longitude: 109.1968,
    image:
      'https://images.unsplash.com/photo-1575986767340-5d17ae767ab0?w=800&h=600&fit=crop',
    description: 'Thành phố biển với bãi cát trắng và nhiều hoạt động giải trí',
    status: 'active'
  },
  {
    id: 8,
    name: 'Đà Lạt',
    slug: 'da-lat',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 11.9404,
    longitude: 108.4583,
    image:
      'https://images.unsplash.com/photo-1558189757-2a9c2aaf4033?w=800&h=600&fit=crop',
    description: 'Thành phố ngàn hoa với khí hậu mát mẻ quanh năm',
    status: 'active'
  },
  {
    id: 9,
    name: 'Tp. Hồ Chí Minh',
    slug: 'tp-ho-chi-minh',
    country: 'Việt Nam',
    region: 'Miền Nam',
    latitude: 10.8231,
    longitude: 106.6297,
    image:
      'https://images.unsplash.com/photo-1583417319070-4a69db38a482?w=800&h=600&fit=crop',
    description:
      'Thành phố năng động nhất Việt Nam với nhiều công trình kiến trúc và ẩm thực đa dạng',
    status: 'active'
  },
  {
    id: 10,
    name: 'Phú Quốc',
    slug: 'phu-quoc',
    country: 'Việt Nam',
    region: 'Miền Nam',
    latitude: 10.227,
    longitude: 103.9644,
    image:
      'https://images.unsplash.com/photo-1548080819-68f8b1ec737b?w=800&h=600&fit=crop',
    description: 'Đảo ngọc với bãi biển cát trắng và nước biển trong xanh',
    status: 'active'
  },
  {
    id: 11,
    name: 'Cần Thơ',
    slug: 'can-tho',
    country: 'Việt Nam',
    region: 'Miền Nam',
    latitude: 10.0341,
    longitude: 105.7883,
    image:
      'https://images.unsplash.com/photo-1605196560547-b2f7281b7335?w=800&h=600&fit=crop',
    description: 'Thành phố sông nước với chợ nổi Cái Răng nổi tiếng',
    status: 'active'
  },
  {
    id: 12,
    name: 'Cát Bà',
    slug: 'cat-ba',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 20.7268,
    longitude: 107.0474,
    image:
      'https://images.unsplash.com/photo-1586348943529-beaae6c28db9?w=800&h=600&fit=crop',
    description: 'Đảo lớn nhất vịnh Hạ Long với vườn quốc gia và bãi biển đẹp',
    status: 'active'
  },
  {
    id: 13,
    name: 'Ninh Bình',
    slug: 'ninh-binh',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 20.2544,
    longitude: 105.925,
    image:
      'https://images.unsplash.com/photo-1528127269322-539801943592?w=800&h=600&fit=crop',
    description:
      'Hạ Long trên cạn với danh thắng Tràng An, Tam Cốc - Bích Động',
    status: 'active'
  },
  {
    id: 14,
    name: 'Mộc Châu',
    slug: 'moc-chau',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 20.8299,
    longitude: 104.7291,
    image:
      'https://images.unsplash.com/photo-1602016753527-be5fe4feb12f?w=800&h=600&fit=crop',
    description:
      "Cao nguyên với đồi chè, hoa mận, hoa cải trắng và văn hóa dân tộc Thái, H'Mông",
    status: 'active'
  },
  {
    id: 15,
    name: 'Hà Giang',
    slug: 'ha-giang',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 22.8268,
    longitude: 104.9836,
    image:
      'https://images.unsplash.com/photo-1570366583862-f91883984fde?w=800&h=600&fit=crop',
    description: 'Cao nguyên đá với cung đường Hạnh Phúc và hoa tam giác mạch',
    status: 'active'
  },
  {
    id: 16,
    name: 'Mũi Né',
    slug: 'mui-ne',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 10.9326,
    longitude: 108.2872,
    image:
      'https://images.unsplash.com/photo-1544149447-4f5f8d3a27e3?w=800&h=600&fit=crop',
    description: 'Thiên đường resort với đồi cát và bãi biển dài',
    status: 'active'
  },
  {
    id: 17,
    name: 'Quy Nhơn',
    slug: 'quy-nhon',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 13.7829,
    longitude: 109.2196,
    image:
      'https://images.unsplash.com/photo-1575986711002-39401c9abf3f?w=800&h=600&fit=crop',
    description: 'Thành phố biển yên bình với nhiều bãi biển hoang sơ',
    status: 'active'
  },
  {
    id: 18,
    name: 'Côn Đảo',
    slug: 'con-dao',
    country: 'Việt Nam',
    region: 'Miền Nam',
    latitude: 8.6825,
    longitude: 106.6042,
    image:
      'https://images.unsplash.com/photo-1582531763412-5c5be05d7f99?w=800&h=600&fit=crop',
    description: 'Quần đảo với bãi biển đẹp và di tích lịch sử',
    status: 'active'
  },
  {
    id: 19,
    name: 'Vũng Tàu',
    slug: 'vung-tau',
    country: 'Việt Nam',
    region: 'Miền Nam',
    latitude: 10.346,
    longitude: 107.0843,
    image:
      'https://images.unsplash.com/photo-1569154888200-7f52a3791e5e?w=800&h=600&fit=crop',
    description: 'Thành phố biển gần TP.HCM với tượng Chúa dang tay',
    status: 'active'
  },
  {
    id: 20,
    name: 'Buôn Ma Thuột',
    slug: 'buon-ma-thuot',
    country: 'Việt Nam',
    region: 'Tây Nguyên',
    latitude: 12.6661,
    longitude: 108.0506,
    image:
      'https://images.unsplash.com/photo-1598322972906-8a3c7ef6c20a?w=800&h=600&fit=crop',
    description: 'Thủ phủ cà phê Việt Nam với văn hóa Tây Nguyên đặc sắc',
    status: 'active'
  },
  {
    id: 21,
    name: 'Pleiku',
    slug: 'pleiku',
    country: 'Việt Nam',
    region: 'Tây Nguyên',
    latitude: 13.9833,
    longitude: 108.0,
    image:
      'https://images.unsplash.com/photo-1598323107170-5f13d8e68a93?w=800&h=600&fit=crop',
    description: 'Thành phố cao nguyên với Biển Hồ và thác Phú Cường',
    status: 'active'
  },
  {
    id: 22,
    name: 'Điện Biên Phủ',
    slug: 'dien-bien-phu',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 21.3856,
    longitude: 103.0169,
    image:
      'https://images.unsplash.com/photo-1599708153386-62bf3489c58a?w=800&h=600&fit=crop',
    description: 'Chiến trường lịch sử với di tích Điện Biên Phủ',
    status: 'active'
  },
  {
    id: 23,
    name: 'Lý Sơn',
    slug: 'ly-son',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 15.3803,
    longitude: 109.1178,
    image:
      'https://images.unsplash.com/photo-1575986767340-5d17ae767ab0?w=800&h=600&fit=crop',
    description:
      'Đảo tiền tiêu với cảnh quan địa chất độc đáo và cánh đồng tỏi',
    status: 'active'
  },
  {
    id: 24,
    name: 'Phong Nha - Kẻ Bàng',
    slug: 'phong-nha-ke-bang',
    country: 'Việt Nam',
    region: 'Miền Trung',
    latitude: 17.5903,
    longitude: 106.2831,
    image:
      'https://images.unsplash.com/photo-1528181304800-259b08848526?w=800&h=600&fit=crop',
    description: 'Vườn quốc gia với hệ thống hang động kỳ vĩ',
    status: 'active'
  },
  {
    id: 25,
    name: 'Bắc Hà',
    slug: 'bac-ha',
    country: 'Việt Nam',
    region: 'Miền Bắc',
    latitude: 22.5392,
    longitude: 104.2903,
    image:
      'https://images.unsplash.com/photo-1570366583862-f91883984fde?w=800&h=600&fit=crop',
    description:
      "Cao nguyên với chợ phiên đầy màu sắc và văn hóa dân tộc H'Mông hoa",
    status: 'active'
  }
]

// Tạo dữ liệu cho bảng images
const images = []
let imageId = 1

// Thêm ảnh cho người dùng
users.forEach((user) => {
  images.push({
    id: imageId,
    title: `Avatar của ${user.full_name}`,
    description: `Ảnh đại diện của người dùng ${user.username}`,
    file_name: `avatar-${user.id}.jpg`,
    file_path: `/uploads/avatars/avatar-${user.id}.jpg`,
    file_size: Math.floor(Math.random() * 500000) + 50000,
    file_type: 'image/jpeg',
    width: 150,
    height: 150,
    alt_text: `Avatar của ${user.full_name}`,
    cloudinary_id: `avatar-${user.id}`,
    cloudinary_url: user.avatar,
    category: 'avatar',
    user_id: 1, // Admin uploads all images
    created_at: '2023-01-15 10:00:00'
  })
  imageId++
})

// Thêm ảnh cho địa điểm
locations.forEach((location) => {
  images.push({
    id: imageId,
    title: `Ảnh địa điểm ${location.name}`,
    description: `Hình ảnh của địa điểm du lịch ${location.name}`,
    file_name: `location-${location.id}.jpg`,
    file_path: `/uploads/locations/location-${location.id}.jpg`,
    file_size: Math.floor(Math.random() * 2000000) + 500000,
    file_type: 'image/jpeg',
    width: 800,
    height: 600,
    alt_text: `Địa điểm du lịch ${location.name}`,
    cloudinary_id: `location-${location.id}`,
    cloudinary_url: location.image,
    category: 'location',
    user_id: 1,
    created_at: '2023-01-20 11:30:00'
  })
  imageId++
})

// Thêm ảnh cho danh mục tour
tourCategories.forEach((category) => {
  images.push({
    id: imageId,
    title: `Ảnh danh mục ${category.name}`,
    description: `Hình ảnh minh họa cho danh mục ${category.name}`,
    file_name: `category-${category.id}.jpg`,
    file_path: `/uploads/categories/category-${category.id}.jpg`,
    file_size: Math.floor(Math.random() * 1500000) + 300000,
    file_type: 'image/jpeg',
    width: 600,
    height: 400,
    alt_text: `Danh mục ${category.name}`,
    cloudinary_id: `category-${category.id}`,
    cloudinary_url: category.image,
    category: 'tour_category',
    user_id: 1,
    created_at: '2023-01-25 09:45:00'
  })
  imageId++
})

// Tạo dữ liệu cho bảng tours
const toursData = [
  {
    id: 1,
    title: 'Tour Vịnh Hạ Long 3 Ngày 2 Đêm',
    slug: 'tour-vinh-ha-long-3-ngay-2-dem',
    description:
      'Khám phá vẻ đẹp hùng vĩ của Vịnh Hạ Long - Kỳ quan thiên nhiên thế giới',
    content:
      '<p>Vịnh Hạ Long là một trong những kỳ quan thiên nhiên của thế giới với hàng nghìn hòn đảo đá vôi được bao phủ bởi làn nước xanh ngọc bích. Tour du lịch Vịnh Hạ Long 3 ngày 2 đêm sẽ đưa bạn khám phá vẻ đẹp tuyệt vời của di sản thiên nhiên thế giới này.</p><p>Trong hành trình này, bạn sẽ được:</p><ul><li>Ngủ đêm trên du thuyền sang trọng giữa vịnh</li><li>Khám phá các hang động kỳ vĩ</li><li>Chèo thuyền kayak khám phá các hòn đảo</li><li>Tham gia lớp học nấu ăn trên tàu</li><li>Ngắm bình minh và hoàng hôn tuyệt đẹp trên vịnh</li></ul>',
    duration: '3 ngày 2 đêm',
    group_size: '2-20 người',
    price: 2500000,
    sale_price: 2200000,
    category_id: 1,
    location_id: 2,
    departure_location_id: 1,
    included:
      'Xe đưa đón, tàu thăm vịnh, khách sạn 3 sao, ăn sáng và trưa, hướng dẫn viên',
    excluded: 'Đồ uống, chi phí cá nhân, bảo hiểm du lịch',
    featured: true,
    created_by: 1,
    updated_by: null,
    meta_title: 'Tour Vịnh Hạ Long 3 Ngày 2 Đêm | Du Lịch Việt',
    meta_description:
      'Khám phá vẻ đẹp hùng vĩ của Vịnh Hạ Long - Kỳ quan thiên nhiên thế giới với tour du lịch 3 ngày 2 đêm chất lượng cao',
    status: 'active',
    views: 1250
  },
  {
    id: 2,
    title: 'Tour Sapa - Fansipan 2 Ngày 1 Đêm',
    slug: 'tour-sapa-fansipan-2-ngay-1-dem',
    description:
      'Chinh phục đỉnh Fansipan - Nóc nhà Đông Dương và khám phá Sapa thơ mộng',
    content:
      '<p>Sapa là điểm đến lý tưởng cho những ai yêu thích khám phá vẻ đẹp của núi rừng Tây Bắc và văn hóa độc đáo của đồng bào dân tộc thiểu số. Tour Sapa - Fansipan 2 ngày 1 đêm sẽ đưa bạn chinh phục "Nóc nhà Đông Dương" và trải nghiệm không khí se lạnh của phố núi Sapa.</p><p>Hành trình của bạn sẽ bao gồm:</p><ul><li>Đi cáp treo lên đỉnh Fansipan</li><li>Tham quan bản Cát Cát</li><li>Khám phá phố cổ Sapa</li><li>Thưởng thức ẩm thực đặc sắc vùng núi</li></ul>',
    duration: '2 ngày 1 đêm',
    group_size: '2-15 người',
    price: 1800000,
    sale_price: 1650000,
    category_id: 2,
    location_id: 3,
    departure_location_id: 1,
    included: 'Xe khứ hồi, khách sạn, vé cáp treo Fansipan, ăn sáng',
    excluded: 'Đồ uống, chi phí cá nhân, bảo hiểm du lịch',
    featured: true,
    created_by: 2,
    updated_by: 1,
    meta_title: 'Tour Sapa - Fansipan 2 Ngày 1 Đêm | Du Lịch Việt',
    meta_description:
      'Chinh phục đỉnh Fansipan - Nóc nhà Đông Dương và khám phá Sapa thơ mộng với tour du lịch 2 ngày 1 đêm',
    status: 'active',
    views: 980
  },
  {
    id: 3,
    title: 'Tour Đà Nẵng - Hội An - Huế 4 Ngày 3 Đêm',
    slug: 'tour-da-nang-hoi-an-hue-4-ngay-3-dem',
    description:
      'Hành trình khám phá miền Trung xinh đẹp với di sản văn hóa thế giới',
    content:
      '<p>Miền Trung Việt Nam nổi tiếng với những di sản văn hóa thế giới và cảnh quan thiên nhiên tuyệt đẹp. Tour Đà Nẵng - Hội An - Huế 4 ngày 3 đêm sẽ đưa bạn đến với những địa danh nổi tiếng nhất của khu vực này.</p><p>Trong hành trình này, bạn sẽ được:</p><ul><li>Tham quan phố cổ Hội An rực rỡ đèn lồng</li><li>Khám phá Bà Nà Hills và Cầu Vàng nổi tiếng</li><li>Thăm Đại Nội Huế và các lăng tẩm vua chúa</li><li>Trải nghiệm ẩm thực đặc sắc miền Trung</li><li>Tắm biển tại bãi biển Mỹ Khê xinh đẹp</li></ul>',
    duration: '4 ngày 3 đêm',
    group_size: '4-20 người',
    price: 3500000,
    sale_price: 3200000,
    category_id: 6,
    location_id: 5,
    departure_location_id: 9,
    included:
      'Vé máy bay khứ hồi, xe đưa đón, khách sạn 4 sao, ăn sáng, hướng dẫn viên',
    excluded: 'Đồ uống, chi phí cá nhân, vé tham quan',
    featured: true,
    created_by: 1,
    updated_by: null,
    meta_title: 'Tour Đà Nẵng - Hội An - Huế 4 Ngày 3 Đêm | Du Lịch Việt',
    meta_description:
      'Hành trình khám phá miền Trung xinh đẹp với di sản văn hóa thế giới Hội An, Huế và thành phố biển Đà Nẵng',
    status: 'active',
    views: 1560
  },
  {
    id: 4,
    title: 'Tour Phú Quốc Nghỉ Dưỡng 3 Ngày 2 Đêm',
    slug: 'tour-phu-quoc-nghi-duong-3-ngay-2-dem',
    description:
      'Thả mình trên bãi biển cát trắng và tận hưởng kỳ nghỉ tuyệt vời tại đảo ngọc',
    content:
      '<p>Phú Quốc - hòn đảo lớn nhất Việt Nam được mệnh danh là "đảo ngọc" với những bãi biển cát trắng mịn, nước biển xanh trong và hệ sinh thái đa dạng. Tour Phú Quốc 3 ngày 2 đêm là lựa chọn hoàn hảo cho kỳ nghỉ dưỡng của bạn.</p><p>Chương trình tour bao gồm:</p><ul><li>Tham quan Vinpearl Safari - vườn thú bán hoang dã đầu tiên tại Việt Nam</li><li>Khám phá làng chài Hàm Ninh</li><li>Trải nghiệm tour câu cá, lặn ngắm san hô</li><li>Thưởng thức hải sản tươi ngon</li><li>Tự do tắm biển tại bãi Sao - một trong những bãi biển đẹp nhất Việt Nam</li></ul>',
    duration: '3 ngày 2 đêm',
    group_size: '2-30 người',
    price: 3900000,
    sale_price: 3500000,
    category_id: 1,
    location_id: 10,
    departure_location_id: 9,
    included: 'Vé máy bay, xe đưa đón, resort 4 sao, ăn sáng, tour câu cá',
    excluded: 'Đồ uống, chi phí cá nhân, vé tham quan',
    featured: false,
    created_by: 2,
    updated_by: null,
    meta_title: 'Tour Phú Quốc Nghỉ Dưỡng 3 Ngày 2 Đêm | Du Lịch Việt',
    meta_description:
      'Thả mình trên bãi biển cát trắng và tận hưởng kỳ nghỉ tuyệt vời tại đảo ngọc Phú Quốc với tour du lịch 3 ngày 2 đêm',
    status: 'active',
    views: 1120
  },
  {
    id: 5,
    title: 'Tour Miền Tây 2 Ngày 1 Đêm',
    slug: 'tour-mien-tay-2-ngay-1-dem',
    description: 'Khám phá miền Tây sông nước với chợ nổi và vườn trái cây',
    content:
      '<p>Miền Tây Nam Bộ nổi tiếng với hệ thống sông ngòi chằng chịt, những khu vườn trái cây sum suê và nét văn hóa đặc sắc của người dân vùng đồng bằng sông Cửu Long. Tour Miền Tây 2 ngày 1 đêm sẽ đưa bạn khám phá vẻ đẹp mộc mạc và bình dị của vùng đất này.</p><p>Hành trình của bạn sẽ bao gồm:</p><ul><li>Tham quan chợ nổi Cái Răng - một nét văn hóa độc đáo của miền Tây</li><li>Thưởng thức trái cây tươi ngon tại vườn</li><li>Trải nghiệm đi xuồng ba lá trong rạch nhỏ</li><li>Thưởng thức ẩm thực đặc sắc miền Tây</li><li>Tham quan làng nghề truyền thống</li></ul>',
    duration: '2 ngày 1 đêm',
    group_size: '4-25 người',
    price: 1200000,
    sale_price: 1000000,
    category_id: 7,
    location_id: 11,
    departure_location_id: 9,
    included:
      'Xe khứ hồi, khách sạn 3 sao, ăn sáng, hướng dẫn viên, đò tham quan chợ nổi',
    excluded: 'Đồ uống, chi phí cá nhân',
    featured: false,
    created_by: 1,
    updated_by: null,
    meta_title: 'Tour Miền Tây 2 Ngày 1 Đêm | Du Lịch Việt',
    meta_description:
      'Khám phá miền Tây sông nước với chợ nổi Cái Răng và vườn trái cây sum suê trong tour du lịch 2 ngày 1 đêm',
    status: 'active',
    views: 850
  },
  {
    id: 6,
    title: 'Tour Hà Giang - Cao Nguyên Đá 3 Ngày 2 Đêm',
    slug: 'tour-ha-giang-cao-nguyen-da-3-ngay-2-dem',
    description:
      'Khám phá vẻ đẹp hùng vĩ của cao nguyên đá Hà Giang và văn hóa dân tộc vùng cao',
    content:
      '<p>Hà Giang - vùng đất địa đầu Tổ quốc với những cảnh quan thiên nhiên hùng vĩ và nét văn hóa độc đáo của đồng bào dân tộc thiểu số. Tour Hà Giang 3 ngày 2 đêm sẽ đưa bạn chinh phục những cung đường đèo hiểm trở và khám phá vẻ đẹp nguyên sơ của cao nguyên đá.</p><p>Hành trình của bạn sẽ bao gồm:</p><ul><li>Chinh phục đèo Mã Pí Lèng - một trong "tứ đại đỉnh đèo" của Việt Nam</li><li>Tham quan Cổng Trời Quản Bạ</li><li>Khám phá Công viên địa chất toàn cầu Cao nguyên đá Đồng Văn</li><li>Thăm dinh thự vua Mèo</li><li>Trải nghiệm văn hóa dân tộc H\'Mông, Dao, Tày, Nùng</li></ul>',
    duration: '3 ngày 2 đêm',
    group_size: '4-15 người',
    price: 2800000,
    sale_price: 2500000,
    category_id: 2,
    location_id: 15,
    departure_location_id: 1,
    included: 'Xe limousine, homestay, ăn 3 bữa, hướng dẫn viên, vé tham quan',
    excluded: 'Đồ uống, chi phí cá nhân, bảo hiểm du lịch',
    featured: true,
    created_by: 1,
    updated_by: null,
    meta_title: 'Tour Hà Giang - Cao Nguyên Đá 3 Ngày 2 Đêm | Du Lịch Việt',
    meta_description:
      'Khám phá vẻ đẹp hùng vĩ của cao nguyên đá Hà Giang và văn hóa dân tộc vùng cao với tour du lịch 3 ngày 2 đêm',
    status: 'active',
    views: 1320
  },
  {
    id: 7,
    title: 'Tour Đà Lạt Mộng Mơ 3 Ngày 2 Đêm',
    slug: 'tour-da-lat-mong-mo-3-ngay-2-dem',
    description:
      'Thành phố ngàn hoa với khí hậu se lạnh quanh năm và cảnh quan thơ mộng',
    content:
      '<p>Đà Lạt - thành phố ngàn hoa với khí hậu mát mẻ quanh năm, những rừng thông xanh ngát và kiến trúc độc đáo mang phong cách châu Âu. Tour Đà Lạt 3 ngày 2 đêm sẽ đưa bạn khám phá vẻ đẹp lãng mạn và thơ mộng của thành phố sương mù này.</p><p>Hành trình của bạn sẽ bao gồm:</p><ul><li>Tham quan Ga Đà Lạt - nhà ga cổ kính nhất Đông Dương</li><li>Khám phá Đồi chè Cầu Đất xanh mướt</li><li>Thăm Thung lũng Tình Yêu, Hồ Tuyền Lâm</li><li>Trải nghiệm cảm giác mạnh tại thác Datanla</li><li>Thưởng thức đặc sản Đà Lạt: bánh tráng nướng, sữa đậu nành, artichoke...</li></ul>',
    duration: '3 ngày 2 đêm',
    group_size: '2-25 người',
    price: 2200000,
    sale_price: 1900000,
    category_id: 2,
    location_id: 8,
    departure_location_id: 9,
    included:
      'Xe khứ hồi, khách sạn 3 sao, ăn sáng, hướng dẫn viên, vé tham quan',
    excluded: 'Đồ uống, chi phí cá nhân, các bữa trưa và tối',
    featured: true,
    created_by: 2,
    updated_by: null,
    meta_title: 'Tour Đà Lạt Mộng Mơ 3 Ngày 2 Đêm | Du Lịch Việt',
    meta_description:
      'Thành phố ngàn hoa với khí hậu se lạnh quanh năm và cảnh quan thơ mộng, khám phá Đà Lạt với tour du lịch 3 ngày 2 đêm',
    status: 'active',
    views: 1050
  },
  {
    id: 8,
    title: 'Tour Ninh Bình - Tràng An 2 Ngày 1 Đêm',
    slug: 'tour-ninh-binh-trang-an-2-ngay-1-dem',
    description:
      'Khám phá Hạ Long trên cạn với danh thắng Tràng An, Tam Cốc - Bích Động',
    content:
      '<p>Ninh Bình được mệnh danh là "Hạ Long trên cạn" với hệ thống núi đá vôi, sông ngòi và hang động tuyệt đẹp. Tour Ninh Bình - Tràng An 2 ngày 1 đêm sẽ đưa bạn khám phá vẻ đẹp của di sản thiên nhiên thế giới này.</p><p>Hành trình của bạn sẽ bao gồm:</p><ul><li>Tham quan quần thể danh thắng Tràng An</li><li>Khám phá Tam Cốc - Bích Động</li><li>Thăm Cố đô Hoa Lư</li><li>Chinh phục đỉnh Hang Múa với 500 bậc đá</li><li>Thưởng thức ẩm thực đặc sản Ninh Bình: cơm cháy, dê núi, nem Yên Mạc...</li></ul>',
    duration: '2 ngày 1 đêm',
    group_size: '2-20 người',
    price: 1600000,
    sale_price: 1400000,
    category_id: 3,
    location_id: 13,
    departure_location_id: 1,
    included:
      'Xe khứ hồi, khách sạn 3 sao, ăn sáng, hướng dẫn viên, vé tham quan, đò Tràng An',
    excluded: 'Đồ uống, chi phí cá nhân',
    featured: false,
    created_by: 1,
    updated_by: null,
    meta_title: 'Tour Ninh Bình - Tràng An 2 Ngày 1 Đêm | Du Lịch Việt',
    meta_description:
      'Khám phá Hạ Long trên cạn với danh thắng Tràng An, Tam Cốc - Bích Động trong tour du lịch Ninh Bình 2 ngày 1 đêm',
    status: 'active',
    views: 920
  },
  {
    id: 9,
    title: 'Tour Mũi Né - Phan Thiết 3 Ngày 2 Đêm',
    slug: 'tour-mui-ne-phan-thiet-3-ngay-2-dem',
    description:
      'Thiên đường resort với bãi biển đẹp, đồi cát và làng chài Mũi Né',
    content:
      '<p>Mũi Né - Phan Thiết là điểm đến lý tưởng cho những ai yêu thích biển và muốn có một kỳ nghỉ dưỡng thư giãn. Tour Mũi Né - Phan Thiết 3 ngày 2 đêm sẽ đưa bạn đến với thiên đường resort và những cảnh quan thiên nhiên tuyệt đẹp.</p><p>Hành trình của bạn sẽ bao gồm:</p><ul><li>Tham quan đồi cát bay Mũi Né</li><li>Khám phá Suối Tiên với những khe nước đỏ độc đáo</li><li>Thăm làng chài Mũi Né</li><li>Trải nghiệm các môn thể thao biển: lướt ván, dù lượn</li><li>Thưởng thức hải sản tươi ngon: ghẹ Hàm Tiến, mực một nắng...</li></ul>',
    duration: '3 ngày 2 đêm',
    group_size: '2-30 người',
    price: 2100000,
    sale_price: 1800000,
    category_id: 1,
    location_id: 16,
    departure_location_id: 9,
    included: 'Xe khứ hồi, resort 4 sao, ăn sáng, hướng dẫn viên, tour đồi cát',
    excluded: 'Đồ uống, chi phí cá nhân, các bữa trưa và tối',
    featured: false,
    created_by: 2,
    updated_by: null,
    meta_title: 'Tour Mũi Né - Phan Thiết 3 Ngày 2 Đêm | Du Lịch Việt',
    meta_description:
      'Thiên đường resort với bãi biển đẹp, đồi cát và làng chài Mũi Né trong tour du lịch 3 ngày 2 đêm',
    status: 'active',
    views: 890
  },
  {
    id: 10,
    title: 'Tour Phong Nha - Kẻ Bàng 3 Ngày 2 Đêm',
    slug: 'tour-phong-nha-ke-bang-3-ngay-2-dem',
    description:
      'Khám phá hệ thống hang động kỳ vĩ tại vườn quốc gia Phong Nha - Kẻ Bàng',
    content:
      '<p>Phong Nha - Kẻ Bàng là vườn quốc gia nổi tiếng với hệ thống hang động kỳ vĩ và đa dạng sinh học phong phú. Tour Phong Nha - Kẻ Bàng 3 ngày 2 đêm sẽ đưa bạn khám phá vẻ đẹp của di sản thiên nhiên thế giới này.</p><p>Hành trình của bạn sẽ bao gồm:</p><ul><li>Tham quan động Phong Nha - hang động có dòng sông ngầm dài nhất thế giới</li><li>Khám phá Động Thiên Đường - được mệnh danh là "hoàng cung trong lòng đất"</li><li>Trải nghiệm Suối Nước Moọc trong xanh</li><li>Thăm Vườn thực vật, Bảo tàng Phong Nha</li><li>Thưởng thức ẩm thực đặc sản Quảng Bình: cháo canh, bánh bột lọc, bánh xèo Quảng Bình...</li></ul>',
    duration: '3 ngày 2 đêm',
    group_size: '4-15 người',
    price: 2900000,
    sale_price: 2600000,
    category_id: 2,
    location_id: 24,
    departure_location_id: 5,
    included:
      'Xe khứ hồi, khách sạn 3 sao, ăn sáng, hướng dẫn viên, vé tham quan hang động',
    excluded: 'Đồ uống, chi phí cá nhân, các bữa trưa và tối',
    featured: true,
    created_by: 1,
    updated_by: null,
    meta_title: 'Tour Phong Nha - Kẻ Bàng 3 Ngày 2 Đêm | Du Lịch Việt',
    meta_description:
      'Khám phá hệ thống hang động kỳ vĩ tại vườn quốc gia Phong Nha - Kẻ Bàng với tour du lịch 3 ngày 2 đêm',
    status: 'active',
    views: 1150
  }
]

// Thêm ảnh cho tour
toursData.forEach((tour) => {
  images.push({
    id: imageId,
    title: `Ảnh tour ${tour.title}`,
    description: `Hình ảnh minh họa cho tour ${tour.title}`,
    file_name: `tour-${tour.id}.jpg`,
    file_path: `/uploads/tours/tour-${tour.id}.jpg`,
    file_size: Math.floor(Math.random() * 2500000) + 800000,
    file_type: 'image/jpeg',
    width: 800,
    height: 600,
    alt_text: `Tour ${tour.title}`,
    cloudinary_id: `tour-${tour.id}`,
    cloudinary_url: `https://images.unsplash.com/photo-${Math.floor(
      Math.random() * 1000000000
    )}-${Math.floor(Math.random() * 10000000)}?w=800&h=600&fit=crop`,
    category: 'tour',
    user_id: tour.created_by,
    created_at: '2023-02-01 10:15:00'
  })
  imageId++

  // Thêm 2 ảnh phụ cho mỗi tour
  for (let i = 1; i <= 2; i++) {
    images.push({
      id: imageId,
      title: `Ảnh phụ ${i} tour ${tour.title}`,
      description: `Hình ảnh phụ ${i} cho tour ${tour.title}`,
      file_name: `tour-${tour.id}-${i}.jpg`,
      file_path: `/uploads/tours/tour-${tour.id}-${i}.jpg`,
      file_size: Math.floor(Math.random() * 2000000) + 500000,
      file_type: 'image/jpeg',
      width: 800,
      height: 600,
      alt_text: `Tour ${tour.title} - Ảnh ${i}`,
      cloudinary_id: `tour-${tour.id}-${i}`,
      cloudinary_url: `https://images.unsplash.com/photo-${Math.floor(
        Math.random() * 1000000000
      )}-${Math.floor(Math.random() * 10000000)}?w=800&h=600&fit=crop`,
      category: 'tour',
      user_id: tour.created_by,
      created_at: '2023-02-01 10:20:00'
    })
    imageId++
  }
})

// Tạo dữ liệu chi tiết itinerary cho tour
const tours = toursData.map((tour) => {
  let itinerary

  // Tùy vào tour mà tạo lịch trình
  if (tour.id === 1) {
    itinerary = [
      {
        day: 1,
        title: 'Hà Nội - Hạ Long',
        description:
          'Xe đón khách tại Hà Nội. Khởi hành đi Hạ Long. Nhận phòng khách sạn. Tự do tham quan.',
        activities: [
          'Đón khách tại khách sạn',
          'Di chuyển đến Hạ Long',
          'Nhận phòng khách sạn',
          'Tự do tham quan Hạ Long'
        ]
      },
      {
        day: 2,
        title: 'Khám phá Vịnh Hạ Long',
        description:
          'Ăn sáng tại khách sạn. Tàu đưa đoàn đi tham quan Vịnh Hạ Long. Khám phá hang động, chèo thuyền kayak.',
        activities: [
          'Ăn sáng',
          'Lên tàu thăm Vịnh Hạ Long',
          'Tham quan hang Sửng Sốt',
          'Chèo thuyền kayak',
          'Nghỉ đêm trên tàu'
        ]
      },
      {
        day: 3,
        title: 'Hạ Long - Hà Nội',
        description:
          'Ngắm bình minh trên vịnh. Ăn sáng trên tàu. Tiếp tục tham quan vịnh. Trả phòng. Về Hà Nội.',
        activities: [
          'Tập Tai Chi buổi sáng',
          'Ăn sáng',
          'Thăm làng chài',
          'Trả phòng',
          'Về Hà Nội'
        ]
      }
    ]
  } else if (tour.id === 2) {
    itinerary = [
      {
        day: 1,
        title: 'Hà Nội - Sa Pa',
        description:
          'Đón khách tại Hà Nội. Khởi hành đi Sa Pa. Nhận phòng. Tham quan phố núi Sa Pa.',
        activities: [
          'Đón khách tại Hà Nội',
          'Di chuyển đến Sa Pa',
          'Nhận phòng',
          'Tham quan phố Sa Pa',
          'Ăn tối'
        ]
      },
      {
        day: 2,
        title: 'Chinh phục Fansipan - Về Hà Nội',
        description:
          'Ăn sáng. Khởi hành đi cáp treo Fansipan. Chinh phục đỉnh Fansipan. Trở về Hà Nội.',
        activities: [
          'Ăn sáng',
          'Đi cáp treo Fansipan',
          'Chinh phục đỉnh núi',
          'Ăn trưa',
          'Về Hà Nội'
        ]
      }
    ]
  } else {
    // Tạo lịch trình mặc định dựa vào số ngày
    const days = parseInt(tour.duration.split(' ')[0])
    itinerary = []

    for (let i = 1; i <= days; i++) {
      itinerary.push({
        day: i,
        title: `Ngày ${i}: Khám phá điểm đến`,
        description: `Lịch trình chi tiết cho ngày thứ ${i} của tour du lịch.`,
        activities: [
          'Ăn sáng',
          'Tham quan điểm du lịch',
          'Ăn trưa',
          'Nghỉ ngơi',
          'Ăn tối'
        ]
      })
    }
  }

  return {
    ...tour,
    itinerary: JSON.stringify(itinerary)
  }
})

// Tạo dữ liệu cho bảng tour_images
const tourImages = []
let tourImageId = 1

tours.forEach((tour) => {
  // Ảnh chính của tour
  tourImages.push({
    id: tourImageId++,
    tour_id: tour.id,
    image_id:
      tour.id * 3 + users.length + locations.length + tourCategories.length - 2, // Tính toán image_id tương ứng
    is_featured: true,
    sort_order: 0
  })

  // Ảnh phụ 1
  tourImages.push({
    id: tourImageId++,
    tour_id: tour.id,
    image_id:
      tour.id * 3 + users.length + locations.length + tourCategories.length - 1, // Tính toán image_id tương ứng
    is_featured: false,
    sort_order: 1
  })

  // Ảnh phụ 2
  tourImages.push({
    id: tourImageId++,
    tour_id: tour.id,
    image_id:
      tour.id * 3 + users.length + locations.length + tourCategories.length, // Tính toán image_id tương ứng
    is_featured: false,
    sort_order: 2
  })
})

// Tạo dữ liệu cho bảng tour_dates
const tourDates = []
let tourDateId = 1

tours.forEach((tour) => {
  // Tạo 3 ngày khởi hành cho mỗi tour
  const today = new Date()

  for (let i = 0; i < 3; i++) {
    const startDate = new Date(today)
    startDate.setDate(today.getDate() + 14 + i * 7) // 2 tuần sau, và mỗi tuần sau đó

    const endDate = new Date(startDate)
    const durationDays = parseInt(tour.duration.split(' ')[0])
    endDate.setDate(startDate.getDate() + durationDays - 1)

    tourDates.push({
      id: tourDateId++,
      tour_id: tour.id,
      start_date: startDate.toISOString().split('T')[0],
      end_date: endDate.toISOString().split('T')[0],
      price: tour.price,
      sale_price: tour.sale_price,
      available_seats: 20,
      status: 'available'
    })
  }
})

// Tạo dữ liệu cho bảng bookings
const bookings = [
  {
    id: 1,
    booking_number: 'BK10001',
    user_id: 3,
    tour_id: 1,
    tour_date_id: 1,
    adults: 2,
    children: 0,
    total_price: 4400000,
    status: 'confirmed',
    payment_status: 'paid',
    payment_method: 'banking',
    transaction_id: 'TX10001',
    special_requirements: 'Phòng không hút thuốc'
  },
  {
    id: 2,
    booking_number: 'BK10002',
    user_id: 4,
    tour_id: 3,
    tour_date_id: 7,
    adults: 2,
    children: 1,
    total_price: 6400000,
    status: 'confirmed',
    payment_status: 'paid',
    payment_method: 'credit_card',
    transaction_id: 'TX10002',
    special_requirements: 'Cần phòng có giường phụ cho trẻ em'
  },
  {
    id: 3,
    booking_number: 'BK10003',
    user_id: 5,
    tour_id: 2,
    tour_date_id: 4,
    adults: 1,
    children: 0,
    total_price: 1650000,
    status: 'pending',
    payment_status: 'pending',
    payment_method: null,
    transaction_id: null,
    special_requirements: ''
  },
  {
    id: 4,
    booking_number: 'BK10004',
    user_id: 6,
    tour_id: 5,
    tour_date_id: 13,
    adults: 4,
    children: 2,
    total_price: 5000000,
    status: 'confirmed',
    payment_status: 'paid',
    payment_method: 'momo',
    transaction_id: 'TX10004',
    special_requirements: 'Cần 2 phòng liền kề'
  },
  {
    id: 5,
    booking_number: 'BK10005',
    user_id: 7,
    tour_id: 6,
    tour_date_id: 16,
    adults: 2,
    children: 0,
    total_price: 5000000,
    status: 'completed',
    payment_status: 'paid',
    payment_method: 'banking',
    transaction_id: 'TX10005',
    special_requirements: 'Cần hướng dẫn viên nói tiếng Anh'
  }
]

// Tạo dữ liệu cho bảng payment_methods
const paymentMethods = [
  {
    id: 1,
    name: 'Chuyển khoản ngân hàng',
    code: 'banking',
    description: 'Thanh toán bằng chuyển khoản qua ngân hàng',
    instructions:
      'Vui lòng chuyển khoản đến số tài khoản: 123456789 tại Ngân hàng ABC, chi nhánh Hà Nội. Nội dung: Mã đặt tour của bạn.',
    is_online: false,
    sort_order: 1,
    is_active: true,
    logo: 'https://images.unsplash.com/photo-1601597111158-2fceff292cdc?w=200&h=100&fit=crop',
    config: JSON.stringify({
      bank_name: 'Ngân hàng TMCP ABC',
      account_number: '123456789',
      account_name: 'CÔNG TY DU LỊCH VIỆT',
      branch: 'Chi nhánh Hà Nội'
    })
  },
  {
    id: 2,
    name: 'Thẻ tín dụng/ghi nợ',
    code: 'credit_card',
    description: 'Thanh toán bằng thẻ tín dụng hoặc thẻ ghi nợ quốc tế',
    instructions:
      'Bạn sẽ được chuyển đến cổng thanh toán an toàn để hoàn tất giao dịch.',
    is_online: true,
    sort_order: 2,
    is_active: true,
    logo: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=200&h=100&fit=crop',
    config: JSON.stringify({
      gateway: 'stripe',
      api_key: 'sk_test_example',
      supported_cards: ['visa', 'mastercard', 'amex']
    })
  },
  {
    id: 3,
    name: 'Ví điện tử MoMo',
    code: 'momo',
    description: 'Thanh toán qua ví điện tử MoMo',
    instructions:
      'Quét mã QR hoặc đăng nhập vào tài khoản MoMo của bạn để thanh toán.',
    is_online: true,
    sort_order: 3,
    is_active: true,
    logo: 'https://images.unsplash.com/photo-1614680376573-df3480f0c6ff?w=200&h=100&fit=crop',
    config: JSON.stringify({
      partner_code: 'MOMO123',
      access_key: 'access_key_example',
      secret_key: 'secret_key_example'
    })
  },
  {
    id: 4,
    name: 'Thanh toán tại văn phòng',
    code: 'office',
    description: 'Đến văn phòng công ty để thanh toán trực tiếp',
    instructions:
      'Địa chỉ: 123 Đường Lê Lợi, Quận 1, TP.HCM. Giờ làm việc: 8h00-17h30 từ Thứ 2 đến Thứ 6.',
    is_online: false,
    sort_order: 4,
    is_active: true,
    logo: 'https://images.unsplash.com/photo-1556741533-6e6a62bd8b49?w=200&h=100&fit=crop',
    config: JSON.stringify({
      office_address: '123 Đường Lê Lợi, Quận 1, TP.HCM',
      working_hours: '8h00-17h30',
      working_days: 'Thứ 2 - Thứ 6'
    })
  }
]

// Tạo dữ liệu cho bảng payments
const payments = []
let paymentId = 1

bookings.forEach((booking) => {
  if (booking.payment_status === 'paid') {
    const paymentMethodId = paymentMethods.find(
      (method) => method.code === booking.payment_method
    ).id

    payments.push({
      id: paymentId,
      booking_id: booking.id,
      payment_method_id: paymentMethodId,
      transaction_id: booking.transaction_id,
      transaction_id_internal: null,
      refund_id: null,
      amount: booking.total_price,
      currency: 'VND',
      status: 'completed',
      payment_data: JSON.stringify({
        payment_method: booking.payment_method,
        transaction_id: booking.transaction_id,
        payment_date: new Date().toISOString().split('T')[0]
      }),
      notes: 'Thanh toán thành công',
      payer_name: users.find((user) => user.id === booking.user_id).full_name,
      payer_email: users.find((user) => user.id === booking.user_id).email,
      payer_phone: users.find((user) => user.id === booking.user_id).phone,
      payment_date:
        new Date().toISOString().split('T')[0] +
        ' ' +
        new Date().toTimeString().split(' ')[0]
    })

    paymentId++
  }
})

// Tạo dữ liệu cho bảng transactions
const transactions = []
let transactionId = 1

payments.forEach((payment) => {
  transactions.push({
    id: transactionId,
    transaction_code: payment.transaction_id,
    payment_id: payment.id,
    amount: payment.amount,
    currency: 'VND',
    status: 'completed',
    payment_method: paymentMethods.find(
      (method) => method.id === payment.payment_method_id
    ).code,
    payment_data: JSON.stringify({
      payment_id: payment.id,
      booking_id: payment.booking_id,
      method: paymentMethods.find(
        (method) => method.id === payment.payment_method_id
      ).name
    }),
    notes: 'Giao dịch thành công',
    customer_name: payment.payer_name,
    customer_email: payment.payer_email,
    customer_phone: payment.payer_phone
  })

  // Cập nhật transaction_id_internal cho payment
  payment.transaction_id_internal = transactionId

  transactionId++
})

// Tạo dữ liệu cho bảng invoices
const invoices = []
let invoiceId = 1

payments.forEach((payment) => {
  const booking = bookings.find((b) => b.id === payment.booking_id)
  const user = users.find((u) => u.id === booking.user_id)

  invoices.push({
    id: invoiceId,
    invoice_number: `INV${10000 + invoiceId}`,
    booking_id: booking.id,
    payment_id: payment.id,
    user_id: user.id,
    amount: booking.total_price,
    tax_amount: booking.total_price * 0.1, // 10% thuế
    total_amount: booking.total_price * 1.1,
    status: 'paid',
    issue_date: new Date().toISOString().split('T')[0],
    due_date: new Date(new Date().setDate(new Date().getDate() + 7))
      .toISOString()
      .split('T')[0],
    paid_date: new Date().toISOString().split('T')[0],
    notes: 'Hóa đơn đã thanh toán đầy đủ',
    billing_name: user.full_name,
    billing_address: user.address,
    billing_email: user.email,
    billing_phone: user.phone,
    tax_code: null
  })

  invoiceId++
})

// Tạo dữ liệu cho bảng tour_reviews
const tourReviews = [
  {
    id: 1,
    tour_id: 1,
    user_id: 3,
    booking_id: 1,
    rating: 5,
    title: 'Trải nghiệm tuyệt vời tại Vịnh Hạ Long',
    review:
      'Tour rất tuyệt vời, cảnh đẹp, dịch vụ tốt, hướng dẫn viên nhiệt tình. Tôi sẽ quay lại vào lần sau.',
    status: 'approved'
  },
  {
    id: 2,
    tour_id: 3,
    user_id: 4,
    booking_id: 2,
    rating: 4,
    title: 'Hành trình đáng nhớ tại miền Trung',
    review:
      'Tour rất hay, được khám phá nhiều điểm đến đẹp. Tuy nhiên, thời gian ở Hội An hơi ngắn.',
    status: 'approved'
  },
  {
    id: 3,
    tour_id: 6,
    user_id: 7,
    booking_id: 5,
    rating: 5,
    title: 'Hà Giang đẹp quá',
    review:
      'Cung đường Hà Giang thật sự rất đẹp, đặc biệt là Mã Pí Lèng. Hướng dẫn viên rất am hiểu về văn hóa dân tộc vùng cao.',
    status: 'approved'
  },
  {
    id: 4,
    tour_id: 5,
    user_id: 6,
    booking_id: 4,
    rating: 4,
    title: 'Miền Tây sông nước',
    review:
      'Chợ nổi Cái Răng rất nhộn nhịp và đặc sắc. Tuy nhiên, thời tiết hơi nóng.',
    status: 'pending'
  }
]

// Tạo dữ liệu cho bảng news_categories
const newsCategories = [
  {
    id: 1,
    name: 'Tin tức du lịch',
    slug: 'tin-tuc-du-lich',
    description: 'Cập nhật tin tức mới nhất về du lịch trong và ngoài nước',
    image:
      'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 2,
    name: 'Cẩm nang du lịch',
    slug: 'cam-nang-du-lich',
    description:
      'Những kinh nghiệm, lời khuyên hữu ích cho chuyến du lịch của bạn',
    image:
      'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 3,
    name: 'Điểm đến hấp dẫn',
    slug: 'diem-den-hap-dan',
    description: 'Giới thiệu những điểm đến hấp dẫn trong và ngoài nước',
    image:
      'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 4,
    name: 'Ẩm thực du lịch',
    slug: 'am-thuc-du-lich',
    description: 'Khám phá ẩm thực đặc sắc tại các điểm du lịch',
    image:
      'https://images.unsplash.com/photo-1511690656952-34342bb7c2f2?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  },
  {
    id: 5,
    name: 'Khách sạn & Resort',
    slug: 'khach-san-resort',
    description: 'Thông tin về các khách sạn, resort đẹp và chất lượng',
    image:
      'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&h=400&fit=crop',
    parent_id: null,
    status: 'active'
  }
]

// Thêm ảnh cho danh mục tin tức
newsCategories.forEach((category) => {
  images.push({
    id: imageId,
    title: `Ảnh danh mục tin tức ${category.name}`,
    description: `Hình ảnh minh họa cho danh mục tin tức ${category.name}`,
    file_name: `news-category-${category.id}.jpg`,
    file_path: `/uploads/news-categories/news-category-${category.id}.jpg`,
    file_size: Math.floor(Math.random() * 1500000) + 300000,
    file_type: 'image/jpeg',
    width: 600,
    height: 400,
    alt_text: `Danh mục tin tức ${category.name}`,
    cloudinary_id: `news-category-${category.id}`,
    cloudinary_url: category.image,
    category: 'news_category',
    user_id: 1,
    created_at: '2023-01-30 14:20:00'
  })
  imageId++
})

// Tạo dữ liệu cho bảng news
const news = [
  {
    id: 1,
    title: 'Top 10 điểm du lịch hấp dẫn nhất Việt Nam năm 2023',
    slug: 'top-10-diem-du-lich-hap-dan-nhat-viet-nam-nam-2023',
    summary:
      'Khám phá những điểm đến du lịch hấp dẫn nhất Việt Nam trong năm 2023, từ vịnh Hạ Long đến đảo Phú Quốc.',
    content:
      '<p>Việt Nam là một đất nước có nhiều cảnh quan thiên nhiên tuyệt đẹp và di sản văn hóa phong phú. Dưới đây là top 10 điểm du lịch hấp dẫn nhất Việt Nam trong năm 2023:</p><ol><li>Vịnh Hạ Long - Di sản thiên nhiên thế giới với hàng nghìn hòn đảo đá vôi</li><li>Phố cổ Hội An - Thành phố cổ đầy màu sắc với đèn lồng rực rỡ</li><li>Sapa - Thị trấn trong sương với ruộng bậc thang và văn hóa dân tộc đặc sắc</li><li>Đà Nẵng - Thành phố đáng sống với bãi biển đẹp và cầu Rồng</li><li>Huế - Cố đô với hệ thống di tích cung đình và ẩm thực cung đình tinh tế</li><li>Phú Quốc - Đảo ngọc với bãi biển cát trắng và nước biển trong xanh</li><li>Đà Lạt - Thành phố ngàn hoa với khí hậu mát mẻ quanh năm</li><li>Ninh Bình - Hạ Long trên cạn với danh thắng Tràng An, Tam Cốc</li><li>Hà Giang - Cao nguyên đá với cung đường Hạnh Phúc</li><li>Côn Đảo - Quần đảo với bãi biển đẹp và di tích lịch sử</li></ol>',
    featured_image:
      'https://images.unsplash.com/photo-1573270689103-d7a4e42b609a?w=800&h=600&fit=crop',
    category_id: 3,
    meta_title: 'Top 10 điểm du lịch hấp dẫn nhất Việt Nam năm 2023',
    meta_description:
      'Khám phá những điểm đến du lịch hấp dẫn nhất Việt Nam trong năm 2023, từ vịnh Hạ Long đến đảo Phú Quốc.',
    status: 'published',
    featured: true,
    views: 2500,
    created_by: 1,
    updated_by: null,
    published_at: '2023-03-15 09:00:00'
  },
  {
    id: 2,
    title: 'Kinh nghiệm du lịch Sapa tự túc tiết kiệm',
    slug: 'kinh-nghiem-du-lich-sapa-tu-tuc-tiet-kiem',
    summary:
      'Những kinh nghiệm hữu ích cho chuyến du lịch Sapa tự túc, từ phương tiện di chuyển đến chỗ ở và ẩm thực.',
    content:
      '<p>Sapa là điểm đến lý tưởng cho những ai yêu thích khám phá vẻ đẹp của núi rừng Tây Bắc. Dưới đây là những kinh nghiệm hữu ích cho chuyến du lịch Sapa tự túc:</p><h3>Phương tiện di chuyển</h3><p>Từ Hà Nội, bạn có thể đến Sapa bằng xe khách hoặc tàu hỏa đến Lào Cai, sau đó đi xe bus lên Sapa. Nên đặt vé trước để có giá tốt.</p><h3>Thời điểm lý tưởng</h3><p>Thời điểm đẹp nhất để đến Sapa là từ tháng 9 đến tháng 11 (mùa lúa chín) hoặc từ tháng 3 đến tháng 5 (mùa hoa đào, hoa mận nở).</p><h3>Chỗ ở</h3><p>Có nhiều lựa chọn từ homestay, hostel đến khách sạn. Nên đặt phòng trước, đặc biệt là vào mùa cao điểm.</p><h3>Địa điểm tham quan</h3><p>Những địa điểm không thể bỏ qua: Fansipan, bản Cát Cát, thung lũng Mường Hoa, cổng trời Ô Quy Hồ, bản Tả Phìn.</p><h3>Ẩm thực</h3><p>Nên thử các món đặc sản như thắng cố, cá hồi, lẩu rau, thịt trâu gác bếp, rượu táo mèo.</p><h3>Chi phí</h3><p>Với chuyến đi 3 ngày 2 đêm, bạn nên chuẩn bị khoảng 2-3 triệu đồng/người, bao gồm di chuyển, ăn uống, chỗ ở và tham quan.</p>',
    featured_image:
      'https://images.unsplash.com/photo-1577948000111-9c970dfe3743?w=800&h=600&fit=crop',
    category_id: 2,
    meta_title: 'Kinh nghiệm du lịch Sapa tự túc tiết kiệm',
    meta_description:
      'Những kinh nghiệm hữu ích cho chuyến du lịch Sapa tự túc, từ phương tiện di chuyển đến chỗ ở và ẩm thực.',
    status: 'published',
    featured: false,
    views: 1800,
    created_by: 2,
    updated_by: null,
    published_at: '2023-03-20 10:30:00'
  },
  {
    id: 3,
    title: '5 món ăn đặc sản không thể bỏ qua khi đến Huế',
    slug: '5-mon-an-dac-san-khong-the-bo-qua-khi-den-hue',
    summary:
      'Khám phá 5 món ăn đặc sản nổi tiếng của xứ Huế mà bạn không nên bỏ qua khi có dịp đến thăm cố đô.',
    content:
      '<p>Huế không chỉ nổi tiếng với hệ thống di tích cung đình mà còn được biết đến là thiên đường ẩm thực với nhiều món ăn đặc sản. Dưới đây là 5 món ăn đặc sản không thể bỏ qua khi đến Huế:</p><h3>1. Bún bò Huế</h3><p>Bún bò Huế là món ăn nổi tiếng nhất của xứ Huế với nước dùng đậm đà, cay nồng và thơm mùi sả, mắm ruốc. Món ăn có sự kết hợp hài hòa giữa vị cay, mặn, ngọt, chua.</p><h3>2. Bánh khoái</h3><p>Bánh khoái là món bánh giòn được chiên với nhân tôm, thịt, giá đỗ, trứng và ăn kèm với rau sống, nước chấm đặc biệt.</p><h3>3. Cơm hến</h3><p>Cơm hến là món ăn bình dân nhưng đặc sắc của Huế, gồm cơm trộn với hến, rau thơm, đậu phộng, tóp mỡ, ăn kèm với nước hến.</p><h3>4. Bánh bèo</h3><p>Bánh bèo là món bánh nhỏ xinh được hấp chín, bên trên rắc tôm khô, hành phi, bột tôm và ăn kèm với nước mắm chua ngọt.</p><h3>5. Chè Huế</h3><p>Chè Huế nổi tiếng với nhiều loại khác nhau như chè khoai tía, chè bắp, chè đậu ván, chè sen... mỗi loại đều có hương vị đặc trưng riêng.</p>',
    featured_image:
      'https://images.unsplash.com/photo-1558159264-4e3ee3ed5de3?w=800&h=600&fit=crop',
    category_id: 4,
    meta_title: '5 món ăn đặc sản không thể bỏ qua khi đến Huế',
    meta_description:
      'Khám phá 5 món ăn đặc sản nổi tiếng của xứ Huế mà bạn không nên bỏ qua khi có dịp đến thăm cố đô.',
    status: 'published',
    featured: true,
    views: 1650,
    created_by: 1,
    updated_by: 2,
    published_at: '2023-03-25 11:15:00'
  },
  {
    id: 4,
    title: 'Top 5 resort nghỉ dưỡng đẳng cấp nhất tại Phú Quốc',
    slug: 'top-5-resort-nghi-duong-dang-cap-nhat-tai-phu-quoc',
    summary:
      'Giới thiệu 5 resort nghỉ dưỡng đẳng cấp nhất tại đảo ngọc Phú Quốc, nơi bạn có thể tận hưởng kỳ nghỉ sang trọng.',
    content:
      '<p>Phú Quốc - hòn đảo lớn nhất Việt Nam được mệnh danh là "đảo ngọc" với những bãi biển cát trắng mịn, nước biển xanh trong. Dưới đây là 5 resort nghỉ dưỡng đẳng cấp nhất tại Phú Quốc:</p><h3>1. JW Marriott Phu Quoc Emerald Bay Resort & Spa</h3><p>Resort 5 sao với thiết kế độc đáo lấy cảm hứng từ trường đại học giả tưởng Lamarck, do Bill Bensley thiết kế. Resort có bãi biển riêng, 3 hồ bơi, spa và nhiều nhà hàng đẳng cấp.</p><h3>2. InterContinental Phu Quoc Long Beach Resort</h3><p>Resort sang trọng nằm trên bãi biển dài với tầm nhìn tuyệt đẹp ra biển, có hồ bơi vô cực, spa, phòng gym và nhiều nhà hàng phục vụ ẩm thực đa dạng.</p><h3>3. Vinpearl Resort & Spa Phu Quoc</h3><p>Resort rộng lớn với kiến trúc tân cổ điển, có bãi biển riêng, hồ bơi, spa, sân golf và nhiều hoạt động giải trí.</p><h3>4. Nam Nghi Phu Quoc Island</h3><p>Resort yên tĩnh nằm trên mũi đất tuyệt đẹp, có bãi biển riêng, hồ bơi vô cực, nhà hàng trên đảo riêng và dịch vụ spa cao cấp.</p><h3>5. Salinda Resort Phu Quoc Island</h3><p>Resort sang trọng với thiết kế hiện đại pha trộn nét văn hóa Việt Nam, có hồ bơi nước mặn, spa và nhà hàng phục vụ ẩm thực đa dạng.</p>',
    featured_image:
      'https://images.unsplash.com/photo-1548080819-68f8b1ec737b?w=800&h=600&fit=crop',
    category_id: 5,
    meta_title: 'Top 5 resort nghỉ dưỡng đẳng cấp nhất tại Phú Quốc',
    meta_description:
      'Giới thiệu 5 resort nghỉ dưỡng đẳng cấp nhất tại đảo ngọc Phú Quốc, nơi bạn có thể tận hưởng kỳ nghỉ sang trọng.',
    status: 'published',
    featured: false,
    views: 1420,
    created_by: 2,
    updated_by: null,
    published_at: '2023-04-01 13:45:00'
  },
  {
    id: 5,
    title: 'Lịch trình du lịch Đà Nẵng - Hội An 4 ngày 3 đêm',
    slug: 'lich-trinh-du-lich-da-nang-hoi-an-4-ngay-3-dem',
    summary:
      'Gợi ý lịch trình du lịch Đà Nẵng - Hội An 4 ngày 3 đêm đầy đủ và chi tiết cho chuyến đi hoàn hảo.',
    content:
      '<p>Đà Nẵng - Hội An là điểm đến lý tưởng với nhiều cảnh đẹp và di sản văn hóa. Dưới đây là gợi ý lịch trình du lịch Đà Nẵng - Hội An 4 ngày 3 đêm:</p><h3>Ngày 1: Khám phá Đà Nẵng</h3><p><strong>Sáng:</strong> Tham quan bán đảo Sơn Trà, chùa Linh Ứng với tượng Phật Quan Âm cao nhất Việt Nam.<br><strong>Trưa:</strong> Thưởng thức mì Quảng, bún chả cá tại trung tâm thành phố.<br><strong>Chiều:</strong> Tham quan cầu Rồng, cầu Tình Yêu, và bảo tàng điêu khắc Chăm.<br><strong>Tối:</strong> Ngắm cầu Rồng phun lửa và phun nước, dạo bộ dọc bờ sông Hàn.</p><h3>Ngày 2: Bà Nà Hills</h3><p><strong>Sáng:</strong> Đi cáp treo lên Bà Nà Hills, tham quan Cầu Vàng, làng Pháp.<br><strong>Trưa:</strong> Ăn trưa tại nhà hàng trong Bà Nà Hills.<br><strong>Chiều:</strong> Tham quan vườn hoa, khu vui chơi Fantasy Park.<br><strong>Tối:</strong> Về lại Đà Nẵng, thưởng thức hải sản tại bãi biển Mỹ Khê.</p><h3>Ngày 3: Hội An</h3><p><strong>Sáng:</strong> Di chuyển đến Hội An, tham quan phố cổ, chùa Cầu, nhà cổ Tấn Ký.<br><strong>Trưa:</strong> Thưởng thức cao lầu, hoành thánh tại phố cổ.<br><strong>Chiều:</strong> Tham quan làng gốm Thanh Hà hoặc làng rau Trà Quế.<br><strong>Tối:</strong> Ngắm phố cổ Hội An về đêm với đèn lồng rực rỡ, thả đèn hoa đăng trên sông Hoài.</p><h3>Ngày 4: Ngũ Hành Sơn và biển Đà Nẵng</h3><p><strong>Sáng:</strong> Tham quan danh thắng Ngũ Hành Sơn, hang động và các chùa.<br><strong>Trưa:</strong> Ăn trưa tại nhà hàng gần biển.<br><strong>Chiều:</strong> Tắm biển Mỹ Khê hoặc Non Nước, thư giãn trước khi kết thúc chuyến đi.<br><strong>Tối:</strong> Thưởng thức bữa tối chia tay, mua sắm quà lưu niệm.</p>',
    featured_image:
      'https://images.unsplash.com/photo-1540300587943-5e9a6d2de6cc?w=800&h=600&fit=crop',
    category_id: 2,
    meta_title: 'Lịch trình du lịch Đà Nẵng - Hội An 4 ngày 3 đêm',
    meta_description:
      'Gợi ý lịch trình du lịch Đà Nẵng - Hội An 4 ngày 3 đêm đầy đủ và chi tiết cho chuyến đi hoàn hảo.',
    status: 'published',
    featured: true,
    views: 2100,
    created_by: 1,
    updated_by: null,
    published_at: '2023-04-05 14:30:00'
  }
]

// Thêm ảnh cho tin tức
news.forEach((item) => {
  images.push({
    id: imageId,
    title: `Ảnh tin tức ${item.title}`,
    description: `Hình ảnh minh họa cho tin tức ${item.title}`,
    file_name: `news-${item.id}.jpg`,
    file_path: `/uploads/news/news-${item.id}.jpg`,
    file_size: Math.floor(Math.random() * 2000000) + 500000,
    file_type: 'image/jpeg',
    width: 800,
    height: 600,
    alt_text: `Tin tức ${item.title}`,
    cloudinary_id: `news-${item.id}`,
    cloudinary_url: item.featured_image,
    category: 'news',
    user_id: item.created_by,
    created_at: '2023-03-01 09:30:00'
  })
  imageId++
})

// Tạo dữ liệu cho bảng news_tags
const newsTags = [
  { id: 1, name: 'Du lịch', slug: 'du-lich' },
  { id: 2, name: 'Việt Nam', slug: 'viet-nam' },
  { id: 3, name: 'Ẩm thực', slug: 'am-thuc' },
  { id: 4, name: 'Kinh nghiệm', slug: 'kinh-nghiem' },
  { id: 5, name: 'Resort', slug: 'resort' },
  { id: 6, name: 'Biển', slug: 'bien' },
  { id: 7, name: 'Phú Quốc', slug: 'phu-quoc' },
  { id: 8, name: 'Đà Nẵng', slug: 'da-nang' },
  { id: 9, name: 'Hội An', slug: 'hoi-an' },
  { id: 10, name: 'Huế', slug: 'hue' }
]

// Tạo dữ liệu cho bảng news_tag_relations
const newsTagRelations = [
  { news_id: 1, tag_id: 1 },
  { news_id: 1, tag_id: 2 },
  { news_id: 2, tag_id: 1 },
  { news_id: 2, tag_id: 4 },
  { news_id: 3, tag_id: 3 },
  { news_id: 3, tag_id: 10 },
  { news_id: 4, tag_id: 5 },
  { news_id: 4, tag_id: 6 },
  { news_id: 4, tag_id: 7 },
  { news_id: 5, tag_id: 1 },
  { news_id: 5, tag_id: 4 },
  { news_id: 5, tag_id: 8 },
  { news_id: 5, tag_id: 9 }
]

// Tạo dữ liệu cho bảng comments
const comments = [
  {
    id: 1,
    content: 'Bài viết rất hữu ích, cảm ơn tác giả đã chia sẻ!',
    user_id: 3,
    parent_id: null,
    entity_type: 'news',
    entity_id: 1,
    status: 'approved'
  },
  {
    id: 2,
    content:
      'Tôi đã đến Sapa theo hướng dẫn của bài viết và rất hài lòng với chuyến đi.',
    user_id: 4,
    parent_id: null,
    entity_type: 'news',
    entity_id: 2,
    status: 'approved'
  },
  {
    id: 3,
    content: 'Bạn có thể chia sẻ thêm về chi phí cụ thể không?',
    user_id: 5,
    parent_id: 2,
    entity_type: 'news',
    entity_id: 2,
    status: 'approved'
  },
  {
    id: 4,
    content: 'Tôi đã thử món bún bò Huế và cảm thấy rất ngon!',
    user_id: 6,
    parent_id: null,
    entity_type: 'news',
    entity_id: 3,
    status: 'approved'
  },
  {
    id: 5,
    content: 'Tour Hạ Long rất tuyệt vời, cảnh đẹp và dịch vụ tốt.',
    user_id: 7,
    parent_id: null,
    entity_type: 'tour',
    entity_id: 1,
    status: 'approved'
  },
  {
    id: 6,
    content: 'Tôi muốn biết thêm về lịch khởi hành vào tháng 7?',
    user_id: 8,
    parent_id: null,
    entity_type: 'tour',
    entity_id: 3,
    status: 'pending'
  }
]

// Tạo dữ liệu cho bảng contacts
const contacts = [
  {
    id: 1,
    name: 'Nguyễn Văn A',
    email: 'nguyenvana@gmail.com',
    phone: '0912345678',
    subject: 'Yêu cầu thông tin về tour Hạ Long',
    message:
      'Tôi muốn biết thêm thông tin chi tiết về tour Vịnh Hạ Long 3 ngày 2 đêm. Xin vui lòng liên hệ lại cho tôi. Cảm ơn!',
    status: 'read',
    ip_address: '192.168.1.1',
    user_agent:
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
  },
  {
    id: 2,
    name: 'Trần Thị B',
    email: 'tranthib@gmail.com',
    phone: '0923456789',
    subject: 'Đặt tour Đà Nẵng - Hội An',
    message:
      'Tôi muốn đặt tour Đà Nẵng - Hội An cho gia đình 4 người vào tháng 7. Xin vui lòng tư vấn giúp tôi. Cảm ơn!',
    status: 'new',
    ip_address: '192.168.1.2',
    user_agent:
      'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36'
  },
  {
    id: 3,
    name: 'Lê Văn C',
    email: 'levanc@gmail.com',
    phone: '0934567890',
    subject: 'Phản hồi về dịch vụ',
    message:
      'Tôi vừa trải nghiệm tour Phú Quốc và rất hài lòng với dịch vụ của công ty. Cảm ơn đã tạo nên chuyến đi tuyệt vời!',
    status: 'replied',
    ip_address: '192.168.1.3',
    user_agent:
      'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1'
  }
]

// Tạo dữ liệu cho bảng settings
const settings = [
  {
    id: 1,
    key: 'site_name',
    value: 'Du Lịch Việt',
    type: 'text',
    group: 'general'
  },
  {
    id: 2,
    key: 'site_description',
    value: 'Công ty du lịch hàng đầu Việt Nam',
    type: 'text',
    group: 'general'
  },
  {
    id: 3,
    key: 'contact_email',
    value: 'info@dulichviet.com',
    type: 'email',
    group: 'contact'
  },
  {
    id: 4,
    key: 'contact_phone',
    value: '1900 1234',
    type: 'text',
    group: 'contact'
  },
  {
    id: 5,
    key: 'contact_address',
    value: '123 Đường Lê Lợi, Quận 1, TP.HCM',
    type: 'text',
    group: 'contact'
  },
  {
    id: 6,
    key: 'social_facebook',
    value: 'https://facebook.com/dulichviet',
    type: 'url',
    group: 'social'
  },
  {
    id: 7,
    key: 'social_instagram',
    value: 'https://instagram.com/dulichviet',
    type: 'url',
    group: 'social'
  },
  {
    id: 8,
    key: 'social_youtube',
    value: 'https://youtube.com/dulichviet',
    type: 'url',
    group: 'social'
  },
  {
    id: 9,
    key: 'payment_currency',
    value: 'VND',
    type: 'text',
    group: 'payment'
  },
  {
    id: 10,
    key: 'booking_terms',
    value:
      '<h3>Điều khoản đặt tour</h3><p>1. Đặt cọc 50% giá trị tour khi đăng ký.</p><p>2. Thanh toán đầy đủ trước 7 ngày khởi hành.</p><p>3. Hủy tour trước 7 ngày: hoàn 80% tiền cọc.</p><p>4. Hủy tour trước 3-7 ngày: hoàn 50% tiền cọc.</p><p>5. Hủy tour trong vòng 3 ngày: không hoàn tiền cọc.</p>',
    type: 'html',
    group: 'booking'
  }
]

// Tạo dữ liệu cho bảng activity_logs
const activityLogs = [
  {
    id: 1,
    user_id: 1,
    action: 'create',
    entity_type: 'tour',
    entity_id: 1,
    description: 'Tạo tour mới: Tour Vịnh Hạ Long 3 Ngày 2 Đêm',
    ip_address: '192.168.1.1',
    user_agent:
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
  },
  {
    id: 2,
    user_id: 2,
    action: 'create',
    entity_type: 'tour',
    entity_id: 2,
    description: 'Tạo tour mới: Tour Sapa - Fansipan 2 Ngày 1 Đêm',
    ip_address: '192.168.1.2',
    user_agent:
      'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36'
  },
  {
    id: 3,
    user_id: 1,
    action: 'update',
    entity_type: 'tour',
    entity_id: 2,
    description: 'Cập nhật tour: Tour Sapa - Fansipan 2 Ngày 1 Đêm',
    ip_address: '192.168.1.1',
    user_agent:
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
  },
  {
    id: 4,
    user_id: 1,
    action: 'create',
    entity_type: 'news',
    entity_id: 1,
    description:
      'Tạo tin tức mới: Top 10 điểm du lịch hấp dẫn nhất Việt Nam năm 2023',
    ip_address: '192.168.1.1',
    user_agent:
      'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
  },
  {
    id: 5,
    user_id: 3,
    action: 'create',
    entity_type: 'booking',
    entity_id: 1,
    description: 'Đặt tour mới: BK10001',
    ip_address: '192.168.1.3',
    user_agent:
      'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1'
  }
]

// Tạo SQL để chèn dữ liệu
let sqlInserts = ''

// Chèn dữ liệu cho bảng roles
sqlInserts += 'INSERT INTO `roles` (`id`, `name`, `description`) VALUES\n'
roles.forEach((role, index) => {
  sqlInserts += `(${role.id}, '${role.name}', '${role.description}')${
    index < roles.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng permissions
sqlInserts +=
  '\nINSERT INTO `permissions` (`id`, `name`, `description`, `category`) VALUES\n'
permissions.forEach((permission, index) => {
  sqlInserts += `(${permission.id}, '${permission.name}', '${
    permission.description
  }', '${permission.category}')${index < permissions.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng role_permissions
sqlInserts +=
  '\nINSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES\n'
rolePermissions.forEach((rp, index) => {
  sqlInserts += `(${rp.role_id}, ${rp.permission_id})${
    index < rolePermissions.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng users
sqlInserts +=
  '\nINSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `address`, `avatar`, `role_id`, `status`, `email_verified`, `last_login`) VALUES\n'
users.forEach((user, index) => {
  sqlInserts += `(${user.id}, '${user.username}', '${user.email}', '${
    user.password
  }', '${user.full_name}', '${user.phone}', '${user.address}', '${
    user.avatar
  }', ${user.role_id}, '${user.status}', ${
    user.email_verified ? 'TRUE' : 'FALSE'
  }, '${user.last_login}')${index < users.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng user_profiles
sqlInserts +=
  '\nINSERT INTO `user_profiles` (`user_id`, `bio`, `date_of_birth`, `gender`, `website`, `facebook`, `twitter`, `instagram`, `preferences`) VALUES\n'
userProfiles.forEach((profile, index) => {
  sqlInserts += `(${profile.user_id}, '${profile.bio}', '${
    profile.date_of_birth
  }', '${profile.gender}', ${
    profile.website ? `'${profile.website}'` : 'NULL'
  }, '${profile.facebook}', '${profile.twitter}', '${profile.instagram}', '${
    profile.preferences
  }')${index < userProfiles.length - 1 ? ',' : ';'}\n`
  sqlInserts += `(${profile.user_id}, '${profile.bio}', '${
    profile.date_of_birth
  }', '${profile.gender}', ${
    profile.website ? `'${profile.website}'` : 'NULL'
  }, '${profile.facebook}', '${profile.twitter}', '${profile.instagram}', '${
    profile.preferences
  }')${index < userProfiles.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng images
sqlInserts +=
  '\nINSERT INTO `images` (`id`, `title`, `description`, `file_name`, `file_path`, `file_size`, `file_type`, `width`, `height`, `alt_text`, `cloudinary_id`, `cloudinary_url`, `category`, `user_id`, `created_at`) VALUES\n'
images.forEach((image, index) => {
  sqlInserts += `(${image.id}, '${image.title}', '${image.description}', '${
    image.file_name
  }', '${image.file_path}', ${image.file_size}, '${image.file_type}', ${
    image.width
  }, ${image.height}, '${image.alt_text}', '${image.cloudinary_id}', '${
    image.cloudinary_url
  }', '${image.category}', ${image.user_id}, '${image.created_at}')${
    index < images.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng tour_categories
sqlInserts +=
  '\nINSERT INTO `tour_categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `status`) VALUES\n'
tourCategories.forEach((category, index) => {
  sqlInserts += `(${category.id}, '${category.name}', '${category.slug}', '${
    category.description
  }', '${category.image}', ${
    category.parent_id ? category.parent_id : 'NULL'
  }, '${category.status}')${index < tourCategories.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng locations
sqlInserts +=
  '\nINSERT INTO `locations` (`id`, `name`, `slug`, `description`, `image`, `country`, `region`, `latitude`, `longitude`, `status`) VALUES\n'
locations.forEach((location, index) => {
  sqlInserts += `(${location.id}, '${location.name}', '${location.slug}', '${
    location.description
  }', '${location.image}', '${location.country}', '${location.region}', ${
    location.latitude
  }, ${location.longitude}, '${location.status}')${
    index < locations.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng tours
sqlInserts +=
  '\nINSERT INTO `tours` (`id`, `title`, `slug`, `description`, `content`, `duration`, `group_size`, `price`, `sale_price`, `category_id`, `location_id`, `departure_location_id`, `included`, `excluded`, `itinerary`, `meta_title`, `meta_description`, `status`, `featured`, `views`, `created_by`, `updated_by`) VALUES\n'
tours.forEach((tour, index) => {
  const content = tour.content.replace(/'/g, "\\'")
  sqlInserts += `(${tour.id}, '${tour.title}', '${tour.slug}', '${
    tour.description
  }', '${content}', '${tour.duration}', '${tour.group_size}', ${tour.price}, ${
    tour.sale_price
  }, ${tour.category_id}, ${tour.location_id}, ${
    tour.departure_location_id
  }, '${tour.included}', '${tour.excluded}', '${tour.itinerary}', '${
    tour.meta_title
  }', '${tour.meta_description}', '${tour.status}', ${
    tour.featured ? 'TRUE' : 'FALSE'
  }, ${tour.views}, ${tour.created_by}, ${
    tour.updated_by ? tour.updated_by : 'NULL'
  })${index < tours.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng tour_images
sqlInserts +=
  '\nINSERT INTO `tour_images` (`id`, `tour_id`, `image_id`, `is_featured`, `sort_order`) VALUES\n'
tourImages.forEach((image, index) => {
  sqlInserts += `(${image.id}, ${image.tour_id}, ${image.image_id}, ${
    image.is_featured ? 'TRUE' : 'FALSE'
  }, ${image.sort_order})${index < tourImages.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng tour_dates
sqlInserts +=
  '\nINSERT INTO `tour_dates` (`id`, `tour_id`, `start_date`, `end_date`, `price`, `sale_price`, `available_seats`, `status`) VALUES\n'
tourDates.forEach((date, index) => {
  sqlInserts += `(${date.id}, ${date.tour_id}, '${date.start_date}', '${
    date.end_date
  }', ${date.price}, ${date.sale_price}, ${date.available_seats}, '${
    date.status
  }')${index < tourDates.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng bookings
sqlInserts +=
  '\nINSERT INTO `bookings` (`id`, `booking_number`, `user_id`, `tour_id`, `tour_date_id`, `adults`, `children`, `total_price`, `status`, `payment_status`, `payment_method`, `transaction_id`, `special_requirements`) VALUES\n'
bookings.forEach((booking, index) => {
  sqlInserts += `(${booking.id}, '${booking.booking_number}', ${
    booking.user_id
  }, ${booking.tour_id}, ${booking.tour_date_id}, ${booking.adults}, ${
    booking.children
  }, ${booking.total_price}, '${booking.status}', '${
    booking.payment_status
  }', ${booking.payment_method ? `'${booking.payment_method}'` : 'NULL'}, ${
    booking.transaction_id ? `'${booking.transaction_id}'` : 'NULL'
  }, '${booking.special_requirements}')${
    index < bookings.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng payment_methods
sqlInserts +=
  '\nINSERT INTO `payment_methods` (`id`, `name`, `code`, `description`, `instructions`, `logo`, `config`, `is_online`, `sort_order`, `is_active`) VALUES\n'
paymentMethods.forEach((method, index) => {
  sqlInserts += `(${method.id}, '${method.name}', '${method.code}', '${
    method.description
  }', '${method.instructions}', '${method.logo}', '${method.config}', ${
    method.is_online ? 'TRUE' : 'FALSE'
  }, ${method.sort_order}, ${method.is_active ? 'TRUE' : 'FALSE'})${
    index < paymentMethods.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng payments
sqlInserts +=
  '\nINSERT INTO `payments` (`id`, `booking_id`, `payment_method_id`, `transaction_id`, `transaction_id_internal`, `refund_id`, `amount`, `currency`, `status`, `payment_data`, `notes`, `payer_name`, `payer_email`, `payer_phone`, `payment_date`) VALUES\n'
payments.forEach((payment, index) => {
  sqlInserts += `(${payment.id}, ${payment.booking_id}, ${
    payment.payment_method_id
  }, '${payment.transaction_id}', ${
    payment.transaction_id_internal ? payment.transaction_id_internal : 'NULL'
  }, ${payment.refund_id ? payment.refund_id : 'NULL'}, ${payment.amount}, '${
    payment.currency
  }', '${payment.status}', '${payment.payment_data}', '${payment.notes}', '${
    payment.payer_name
  }', '${payment.payer_email}', '${payment.payer_phone}', '${
    payment.payment_date
  }')${index < payments.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng transactions
sqlInserts +=
  '\nINSERT INTO `transactions` (`id`, `transaction_code`, `payment_id`, `amount`, `currency`, `status`, `payment_method`, `payment_data`, `notes`, `customer_name`, `customer_email`, `customer_phone`) VALUES\n'
transactions.forEach((transaction, index) => {
  sqlInserts += `(${transaction.id}, '${transaction.transaction_code}', ${
    transaction.payment_id
  }, ${transaction.amount}, '${transaction.currency}', '${
    transaction.status
  }', '${transaction.payment_method}', '${transaction.payment_data}', '${
    transaction.notes
  }', '${transaction.customer_name}', '${transaction.customer_email}', '${
    transaction.customer_phone
  }')${index < transactions.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng invoices
sqlInserts +=
  '\nINSERT INTO `invoices` (`id`, `invoice_number`, `booking_id`, `payment_id`, `user_id`, `amount`, `tax_amount`, `total_amount`, `status`, `issue_date`, `due_date`, `paid_date`, `notes`, `billing_name`, `billing_address`, `billing_email`, `billing_phone`, `tax_code`) VALUES\n'
invoices.forEach((invoice, index) => {
  sqlInserts += `(${invoice.id}, '${invoice.invoice_number}', ${
    invoice.booking_id
  }, ${invoice.payment_id}, ${invoice.user_id}, ${invoice.amount}, ${
    invoice.tax_amount
  }, ${invoice.total_amount}, '${invoice.status}', '${invoice.issue_date}', '${
    invoice.due_date
  }', '${invoice.paid_date}', '${invoice.notes}', '${invoice.billing_name}', '${
    invoice.billing_address
  }', '${invoice.billing_email}', '${invoice.billing_phone}', ${
    invoice.tax_code ? `'${invoice.tax_code}'` : 'NULL'
  })${index < invoices.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng tour_reviews
sqlInserts +=
  '\nINSERT INTO `tour_reviews` (`id`, `tour_id`, `user_id`, `booking_id`, `rating`, `title`, `review`, `status`) VALUES\n'
tourReviews.forEach((review, index) => {
  sqlInserts += `(${review.id}, ${review.tour_id}, ${review.user_id}, ${
    review.booking_id
  }, ${review.rating}, '${review.title}', '${review.review}', '${
    review.status
  }')${index < tourReviews.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng news_categories
sqlInserts +=
  '\nINSERT INTO `news_categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `status`) VALUES\n'
newsCategories.forEach((category, index) => {
  sqlInserts += `(${category.id}, '${category.name}', '${category.slug}', '${
    category.description
  }', '${category.image}', ${
    category.parent_id ? category.parent_id : 'NULL'
  }, '${category.status}')${index < newsCategories.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng news
sqlInserts +=
  '\nINSERT INTO `news` (`id`, `title`, `slug`, `summary`, `content`, `featured_image`, `category_id`, `meta_title`, `meta_description`, `status`, `featured`, `views`, `created_by`, `updated_by`, `published_at`) VALUES\n'
news.forEach((item, index) => {
  const content = item.content.replace(/'/g, "\\'")
  sqlInserts += `(${item.id}, '${item.title}', '${item.slug}', '${
    item.summary
  }', '${content}', '${item.featured_image}', ${item.category_id}, '${
    item.meta_title
  }', '${item.meta_description}', '${item.status}', ${
    item.featured ? 'TRUE' : 'FALSE'
  }, ${item.views}, ${item.created_by}, ${
    item.updated_by ? item.updated_by : 'NULL'
  }, '${item.published_at}')${index < news.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng news_tags
sqlInserts += '\nINSERT INTO `news_tags` (`id`, `name`, `slug`) VALUES\n'
newsTags.forEach((tag, index) => {
  sqlInserts += `(${tag.id}, '${tag.name}', '${tag.slug}')${
    index < newsTags.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng news_tag_relations
sqlInserts +=
  '\nINSERT INTO `news_tag_relations` (`news_id`, `tag_id`) VALUES\n'
newsTagRelations.forEach((relation, index) => {
  sqlInserts += `(${relation.news_id}, ${relation.tag_id})${
    index < newsTagRelations.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng comments
sqlInserts +=
  '\nINSERT INTO `comments` (`id`, `content`, `user_id`, `parent_id`, `entity_type`, `entity_id`, `status`) VALUES\n'
comments.forEach((comment, index) => {
  sqlInserts += `(${comment.id}, '${comment.content}', ${comment.user_id}, ${
    comment.parent_id ? comment.parent_id : 'NULL'
  }, '${comment.entity_type}', ${comment.entity_id}, '${comment.status}')${
    index < comments.length - 1 ? ',' : ';'
  }\n`
})

// Chèn dữ liệu cho bảng contacts
sqlInserts +=
  '\nINSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `ip_address`, `user_agent`) VALUES\n'
contacts.forEach((contact, index) => {
  sqlInserts += `(${contact.id}, '${contact.name}', '${contact.email}', '${
    contact.phone
  }', '${contact.subject}', '${contact.message}', '${contact.status}', '${
    contact.ip_address
  }', '${contact.user_agent}')${index < contacts.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng settings
sqlInserts +=
  '\nINSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`) VALUES\n'
settings.forEach((setting, index) => {
  const value = setting.value.replace(/'/g, "\\'")
  sqlInserts += `(${setting.id}, '${setting.key}', '${value}', '${
    setting.type
  }', '${setting.group}')${index < settings.length - 1 ? ',' : ';'}\n`
})

// Chèn dữ liệu cho bảng activity_logs
sqlInserts +=
  '\nINSERT INTO `activity_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `description`, `ip_address`, `user_agent`) VALUES\n'
activityLogs.forEach((log, index) => {
  sqlInserts += `(${log.id}, ${log.user_id}, '${log.action}', '${
    log.entity_type
  }', ${log.entity_id}, '${log.description}', '${log.ip_address}', '${
    log.user_agent
  }')${index < activityLogs.length - 1 ? ',' : ';'}\n`
})

// In ra SQL để chèn dữ liệu
console.log(sqlInserts)

// In ra thông tin tóm tắt
console.log('\n--- Tóm tắt dữ liệu mẫu đã tạo ---')
console.log(`Vai trò (roles): ${roles.length}`)
console.log(`Quyền hạn (permissions): ${permissions.length}`)
console.log(`Người dùng (users): ${users.length}`)
console.log(`  - Admin: 1`)
console.log(`  - Moderator: 1`)
console.log(`  - User: ${users.length - 2}`)
console.log(`Hồ sơ người dùng (user_profiles): ${userProfiles.length}`)
console.log(`Hình ảnh (images): ${images.length}`)
console.log(`Danh mục tour (tour_categories): ${tourCategories.length}`)
console.log(`Địa điểm (locations): ${locations.length}`)
console.log(`Tour du lịch (tours): ${tours.length}`)
console.log(`Ảnh tour (tour_images): ${tourImages.length}`)
console.log(`Lịch khởi hành (tour_dates): ${tourDates.length}`)
console.log(`Đặt tour (bookings): ${bookings.length}`)
console.log(
  `Phương thức thanh toán (payment_methods): ${paymentMethods.length}`
)
console.log(`Thanh toán (payments): ${payments.length}`)
console.log(`Giao dịch (transactions): ${transactions.length}`)
console.log(`Hóa đơn (invoices): ${invoices.length}`)
console.log(`Đánh giá tour (tour_reviews): ${tourReviews.length}`)
console.log(`Danh mục tin tức (news_categories): ${newsCategories.length}`)
console.log(`Tin tức (news): ${news.length}`)
console.log(`Tags tin tức (news_tags): ${newsTags.length}`)
console.log(
  `Quan hệ tin tức-tag (news_tag_relations): ${newsTagRelations.length}`
)
console.log(`Bình luận (comments): ${comments.length}`)
console.log(`Liên hệ (contacts): ${contacts.length}`)
console.log(`Cài đặt (settings): ${settings.length}`)
console.log(`Nhật ký hoạt động (activity_logs): ${activityLogs.length}`)

try {
  const filePath = './database_seed.sql'
  fs.writeFileSync(filePath, sqlInserts)
  console.log(`SQL seed data successfully written to: ${filePath}`)
} catch (error) {
  console.error('Error writing SQL seed data:', error.message)
}
