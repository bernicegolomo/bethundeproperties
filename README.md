# Bethunde Properties - Real Estate Management System

<p align="center">
<a href="https://laravel.com" target="_blank">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</a>
</p>

## Project Overview
Bethunde Properties is a real estate management system built with Laravel, designed to streamline property listings, client interactions, and property inquiries. This project showcases advanced backend development, database management, and integration of modern web technologies.

## Features
- **Property Listings** – Full CRUD for property management
- **User Authentication** – Secure login and registration system
- **Dynamic Search** – Search and filter properties by location, price, and type
- **Image Uploads** – Property images with validation and storage
- **Admin Panel** – Role-based access control and property approvals
- **Contact Management** – Inquiry forms linked to properties

## Technologies Used
- **Laravel** – MVC architecture, Eloquent ORM, and Blade templating
- **MySQL** – Database design and schema migrations
- **Tailwind CSS** – Responsive UI design
- **JavaScript** – Frontend interactivity and AJAX requests
- **Git & GitHub** – Version control and collaboration

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/bernicegolomo/bethundeproperties.git
cd bethunde-properties
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
