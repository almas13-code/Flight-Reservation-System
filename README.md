# SkyReserve

A modern, full-stack database-driven airline booking application built with **PHP**, **MySQL**, and **Vanilla CSS**.

---

## Technical Stack

- **Backend:** PHP
- **Database:** MySQL (Structured Relational Database with Triggers)
- **Frontend:** HTML5, Vanilla CSS3 (Custom Design System, Responsive Layouts)
- **Web Server & Environment:** Apache (XAMPP / Local Web Server)

---

## What to Download

Before running the project, make sure you have:
1. **XAMPP** (includes Apache, PHP, and MySQL) — [Download XAMPP](https://www.apachefriends.org/)
2. Any web browser (Chrome, Edge, Firefox, etc.)

---

## Step-by-Step Setup Guide

### Step 1: Copy Project Folder
Move or clone the **`SkyReserve`** project folder into your local XAMPP web server directory:
- **Windows:** `C:\xampp\htdocs\SkyReserve`
- **macOS:** `/Applications/XAMPP/htdocs/SkyReserve`

---

### Step 2: Start Apache & MySQL
1. Open **XAMPP Control Panel**.
2. Click **Start** next to **Apache**.
3. Click **Start** next to **MySQL**.

---

### Step 3: Open phpMyAdmin & Import Database SQL File
1. In **XAMPP Control Panel**, click the **Admin** button next to **MySQL** (or open `http://localhost/phpmyadmin` in your browser).
2. Click **Databases** at the top (or click **New** on the left sidebar).
3. Under **Create database**, type the name: **`skyreserve`**
4. Click the **Create** button.
5. Click on the newly created **`skyreserve`** database in the left sidebar.
6. Click the **Import** tab in the top navigation bar.
7. Click **Choose File** (or **Browse**).
8. Navigate to your project folder (`C:\xampp\htdocs\SkyReserve\`) and select **`skyreserve.sql`**.
9. Scroll to the bottom and click **Import** (or **Go**).

---

### Step 4: Open Application
Open your browser and visit:
```text
http://localhost/SkyReserve/
```

---

## Key Features

- **Flight Search:** Search live flight schedules by source and destination cities.
- **User Authentication:** Account registration and secure login session management.
- **Flight Booking & Payment:** Instant seat reservation with real-time seat inventory updates.
- **My Bookings Dashboard:** View past booking details, ticket info, and payment statuses.
- **Automated Inventory:** MySQL triggers automatically deduct available seat counts upon confirmation.

---

## Project Structure

```text
SkyReserve
├── .env.example             # Template for environment variables
├── .gitignore               # Excluded files for git repository
├── config.php               # Database connection configuration
├── index.php                # Homepage & flight search widget
├── flights.php              # Available flights listing & filter
├── book.php                 # Flight reservation & payment form
├── my_bookings.php          # User booking history dashboard
├── login.php                # User sign-in page
├── register.php             # New account registration page
├── logout.php               # Session termination script
├── style.css                # Custom CSS design system
├── skyreserve.sql           # Complete database DDL & seed data
│
├── screenshots/             # Interface previews for documentation
│   ├── home.png
│   ├── login.png
│   ├── register.png
│   ├── flights.png
│   └── book.png
│
└── README.md                # Project documentation
```

---

## Interface Showcase

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

## Academic Information

- **Course:** Database Systems
- **Institution:** BITS Pilani Dubai Campus
- **Project Title:** SkyReserve

---

## License

This project is open source and available for educational and academic purposes.
