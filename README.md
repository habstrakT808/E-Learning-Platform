# 🎓 E-Learning Platform

<div align="center">

![E-Learning Platform Logo](https://img.shields.io/badge/E--Learning-Platform-blue?style=for-the-badge&logo=laravel)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)

A comprehensive e-learning platform built with Laravel, featuring course management, student progress tracking, quizzes, assignments, and more.

</div>

## ✨ Features

<div align="center">
  <table>
    <tr>
      <td align="center">👥</td>
      <td><b>User Management</b> - Admin, Instructor, and Student roles</td>
    </tr>
    <tr>
      <td align="center">📚</td>
      <td><b>Course Management</b> - Create, update, and manage courses with sections and lessons</td>
    </tr>
    <tr>
      <td align="center">🛣️</td>
      <td><b>Learning Paths</b> - Structured learning journeys combining multiple courses</td>
    </tr>
    <tr>
      <td align="center">📊</td>
      <td><b>Progress Tracking</b> - Track student progress through courses and lessons</td>
    </tr>
    <tr>
      <td align="center">📝</td>
      <td><b>Quizzes & Assessments</b> - Create and take quizzes with automatic grading</td>
    </tr>
    <tr>
      <td align="center">📋</td>
      <td><b>Assignments</b> - Create, submit, and grade assignments</td>
    </tr>
    <tr>
      <td align="center">💬</td>
      <td><b>Discussions</b> - Course-specific discussion forums</td>
    </tr>
    <tr>
      <td align="center">🏆</td>
      <td><b>Certificates</b> - Generate certificates upon course completion</td>
    </tr>
    <tr>
      <td align="center">🔖</td>
      <td><b>Bookmarks</b> - Save and organize favorite content</td>
    </tr>
    <tr>
      <td align="center">📈</td>
      <td><b>Analytics</b> - Instructor and student dashboards with analytics</td>
    </tr>
  </table>
</div>

## 🛠️ Tech Stack

<div align="center">
  <table>
    <tr>
      <td align="center">⚙️</td>
      <td><b>Backend</b></td>
      <td>Laravel PHP Framework</td>
    </tr>
    <tr>
      <td align="center">🎨</td>
      <td><b>Frontend</b></td>
      <td>Blade Templates with TailwindCSS</td>
    </tr>
    <tr>
      <td align="center">🗄️</td>
      <td><b>Database</b></td>
      <td>MySQL</td>
    </tr>
    <tr>
      <td align="center">🔒</td>
      <td><b>Authentication</b></td>
      <td>Laravel Fortify</td>
    </tr>
  </table>
</div>

## 📋 Prerequisites

Before you begin, ensure you have met the following requirements:

-   PHP >= 8.1
-   Composer
-   MySQL or MariaDB
-   Node.js & NPM
-   Web server (Apache/Nginx)

## 🚀 Installation

1. **Clone the repository**

```bash
    git clone https://github.com/habstrakT808/E-Learning-Platform.git
    cd E-Learning-Platform
```

2. **Install dependencies**

```bash
    composer install
    npm install
```

3. **Set up environment variables**

```bash
    cp .env.example .env
    php artisan key:generate
```

4. **Configure your database in the `.env` file**

```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=elearning
    DB_USERNAME=root
    DB_PASSWORD=
```

5. **Run migrations and seed the database**

```bash
    php artisan migrate
    php artisan db:seed
```

6. **Build frontend assets**

```bash
    npm run dev
```

7. **Start the development server**

```bash
    php artisan serve
```

## 👤 Default Accounts

After seeding, you can log in with the following accounts:

<div align="center">
  <table>
    <tr>
      <th>Role</th>
      <th>Email</th>
      <th>Password</th>
    </tr>
    <tr>
      <td><b>Admin</b></td>
      <td>admin@elearning.com</td>
      <td>password</td>
    </tr>
    <tr>
      <td><b>Instructor</b></td>
      <td>instructor@elearning.com</td>
      <td>password</td>
    </tr>
    <tr>
      <td><b>Student</b></td>
      <td>student@elearning.com</td>
      <td>password</td>
    </tr>
  </table>
</div>

## 📷 Screenshots

<div align="center">
  <table>
    <tr>
      <th>Page</th>
      <th>Screenshot</th>
      <th>Description</th>
    </tr>
    <tr>
      <td><b>🏠 Dashboard</b></td>
      <td><img src="https://github.com/user-attachments/assets/dfc9e0ee-bc07-482b-938b-15becc7772ca" width="300" alt="Dashboard"></td>
      <td>Main dashboard with overview of courses and activities</td>
    </tr>
    <tr>
      <td><b>📚 Courses</b></td>
      <td><img src="https://github.com/user-attachments/assets/6331e210-f452-4bff-ae1d-6e85af3f8ef7" width="300" alt="Courses"></td>
      <td>Browse and explore available courses</td>
    </tr>
    <tr>
      <td><b>ℹ️ About</b></td>
      <td><img src="https://github.com/user-attachments/assets/08494256-a6b4-45fc-ad10-608861c55e91" width="300" alt="About"></td>
      <td>Platform information and features overview</td>
    </tr>
    <tr>
      <td><b>🔐 Sign In</b></td>
      <td><img src="https://github.com/user-attachments/assets/b8ee4390-4b43-4c18-ab4f-ee9a0150cde7" width="300" alt="Sign In"></td>
      <td>User authentication and login interface</td>
    </tr>
    <tr>
      <td><b>📝 Sign Up</b></td>
      <td><img src="https://github.com/user-attachments/assets/7e2203e4-26e8-40aa-9e94-c58908b4db69" width="300" alt="Sign Up"></td>
      <td>New user registration form</td>
    </tr>
    <tr>
      <td><b>🎓 Student Dashboard</b></td>
      <td><img src="https://github.com/user-attachments/assets/b60d99e3-373e-4334-a1f3-1bf3e7a122b2" width="300" alt="Student Dashboard"></td>
      <td>Personalized student learning dashboard</td>
    </tr>
    <tr>
      <td><b>📖 Student Course</b></td>
      <td><img src="https://github.com/user-attachments/assets/7b11bad6-fab7-476a-988a-308b3612583b" width="300" alt="Student Course"></td>
      <td>Course content and lesson interface</td>
    </tr>
    <tr>
      <td><b>🏆 Certificate</b></td>
      <td><img src="https://github.com/user-attachments/assets/5e323141-959f-420f-9c8e-0898fe1ed779" width="300" alt="Certificate"></td>
      <td>Course completion certificate generation</td>
    </tr>
    <tr>
      <td><b>🔖 Bookmark</b></td>
      <td><img src="https://github.com/user-attachments/assets/123b7f81-e50e-4627-9e1b-379c033843c4" width="300" alt="Bookmark"></td>
      <td>Saved courses and content bookmarks</td>
    </tr>
    <tr>
      <td><b>⚙️ Profile Setting</b></td>
      <td><img src="https://github.com/user-attachments/assets/dc35248d-0383-4c46-ae84-662df115139f" width="300" alt="Profile Setting"></td>
      <td>User profile management and settings</td>
    </tr>
    <tr>
      <td><b>📋 Course Detail</b></td>
      <td><img src="https://github.com/user-attachments/assets/3dc4b97b-cce4-4e80-97b4-951a1039be47" width="300" alt="Course Detail"></td>
      <td>Detailed course information and curriculum</td>
    </tr>
    <tr>
      <td><b>❓ Quiz</b></td>
      <td><img src="https://github.com/user-attachments/assets/24a692b4-4baa-4ecf-8782-c9f7c09c40d8" width="300" alt="Quiz"></td>
      <td>Interactive quiz and assessment interface</td>
    </tr>
    <tr>
      <td><b>📊 Quiz Review</b></td>
      <td><img src="https://github.com/user-attachments/assets/feb5f301-7545-419d-be74-5a136a00ba1e" width="300" alt="Quiz Review"></td>
      <td>Quiz results and performance review</td>
    </tr>
  </table>
</div>

<div align="center">
  <p><i>And Many More Features Available!</i></p>
</div>

## 🔧 Configuration

The platform can be configured through the admin dashboard or by editing the `.env` file for environment-specific settings.

## 📚 Documentation

Detailed documentation for administrators, instructors, and students is available in the admin dashboard.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License.

## 📞 Contact

<div align="center">
  <table>
    <tr>
      <th>Platform</th>
      <th>Username/Handle</th>
      <th>Link</th>
    </tr>
    <tr>
      <td>
        <img src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white" alt="GitHub">
      </td>
      <td><b>habstrakT808</b></td>
      <td><a href="https://github.com/habstrakT808">@habstrakT808</a></td>
    </tr>
    <tr>
      <td>
        <img src="https://img.shields.io/badge/Instagram-E4405F?style=for-the-badge&logo=instagram&logoColor=white" alt="Instagram">
      </td>
      <td><b>hafiyan_a_u</b></td>
      <td><a href="https://instagram.com/hafiyan_a_u">@hafiyan_a_u</a></td>
    </tr>
    <tr>
      <td>
        <img src="https://img.shields.io/badge/Gmail-D14836?style=for-the-badge&logo=gmail&logoColor=white" alt="Email">
      </td>
      <td><b>jhodywiraputra@gmail.com</b></td>
      <td><a href="mailto:jhodywiraputra@gmail.com">Send Email</a></td>
    </tr>
    <tr>
      <td>
        <img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white" alt="LinkedIn">
      </td>
      <td><b>habstrakt808</b></td>
      <td><a href="https://linkedin.com/in/habstrakt808">habstrakt808</a></td>
    </tr>
  </table>
</div>

***

<div align="center">
  <p>Built with ❤️ for modern e-learning</p>
  
  ⭐ **If you found this project helpful, please give it a star!** ⭐
</div>
