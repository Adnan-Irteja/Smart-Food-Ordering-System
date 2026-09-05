# Panda Foods

Panda Foods is a web-based food ordering system developed as a
CSE370 Database Systems project.

The system supports two types of users:

- Customers
- Restaurant Owners

## Features

### Customer
- Customer registration and login
- Edit profile and delivery address
- Browse restaurants by cuisine
- Browse and filter restaurant menus
- Add food items to cart
- Apply restaurant coupons
- Place orders
- Track active orders
- View order history
- Rate and review restaurants

### Restaurant Owner
- Restaurant registration and login
- Add food items
- Edit menu items
- Manage food availability
- Create and delete coupons
- View and manage customer orders
- View customer ratings and reviews

## Technologies Used

- PHP
- MySQL / MariaDB
- HTML
- CSS
- XAMPP

## Running the Project Locally

### Requirements

Install XAMPP, which provides:

- Apache
- PHP
- MySQL / MariaDB
- phpMyAdmin

### Setup

1. Clone or download this repository.

2. Place the project folder inside the XAMPP `htdocs` directory.

   Example:

   C:\xampp\htdocs\Panda-Foods

3. Start **Apache** and **MySQL** from the XAMPP Control Panel.

4. Open phpMyAdmin:

   http://localhost/phpmyadmin

5. Create a database named:

   fooddelivery

6. Import:

   database/fooddelivery.sql

7. Make sure `DBconnect.php` contains the correct database configuration.

8. Open the project in your browser:

   http://localhost/Panda-Foods/
