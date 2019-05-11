CREATE DATABASE IF NOT EXISTS yeticave;
USE yeticave;
CREATE TABLE Categories
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    slug CHAR(128),
    name TEXT
);

CREATE TABLE Lot
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    dt_add      TIMESTAMP,
    name        CHAR(64),
    description TEXT,
    img         CHAR(128),
    start_price FLOAT,
    date_over   TIMESTAMP,
    step_price  FLOAT
);
CREATE TABLE Bet
(
    id     INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP,
    price  FLOAT
);
CREATE TABLE Users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    dt_add   TIMESTAMP,
    email    CHAR(128) NOT NULL UNIQUE,
    name     CHAR(128) NOT NULL UNIQUE,
    password CHAR(64)  NOT NULL
)