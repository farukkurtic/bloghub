# Bloghub - Your Personal Blogging Platform

Bloghub is a web-based blogging platform that allows users to create and manage their own blogs, share their thoughts, and discover content from other users. It's built with PHP, MySQL, Bootstrap, and uses Bcrypt for password encryption.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Prerequisites](#prerequisites)
- [Installation](#installation)


## Features

- **User Authentication**: Secure user registration and login using bcrypt for password hashing.
- **User Blogs**: Users can create and manage their own blogs.
- **Blog Posts**: Create, edit, update and delete blog posts.
- **Discover Page**: Explore and read blog posts from other users.

## Technologies Used

Bloghub is built using the following technologies and tools:

- PHP
- MySQL
- Bootstrap
- bcrypt (for password encryption)

## Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) installed on your local machine.

## Installation

1. Clone this repository: `https://github.com/farukkurtic/Bloghub.git`.
2. Place the cloned directory into your XAMPP's `htdocs` folder (usually located at `C:\xampp\htdocs\` on Windows or `/Applications/XAMPP/htdocs/` on macOS).
3. Start the Apache and MySQL services from your XAMPP control panel.
4. Create the SQL database schema using phpMyAdmin (usually accessible at `http://localhost/phpmyadmin/`).
5. Configure the database connection in `config.php` (located in the `config` directory) by providing your MySQL username, password, and database name.
