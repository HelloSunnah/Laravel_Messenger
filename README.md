<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Laravel Realtime Chat App – Project Setup Guide</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        p {
            font-size: 1.1em;
            color: #555;
        }
        pre {
            background-color: #282c34;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            font-family: "Courier New", Courier, monospace;
            overflow-x: auto;
        }
        .section {
            margin-bottom: 40px;
        }
        .emoji {
            font-size: 1.5em;
        }
        .highlight {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

    <h1 class="emoji">🚀 Laravel Realtime Chat App – Project Setup Guide</h1>
    <p>Welcome to the <span class="highlight">Laravel Realtime Chat Application</span>! Let's get your local environment up and running smoothly in just a few steps. 💻✨</p>

    <div class="section">
        <h2 class="emoji">📦 1. Clone & Install Dependencies</h2>
        <pre>
git clone <your-repository-url>
cd <your-project-folder>
composer install
        </pre>
    </div>

    <div class="section">
        <h2 class="emoji">⚙️ 2. Environment Configuration</h2>
        <pre>
cp .env.example .env
php artisan key:generate
        </pre>
    </div>

    <div class="section">
        <h2 class="emoji">🗄️ 3. Database Setup</h2>
        <p>Ensure your database is created, then run the following command:</p>
        <pre>
mysql -u your_username -p your_database_name < your_sql_file.sql
        </pre>
    </div>

    <div class="section">
        <h2 class="emoji">🛠️ 4. Post-Setup Commands</h2>
        <p>Run the following commands to complete the setup:</p>
        <pre>
php artisan storage:link
php artisan passport:keys
php artisan passport:client --personal
        </pre>
    </div>

    <div class="section">
        <h2 class="emoji">▶️ 5. Run the Project</h2>
        <p>Start the Laravel server:</p>
        <pre>
php artisan serve
        </pre>
        <p>And the <strong>Reverb Broadcasting Server</strong>:</p>
        <pre>
php artisan reverb:start
        </pre>
    </div>

    <div class="section">
        <h2 class="emoji">💬 Features:</h2>
        <ul>
            <li><strong>Real-time messaging</strong></li>
            <li><strong>Typing indicators</strong></li>
            <li><strong>Live updates</strong></li>
        </ul>
        <p>All powered by <strong>Laravel</strong>! 💙</p>
    </div>

    <div class="section">
        <h2 class="emoji">🧠 Pro Tips:</h2>
        <ol>
            <li>Ensure your <strong>.env</strong> is correctly set up for Broadcasting, Passport, and your Database.</li>
            <li>If broadcasting isn't working, run a queue worker:</li>
        </ol>
        <pre>
php artisan queue:work
        </pre>
    </div>

    <div class="section">
        <p>Happy coding and enjoy building this awesome <strong>Laravel-powered chat app</strong>! 😎</p>
        <p><strong>Built with ❤️ using Laravel</strong></p>
    </div>

</body>
</html>
