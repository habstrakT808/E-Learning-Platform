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
  <p><i>Coming soon...</i></p>
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

If you have any questions, please reach out to the repository owner.

---

<div align="center">
  <p>Built with ❤️ for modern e-learning</p>
</div>
