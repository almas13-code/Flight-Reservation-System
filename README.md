# SkyReserve

A modern, full-stack database-driven airline booking application built with **PHP**, **MySQL**, and **Vanilla CSS**.

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

### Step 3: Create & Import Database
1. Open your web browser and go to: `http://localhost/phpmyadmin`
2. Click **New** on the left menu and create a database named **`skyreserve`**.
3. Select the **`skyreserve`** database.
4. Click the **Import** tab at the top.
5. Click **Choose File**, select **`skyreserve.sql`** from the project folder, and click **Import** (or **Go**).

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
