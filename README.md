# PHP E-commerce

Small PHP and MySQL e-commerce application with a product catalog, page-based storefront, reusable includes, and database scripts.

## Tech Stack

- PHP
- MySQL
- HTML, CSS, and JavaScript

## Structure

```text
assets/    Frontend resources
includes/  Shared PHP fragments
pages/     Store pages
sql/       Database setup scripts
config.php Database connection configuration
index.php  Application entry point
```

## Run Locally

1. Install XAMPP, WAMP, or another environment that provides Apache, PHP, and MySQL.
2. Start Apache and MySQL from that environment.
3. Copy or clone the repository into the web root, for example `C:\xampp\htdocs\ecommerce`.
4. Open `sql/create_database.sql`. The file creates `ecommerce` but then selects `e_commerce`; make those names match before importing it. The checked-in PHP connection expects `e_commerce`.
5. Import the corrected SQL file with phpMyAdmin or the MySQL CLI:

   ```bash
   mysql -u root -p < sql/create_database.sql
   ```

6. If your MySQL username, password, database name, or project URL differs, update the development values in `includes/db_connect.php`.
7. Open `http://localhost/ecommerce/` in a browser.

Use development credentials locally and avoid committing production database passwords.
