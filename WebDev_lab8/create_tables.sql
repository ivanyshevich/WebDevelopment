-- 1. Створюємо базу й обираємо її
CREATE DATABASE IF NOT EXISTS hotel_reservation
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE hotel_reservation;

-- 2. Таблиця кімнат
CREATE TABLE IF NOT EXISTS rooms (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  name     TEXT,
  capacity INT,
  status   VARCHAR(30)
);

-- 3. Таблиця бронювань
CREATE TABLE IF NOT EXISTS reservations (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  name     TEXT,
  start    DATETIME,
  end      DATETIME,
  room_id  INT,
  status   VARCHAR(30),
  paid     INT,
  FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- 4. Тестові дані для rooms
INSERT INTO rooms (name, capacity, status) VALUES
  ('Room 101',    2, 'Ready'),
  ('Room 102',    4, 'Cleaning'),
  ('Room 201',    1, 'Dirty'),
  ('Room 202',    2, 'Ready'),
  ('Suite A',     3, 'Ready'),
  ('Suite B',     5, 'Cleaning'),
  ('Penthouse',   2, 'Ready'),
  ('Economy 301', 2, 'Dirty');

-- 5. Тестові дані для reservations
INSERT INTO reservations (name, start, end, room_id, status, paid) VALUES
  ('Mrs. García',    '2023-01-04','2023-01-12', 1, 'Arrived',    0),
  ('Mr. Jones',      '2023-01-01','2023-01-06', 2, 'Checked out',100),
  ('Mr. Schwartz',   '2023-01-06','2023-01-12', 2, 'Confirmed', 50),
  ('Mr. Gray',       '2023-01-03','2023-01-11', 3, 'Expired',   0),
  ('Mrs. Nguyen',    '2023-01-09','2023-01-15', 4, 'New',       0);