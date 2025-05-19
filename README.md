# Artify 🎨

Artify is a Laravel-based web application designed to [briefly describe your project’s purpose—e.g., showcase, manage, or sell art pieces]. Built with Laravel's powerful MVC framework, Artify is robust, secure, and scalable.

---

## 🛠️ Tech Stack

- PHP 8.x  
- Laravel 10.x  
- MySQL / PostgreSQL  
- Composer  
- Node.js & NPM  
- [Frontend stack like Vue.js, React, or Blade]

---

## 📦 Installation

1. Clone the repo:
```bash
   git clone https://github.com/ricardohenrique/artify.git
   cd artify
   ```

2. Install dependencies::
```bash
   composer install
   npm install && npm run dev
   ```

3. Copy .env and generate app key:
```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database in .env, then run migrations:
```bash
   php artisan migrate
   ```

5. (Optional) Seed the database:
```bash
   php artisan db:seed
   ```

6. (Optional) Storage Link:
```bash
   php artisan storage:link
   ```

7. Start the local server:
```bash
   php artisan serve
   ```

---

## ✅ Usage
Access the app at http://localhost:8000.

🔒 Environment Configuration
Make sure to set the following variables in your .env file:

```bash
APP_NAME=Artify
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```

---

## 📁 Directory Structure
Typical Laravel project structure:

```bash
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

---

## 🧪 Running Tests

```bash
php artisan test
```

## 🙌 Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you’d like to change.

## 📄 License
MIT

## ✨ Credits
Developed by Ricardo Mota
