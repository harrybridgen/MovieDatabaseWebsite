# Movie Database Web App

By Harry Bridgen

## Overview

A simple web application that allows users to search, add, and remove movies and actors. Developed as part of university coursework using PHP and MySQL, with a focus on CRUD operations, database interaction, and responsive UI using HTML/CSS/JavaScript.

## Features

-   Search for movies and actors with auto-suggestion
-   Add or remove movies and actors via popup forms
-   Upload and display images for movies and actors
-   Prevent deletion of actors linked to movies
-   Live feedback on form submissions
-   Responsive UI with Font Awesome icons

## Technologies

-   PHP (procedural)
-   MySQL
-   HTML/CSS/JavaScript
-   AJAX (for dynamic content)
-   Font Awesome (icons)

## How to Run

1. Set up a local PHP + MySQL environment (e.g. XAMPP).
2. Import the provided database schema (not included here).
3. Create a `config.php` file in the project root with the following:

```php
<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'your_db_name';
?>
```
