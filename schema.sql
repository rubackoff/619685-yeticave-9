CREATE DATABASE IF NOT EXISTS yeticave;
USE yeticave;
CREATE TABLE Categories
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    slug TEXT,
    name TEXT
);

CREATE TABLE Lot
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    dt_add      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name        CHAR(64),
    description TEXT,
    img         CHAR(128),
    start_price FLOAT,
    dt_over   TIMESTAMP,
    step_price  FLOAT,
    user_id INT,
    categories_id INT
);
CREATE TABLE Bet
(
    id     INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price  FLOAT,
    lot_id INT,
    user_id INT
);
CREATE TABLE User
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    dt_add   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email    CHAR(128) NOT NULL UNIQUE,
    name     CHAR(128) NOT NULL UNIQUE,
    password CHAR(64)  NOT NULL
)