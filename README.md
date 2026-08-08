# SkyReserve

![PHP](https://img.shields.io/badge/PHP-777BB4.svg?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1.svg?logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-XAMPP-red.svg)
![HTML5](https://img.shields.io/badge/HTML5-E34F26.svg?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6.svg?logo=css3&logoColor=white)

A full-stack, database-driven **airline booking application** built with **PHP**, **MySQL**, and **vanilla CSS**.

SkyReserve is an academic project that simulates a real-world airline reservation system, demonstrating how relational database concepts — triggers, foreign keys, and transaction integrity — can be applied in a fully functional web application.

The system lets users search for available flights, register and log in securely, book seats with real-time inventory updates, and view their booking history, all backed by a structured MySQL database. It was built as part of a Database Systems course to bridge theoretical database design with practical web development.

---

## Table of Contents

- [Technical Stack](#-technical-stack)
- [Key Features](#-key-features)
- [Prerequisites](#-prerequisites)
- [Setup Guide](#-setup-guide)
- [Project Structure](#-project-structure)
- [Interface Showcase](#-interface-showcase)
- [Academic Information](#-academic-information)
- [License](#-license)

---

## Technical Stack

| Layer | Technology |
|---|---|
| Backend | PHP |
| Database | MySQL (relational schema with triggers) |
| Frontend | HTML5, vanilla CSS3 (custom design system, responsive layouts) |
| Server / Environment | Apache (via XAMPP / local web server) |

---

## Key Features

- **Flight Search** — Search live flight schedules by source and destination city.
- **User Authentication** — Account registration and secure login session management.
- **Flight Booking & Payment** — Instant seat reservation with real-time seat inventory updates.
- **My Bookings Dashboard** — View past booking details, ticket info, and payment status.
- **Automated Inventory** — MySQL triggers automatically deduct available seat counts on booking confirmation.

---

## Prerequisites

Before running the project, make sure you have:

1. **XAMPP** (bundles Apache, PHP, and MySQL) — [Download XAMPP](https://www.apachefriends.org/)
2. A modern web browser (Chrome, Edge, Firefox, etc.)

---

## Setup Guide

### Step 1 — Copy the Project Folder

Move or clone the **`SkyReserve`** folder into your local XAMPP web server directory:

| OS | Path |
|---|---|
| Windows | `C:\xampp\htdocs\SkyReserve` |
| macOS | `/Applications/XAMPP/htdocs/SkyReserve` |

### Step 2 — Start Apache & MySQL

1. Open the **XAMPP Control Panel**.
2. Click **Start** next to **Apache**.
3. Click **Start** next to **MySQL**.

### Step 3 — Import the Database

1. In the XAMPP Control Panel, click **Admin** next to **MySQL** (or open `http://localhost/phpmyadmin` in your browser).
2. Click **New** on the left sidebar (or **Databases** at the top).
3. Under **Create database**, enter the name: **`skyreserve`**, then click **Create**.
4. Select the newly created **`skyreserve`** database from the left sidebar.
5. Open the **Import** tab.
6. Click **Choose File** and select `skyreserve.sql` from your project folder (`C:\xampp\htdocs\SkyReserve\`).
7. Scroll down and click **Import** (or **Go**).

### Step 4 — Launch the Application

Open your browser and visit:

```text
http://localhost/SkyReserve/
```

---

## Project Structure

```text
SkyReserve
├── .env.example      # Template for environment variables
├── .gitignore        # Excluded files for git repository
├── config.php        # Database connection configuration
├── index.php         # Homepage & flight search widget
├── flights.php       # Available flights listing & filter
├── book.php          # Flight reservation & payment form
├── my_bookings.php   # User booking history dashboard
├── login.php         # User sign-in page
├── register.php      # New account registration page
├── logout.php        # Session termination script
├── style.css         # Custom CSS design system
├── skyreserve.sql    # Complete database DDL & seed data
├── er_diagram.png    # Entity Relationship Diagram
│
├── screenshots/      # Interface previews for documentation
│   ├── home.png
│   ├── login.png
│   ├── register.png
│   ├── flights.png
│   └── book.png
│
└── README.md         # Project documentation
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
