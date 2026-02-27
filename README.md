Finance Dashboard
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center"><a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a><a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a></p>

🚀 About the Project
The Finance Dashboard is a Laravel-based application designed to manage deposits, transfers, balances, and transaction history.
It provides a clean UI with charts and tables, allowing users to visualize their financial activity in real time.

🛠 Tech Stack
Backend
- PHP 8.x
- Laravel 10.x
- Eloquent ORM (models, relationships)
- MySQL (database)
Frontend
- Blade Templates (view engine)
- Tailwind CSS (utility-first styling)
- Alpine.js (lightweight interactivity)
- Chart.js (data visualization)
Infrastructure
- Composer (PHP dependencies)
- NPM (frontend dependencies)
- Vite (asset bundler)
- Laravel Breeze (authentication scaffolding)

📂 Project Structure
- Repositories → handle database queries (TransactionRepository)
- Services → business logic (DashboardService)
- Models → main entities (Transaction, Transfer, User)
- Blade Components → reusable UI (x-nav-link, x-dropdown)
- Routes → organized under finance.* (deposit, transfer, history)

📊 Features
- 💰 Balance calculation (deposits – transfers sent)
- 📈 Monthly incomes & expenses charts
- 🔄 Transaction history (formatted with sender/receiver, status)
- 📊 Dashboard with latest transactions
- 🔐 Authentication & user profile management
- 📂 Dropdown menus for Finance and User, consistent with Breeze

📌 Architecture Flow
Controller → Service → Repository → Model → Database

- Controller calls the Service layer.
- Service aggregates and prepares data for the view.
- Repository handles queries and formatting.
- Model represents entities and relationships.
- Database stores transactions, transfers, and users.

▶️ Getting Started
# Clone the repository
git clone https://github.com/your-repo.git

# Install PHP dependencies
composer install

# Install frontend dependencies
npm install && npm run dev

# Run migrations
php artisan migrate

# Start local server
php artisan serve

📜 License
This project is licensed under the MIT License.
