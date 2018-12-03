CREATE TABLE Customers (
    id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(32) NOT NULL,
    LastName VARCHAR(32) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL
);

 // - find all customers who purchased a given image (by id).

SELECT c.id, c.FirstName, c.LastName, c.username, t.imageId, t.date
FROM Customers AS c JOIN Transactions AS t WHERE t.imageId = '$imageId' ;