# 🥗 Fresh_Home - Hệ Thống Thương Mại Điện Tử Thực Phẩm Sạch

> **Dự án Niên luận ngành Công nghệ thông tin - Đại học Cần Thơ (CTU)**
> **Trạng thái:** Đang hoàn thiện (Dự kiến báo cáo 18/04/2026)

## 📝 Giới thiệu dự án
**Fresh_Home** là một nền tảng thương mại điện tử chuyên cung cấp thực phẩm hữu cơ, rau củ quả và thịt tươi sống. Dự án tập trung vào việc giải quyết bài toán quản lý chuỗi cung ứng thực phẩm sạch và tối ưu hóa trải nghiệm mua sắm trực tuyến thông qua các công nghệ hiện đại.

## ✨ Điểm nhấn kỹ thuật (Highlights)
* **🤖 Tích hợp AI (Gemini API):** Xây dựng Chatbot thông minh hỗ trợ khách hàng tìm kiếm sản phẩm, tư vấn dinh dưỡng và gợi ý công thức nấu ăn trực tiếp trên Website.
* **💳 Thanh toán đa phương thức:** Tích hợp thành công cổng thanh toán quốc tế **PayPal (Sandbox)**, đảm bảo luồng giao dịch an toàn và chuyên nghiệp.
* **🔐 Bảo mật & Xác thực:**
    * Sử dụng **Laravel Socialite** cho phép đăng nhập nhanh qua Google (OAuth2).
    * Phân quyền người dùng (RBAC) chặt chẽ giữa Admin, Nhân viên và Khách hàng qua Middleware.
* **📊 Hệ quản trị cơ sở dữ liệu:** Thiết kế cấu trúc DB tối ưu với **19 bảng quan hệ**, xử lý tốt các logic nghiệp vụ phức tạp từ đơn hàng, kho bãi đến phản hồi khách hàng.

## 🛠 Công nghệ sử dụng
* **Backend:** PHP 8.x, Laravel Framework 10.x.
* **Frontend:** Blade Template, Bootstrap 5, AJAX, JavaScript.
* **Database:** MySQL.
* **API & Tools:** Gemini AI SDK, PayPal REST SDK, Git/GitHub.

## 📂 Cấu trúc tính năng chính
* **Khách hàng:** Xem sản phẩm theo danh mục, tìm kiếm bằng AI, giỏ hàng, thanh toán PayPal, theo dõi đơn hàng, đánh giá sản phẩm.
* **Admin/Staff:** Quản lý kho hàng (CRUD sản phẩm), duyệt đơn hàng, thống kê doanh thu, quản lý người dùng và phản hồi.

## 🚀 Hướng dẫn cài đặt nhanh
1. **Clone project:**
   ```bash
   git clone [https://github.com/TQuocPhu/NL_CNTT_FreshHomeWeb.git](https://github.com/TQuocPhu/NL_CNTT_FreshHomeWeb.git)

2. **Cài đặt môi trường:**
   ```bash
   composer install

3. **Cấu hình file .env:**
   Copy file .env.example thành .env, cấu hình Database và các API Key (Gemini, PayPal).

4. **Khởi tạo dữ liệu:**
   ```bash
   php artisan migrate --seed

4. **Chạy dự án:**
   ```bash
   php artisan serve





