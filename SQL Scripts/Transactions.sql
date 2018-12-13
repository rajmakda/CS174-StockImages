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

//find all images purchased by a given customer name (or id if customer name is not unique).

SELECT * FROM Transactions LEFT JOIN Images ON Transactions.imageId = Images.id WHERE Transactions.customerId = '$uuid'