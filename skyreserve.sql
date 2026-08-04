-- SkyReserve Database Schema

CREATE DATABASE IF NOT EXISTS `skyreserve`;
USE `skyreserve`;

-- ========================================================
-- 1. TABLE STRUCTURES
-- ========================================================

-- Stores registered user details
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Stores available flights and schedule details
DROP TABLE IF EXISTS `flights`;
CREATE TABLE `flights` (
  `flight_id` int NOT NULL AUTO_INCREMENT,
  `flight_number` varchar(20) NOT NULL,
  `airline_name` varchar(100) NOT NULL,
  `source_city` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_time` datetime NOT NULL,
  `available_seats` int NOT NULL,
  `ticket_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`flight_id`),
  UNIQUE KEY `flight_number` (`flight_number`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Stores passenger flight reservation records
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `flight_id` int NOT NULL,
  `booking_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `seats_booked` int NOT NULL,
  `booking_status` varchar(20) DEFAULT 'Confirmed',
  PRIMARY KEY (`booking_id`),
  KEY `user_id` (`user_id`),
  KEY `flight_id` (`flight_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`flight_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Stores payment transactions
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(20) DEFAULT 'Paid',
  PRIMARY KEY (`payment_id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;


-- ========================================================
-- 2. INITIAL SEED DATA
-- ========================================================

-- Insert sample users
INSERT INTO `users` (user_id, full_name, email, password) VALUES 
(1,'Aarav Sharma','aarav.sharma@gmail.com','pass123'),
(2,'Priya Nair','priya.nair@gmail.com','pass123'),
(3,'Rahul Verma','rahul.verma@gmail.com','pass123'),
(4,'Ananya Menon','ananya.menon@gmail.com','pass123'),
(5,'Arjun Reddy','arjun.reddy@gmail.com','pass123'),
(6,'Sneha Kapoor','sneha.kapoor@gmail.com','pass123'),
(7,'Vikram Patel','vikram.patel@gmail.com','pass123'),
(8,'Meera Iyer','meera.iyer@gmail.com','pass123'),
(9,'Aditya Singh','aditya.singh@gmail.com','pass123'),
(10,'Diya Thomas','diya.thomas@gmail.com','pass123'),
(11,'Aisha Rahman','aisha.rahman@gmail.com','Aisha123');

-- Insert sample flight schedules
INSERT INTO `flights` VALUES 
(1,'AI101','Air India','Delhi','Mumbai','2026-06-10 08:00:00','2026-06-10 10:00:00',120,4500.00),
(2,'EK202','Emirates','Dubai','Kochi','2026-06-11 14:00:00','2026-06-11 19:00:00',100,8500.00),
(3,'QR303','Qatar Airways','Doha','London','2026-06-12 09:00:00','2026-06-12 15:00:00',80,12000.00),
(4,'UK404','Vistara','Bangalore','Hyderabad','2026-06-13 07:30:00','2026-06-13 08:45:00',90,3500.00),
(5,'6E505','IndiGo','Chennai','Delhi','2026-06-14 11:00:00','2026-06-14 13:50:00',150,5000.00),
(6,'SG606','SpiceJet','Kolkata','Goa','2026-06-15 15:00:00','2026-06-15 18:00:00',110,6000.00),
(7,'AK707','AirAsia','Kuala Lumpur','Chennai','2026-06-16 06:00:00','2026-06-16 09:30:00',95,7500.00),
(8,'BA808','British Airways','London','New York','2026-06-17 10:00:00','2026-06-17 18:00:00',200,35000.00),
(9,'SQ909','Singapore Airlines','Singapore','Sydney','2026-06-18 12:00:00','2026-06-18 20:00:00',130,28000.00),
(10,'LH010','Lufthansa','Frankfurt','Dubai','2026-06-19 09:00:00','2026-06-19 17:00:00',140,22000.00);

-- Insert sample booking records
INSERT INTO `bookings` VALUES 
(1,1,1,'2026-05-30 13:07:51',2,'Confirmed'),
(2,2,2,'2026-05-30 13:07:51',1,'Confirmed'),
(3,3,3,'2026-05-30 13:07:51',3,'Confirmed'),
(4,4,4,'2026-05-30 13:07:51',1,'Confirmed'),
(5,5,5,'2026-05-30 13:07:51',2,'Confirmed'),
(6,6,6,'2026-05-30 13:07:51',1,'Confirmed'),
(7,7,7,'2026-05-30 13:07:51',4,'Confirmed'),
(8,8,8,'2026-05-30 13:07:51',2,'Confirmed'),
(9,9,9,'2026-05-30 13:07:51',1,'Confirmed'),
(10,10,10,'2026-05-30 13:07:51',3,'Confirmed');

-- Insert sample payment transactions
INSERT INTO `payments` VALUES 
(1,1,'UPI',9000.00,'Paid'),
(2,2,'Credit Card',8500.00,'Paid'),
(3,3,'Debit Card',36000.00,'Paid'),
(4,4,'UPI',3500.00,'Paid'),
(5,5,'Net Banking',10000.00,'Paid'),
(6,6,'Credit Card',6000.00,'Paid'),
(7,7,'Debit Card',30000.00,'Paid'),
(8,8,'UPI',70000.00,'Paid'),
(9,9,'Credit Card',28000.00,'Paid'),
(10,10,'Net Banking',66000.00,'Paid');


-- ========================================================
-- 3. TRIGGERS
-- ========================================================

-- Automatically reduce available flight seats after a new booking is created
DELIMITER $$
CREATE TRIGGER `reduce_seats_after_booking` 
AFTER INSERT ON `bookings` 
FOR EACH ROW 
BEGIN
    UPDATE flights
    SET available_seats = available_seats - NEW.seats_booked
    WHERE flight_id = NEW.flight_id;
END$$
DELIMITER ;

-- Prevent updating available seats to a negative number
DELIMITER $$
CREATE TRIGGER `prevent_negative_seats` 
BEFORE UPDATE ON `flights` 
FOR EACH ROW 
BEGIN
    IF NEW.available_seats < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Available seats cannot be negative';
    END IF;
END$$
DELIMITER ;


-- ========================================================
-- 4. STORED PROCEDURES & FUNCTIONS
-- ========================================================

-- Function: Returns the total number of flights scheduled
DELIMITER $$
CREATE FUNCTION `TotalFlights`() RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM flights;
    RETURN total;
END$$
DELIMITER ;

-- Function: Returns the total revenue collected from payments
DELIMITER $$
CREATE FUNCTION `TotalRevenue`() RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE revenue DECIMAL(10,2);
    SELECT SUM(amount) INTO revenue FROM payments;
    RETURN revenue;
END$$
DELIMITER ;

-- Procedure: Fetches all available flights
DELIMITER $$
CREATE PROCEDURE `GetAllFlights`()
BEGIN
    SELECT * FROM flights;
END$$
DELIMITER ;

-- Procedure: Fetches all registered users
DELIMITER $$
CREATE PROCEDURE `GetAllUsers`()
BEGIN
    SELECT * FROM users;
END$$
DELIMITER ;

-- Procedure: Filters flights by airline name
DELIMITER $$
CREATE PROCEDURE `GetFlightsByAirline`(
    IN airline VARCHAR(100)
)
BEGIN
    SELECT * FROM flights WHERE airline_name = airline;
END$$
DELIMITER ;


-- ========================================================
-- 5. DATABASE VIEWS
-- ========================================================

-- View: Joined view displaying detailed booking information
CREATE OR REPLACE VIEW `booking_details` AS 
SELECT 
    u.full_name,
    f.flight_number,
    f.airline_name,
    f.source_city,
    f.destination_city,
    b.seats_booked,
    p.amount
FROM bookings b
JOIN users u ON b.user_id = u.user_id
JOIN flights f ON b.flight_id = f.flight_id
JOIN payments p ON b.booking_id = p.booking_id;

-- View: Simplified overview of flight details and ticket pricing
CREATE OR REPLACE VIEW `flight_summary` AS 
SELECT 
    flight_number,
    airline_name,
    source_city,
    destination_city,
    ticket_price
FROM flights;
