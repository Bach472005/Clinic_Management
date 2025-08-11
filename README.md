# 🏥 Clinic Management System

Dự án quản lý phòng khám tâm lý, giúp khách hàng có thể đăng ký lịch khám, quản lý lịch sử khám bệnh, và hỗ trợ quản lý bác sĩ, bệnh nhân, và các dịch vụ y tế.

---

## 🚀 Mục tiêu dự án

Đây là dự án cá nhân nhằm thể hiện khả năng xây dựng ứng dụng web **fullstack** sử dụng các công nghệ hiện đại. Mục tiêu là:
- Xây dựng một hệ thống quản lý phòng khám đơn giản
- Áp dụng kiến thức Laravel backend và Vue.js frontend
- Làm quen với quy trình phát triển phần mềm, CRUD, Auth, RESTful APIs
- Thực hành Docker hoá dự án

---

## 🛠️ Công nghệ sử dụng

| Phía | Công nghệ |
|------|-----------|
| Backend | [Laravel 10.x](https://laravel.com) |
| Frontend | [Vue.js 3](https://vuejs.org), [Tailwind CSS](https://tailwindcss.com) |
| Database | MySQL (qua Docker) |
| DevOps | Docker, Laravel Sail |
| Auth | Laravel Sanctum |
| ORM | Eloquent |
| Tools | Postman, Git, GitHub |

---

## 🔐 Các chức năng chính

- [x] Đăng ký / Đăng nhập người dùng
- [x] Xác thực API bằng Sanctum
- [x] CRUD thông tin bác sĩ
- [x] CRUD thông tin bệnh nhân
- [x] Đặt lịch khám bệnh
- [x] Danh sách lịch khám sắp tới
- [x] Giao diện người dùng đơn giản bằng Vue + Tailwind

---

## 🧪 Cài đặt & chạy thử

### ⚙️ Yêu cầu:
- Docker + Docker Compose
- Git

### 🚀 Cách chạy:

```bash
git clone https://github.com/Bach472005/Clinic_Management.git
cd Clinic_Management

# Copy file cấu hình ví dụ
cp .env.example .env

# Dùng Laravel Sail (Docker)
./vendor/bin/sail up -d

# Cài đặt Laravel
./vendor/bin/sail composer install

# Generate key
./vendor/bin/sail artisan key:generate

# Chạy migration
./vendor/bin/sail artisan migrate

# (Tuỳ chọn) Seed dữ liệu mẫu
./vendor/bin/sail artisan db:seed

👨‍💻 Về tôi
Tôi là sinh viên đang định hướng theo Web Backend hoặc Fullstack Web Development. Dự án này là một trong những sản phẩm thực tế đầu tiên tôi tự triển khai để thực hành các kiến thức học được. Tôi quan tâm đến:

- Laravel & hệ sinh thái PHP

- Vue.js & Frontend framework hiện đại

- Docker, CI/CD cơ bản

- Viết code sạch, dễ mở rộng
💼 Liên hệ
- GitHub: Bach472005

- Email: ph.bach.cv@gmail.com

