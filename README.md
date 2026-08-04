# ✈️ SkyReserve

> A modern, full-stack database-driven airline booking application built with **PHP 8**, **MySQL 8**, **Docker**, and **Vanilla CSS**.

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)

---

## 🌟 Overview

**SkyReserve** automates airline schedule management, user registration, real-time seat availability tracking, and instant booking processing with a sleek, responsive dark-theme user interface.

### ✨ Key Features
- 🛫 **Live Flight Search:** Filter real-time flight schedules by departure and arrival cities.
- 🔐 **User Authentication:** Secure account registration and session management.
- 💳 **Instant Booking & Payment:** Real-time seat reservation, automatic inventory triggers, and multi-payment option support.
- 📊 **User Dashboard:** View past bookings, flight numbers, schedules, and payment statuses.
- ⚡ **Automated Inventory:** MySQL triggers automatically deduct seat counts upon booking confirmation.

---

## ⚡ Quick Start (Docker - 1 Command)

No local PHP or MySQL setup required!

```bash
# 1. Clone the repository
git clone https://github.com/almassiju36/SkyReserve.git
cd SkyReserve

# 2. Launch the application
docker-compose up -d
```
🌐 Open **[http://localhost:8080](http://localhost:8080)** in your browser.

---

## 📸 Interface Showcase

### 1. Landing Page
![Home Page](screenshots/home.png)

### 2. Account Sign In
![Login Page](screenshots/login.png)

### 3. Account Registration
![Register Page](screenshots/register.png)

### 4. Available Flights List
![Flight Listing](screenshots/flights.png)

### 5. Flight Reservation & Payment
![Book Flight](screenshots/book.png)

---

## 🛠️ Alternative Setup (XAMPP / Local Server)

<details>
<summary><b>Click to expand XAMPP & Manual Setup Instructions</b></summary>

<br>

### Prerequisites
- **XAMPP / WAMP / MAMP** (PHP 7.4+ or PHP 8.x, MySQL 5.7+ or MySQL 8.x)

### Step 1: Local Setup
Clone or extract the project into your local web server directory:
- **Windows:** `C:\xampp\htdocs\SkyReserve`
- **macOS:** `/Applications/XAMPP/htdocs/SkyReserve`

### Step 2: Database Import
1. Start **Apache** & **MySQL** in XAMPP Control Panel.
2. Open phpMyAdmin (`http://localhost/phpmyadmin`).
3. Create a new database named **`skyreserve`**.
4. Import **`skyreserve.sql`** into the `skyreserve` database.

### Step 3: Run Application
Visit `http://localhost/SkyReserve/` in your browser.

</details>

---

## 🗄️ Database Architecture

<details>
<summary><b>Click to expand Relational Schema & Advanced DBMS Features</b></summary>

<br>

### Relational Schema Tables
- **`users`** — Accounts (`user_id`, `full_name`, `email`, `phone`, `password`)
- **`flights`** — Schedules (`flight_id`, `flight_number`, `airline_name`, `source_city`, `destination_city`, `departure_time`, `arrival_time`, `available_seats`, `ticket_price`)
- **`bookings`** — Reservations (`booking_id`, `user_id`, `flight_id`, `booking_date`, `seats_booked`, `booking_status`)
- **`payments`** — Transactions (`payment_id`, `booking_id`, `payment_method`, `amount`, `payment_status`)

### Advanced DBMS Features
- **Triggers:** `reduce_seats_after_booking` (automatic inventory deduction), `prevent_negative_seats` (overbooking prevention).
- **Procedures & Functions:** `TotalFlights()`, `TotalRevenue()`, `GetAllFlights()`, `GetFlightsByAirline()`.
- **Views:** `booking_details`, `flight_summary`.

</details>

---

## ❓ Troubleshooting

<details>
<summary><b>Click to expand Common Issues & Fixes</b></summary>

<br>

1. **MySQL Connection Error:** Verify MySQL service is active and check credentials in `config.php`.
2. **Page Not Found (404):** Ensure the folder name in `htdocs` matches `SkyReserve`.
3. **Docker Port Conflict:** Change host port `8080` in `docker-compose.yml` if port is occupied.

</details>

---

## 🎓 Academic Information

- **Course:** Database Systems
- **Institution:** BITS Pilani Dubai Campus
- **Project Title:** SkyReserve

---

## 📄 License
This project is open source and available for educational and academic purposes.
