CREATE DATABASE moviesdb;
USE moviesdb;

CREATE TABLE movies (
    id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    studio VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    sound VARCHAR(255) NOT NULL,
    versions VARCHAR(255) NOT NULL,
    recretprice VARCHAR(255) NOT NULL,
    rating VARCHAR(255) NOT NULL,
    year INT NOT NULL,
    genre VARCHAR(255) NOT NULL,
    aspect VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

LOAD DATA LOCAL INFILE 'D:/smojo/Documents/xampp/htdocs/Movies.csv' 
INTO TABLE movies 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

ALTER TABLE movies
ADD SearchCount INT NOT NULL; 
