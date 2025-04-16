🚀 Laravel Realtime Chat App – Project Setup Guide
Welcome to the Laravel project! Follow these steps to get your environment up and running smoothly.

---

## 📦 1. Clone & Install

```bash
git clone <your-repository-url>
cd <your-project-folder>
composer install
⚙️ 2. Environment Configuration

cp .env.example .env
php artisan key:generate
🗄️ 3. Database Setup
mysql -u your_username -p your_database_name < your_sql_file.sql
🛠️ 4. Post-Setup Commands
php artisan storage:link
php artisan passport:keys
php artisan passport:client --personal
▶️ 5. Run the Project
🖥️ Start Laravel Server

php artisan serve
📡 Start Reverb Broadcasting Server
php artisan reverb:start

