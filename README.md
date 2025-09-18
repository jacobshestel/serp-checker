# Google Organic Rank Checker (Laravel + DataForSEO API)

## 🚀 Quick Start

For experienced users — just 5 commands:

```bash
git clone git@github.com:jacobshestel/serp-checker.git
cd serp-checker
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

➡ Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.  
⚠️ Don’t forget to put your **DataForSEO credentials** into `.env`.

---

## 📖 Detailed Setup

### 1. Clone the repository
```bash
git clone git@github.com:jacobshestel/serp-checker.git
cd serp-checker
```

### 2. Install dependencies
```bash
composer install
```

### 3. Copy environment file
```bash
cp .env.example .env
```

### 4. Update `.env` with your credentials
```dotenv
DATAFORSEO_LOGIN=your_login@email.com
DATAFORSEO_PASSWORD=your_password
```

### 5. Generate Laravel app key
```bash
php artisan key:generate
```

### 6. Start local server
```bash
php artisan serve
```

### 7. Open in browser
[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📝 Features

- Input form with:
  - Search keyword
  - Website (domain or URL)
  - Location
  - Language
- Requests **DataForSEO Google Organic API (Live Advanced)**
- Shows:
  - Website rank (if found in Top 100)
  - Link and title
  - Or message “not found”

---

## 🧪 Example

Search: `Laravel`  
Site: `laravel.com`  
Location: `United States`  
Language: `English`  

➡ Result: **Rank #1**

---

## 📌 Notes

- Project does **not require a database**.  
- Default search engine: **google.com**, device: **desktop**.  
- API usage consumes credits — make sure your DataForSEO account has balance.

---

## 📄 License

This project is for educational/testing purposes only.  
Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
