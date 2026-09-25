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

## Local Setup

1. Create a MySQL database and import the SQL files from `sql/`.
2. Configure your local database connection in `config.php`.
3. Serve the repository through Apache/PHP, for example with XAMPP or WAMP.
4. Open the local application URL in a browser.

Use development credentials locally and avoid committing production database passwords.
