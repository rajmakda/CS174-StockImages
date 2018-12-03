CREATE TABLE Transactions
(
    id INT(6)
    UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customerId INT NOT NULL REFERENCES Customers
    (id),
    imageId INT NOT NULL REFERENCES Images
    (id),
    date TIMESTAMP NOT NULL
);