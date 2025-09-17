# Google Organic Rank Checker (Laravel + DataForSEO v3)

A simple one–page Laravel application that allows you to check the organic Google search rank of a given website for a specific keyword, location, and language using the **DataForSEO API v3**.

---

## Features
- Input form with fields: **Keyword**, **Website (domain or URL)**, **Location**, **Language**.
- Sends request to **DataForSEO SERP → Google → Organic (live/advanced)**.
- Displays the **organic rank** of the specified website (or shows a message if the site is not found in the top results).
- Error handling for invalid input or API errors.
- Lightweight, runs locally without Docker.

---

## Requirements
- PHP 8.2+
- Composer
- DataForSEO API account and credentials (Login & Password)

---

## Installation & Setup

1. **Clone the repository and install dependencies:**
   ```bash
   git clone https://github.com/your_repo/serp-checker.git
   cd serp-checker
   composer install
   ```

2. **Copy `.env.example` and configure your credentials:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Then edit `.env` and add your DataForSEO credentials:
   ```env
   DATAFORSEO_LOGIN=your_login@email.com
   DATAFORSEO_PASSWORD=your_api_password
   ```

3. **Run the development server:**
   ```bash
   php artisan serve
   ```
   Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## Usage
1. Enter:
   - **Keyword** (e.g., `Laravel framework`)
   - **Website** (e.g., `laravel.com` or `https://laravel.com`)
   - **Location** (e.g., `United States` or `Germany`)
   - **Language** (e.g., `English`, `German`)
2. Click **Search**.
3. The app will display the **organic rank** of the website in Google search results (or a message that it was not found in the top 100).

---

## Notes
- The app uses the endpoint:  
  `POST v3/serp/google/organic/live/advanced`
- Default search domain is `google.com`, depth = 50 results (can be adjusted).
- If the site is not found, try increasing depth to 100 or adjusting location/language.
- In case of timeouts, reduce depth or retry later.

---

## Example
**Input:**
- Keyword: `Laravel`
- Website: `laravel.com`
- Location: `United States`
- Language: `English`

**Output:**
- Rank: `1`
- URL: `https://laravel.com/`
- Title: `Laravel - The PHP Framework For Web Artisans`

---

## License
This project is created as a **test assignment** and is intended for demonstration purposes only.
