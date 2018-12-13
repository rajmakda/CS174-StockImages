CREATE TABLE Images (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,    
    category VARCHAR(30),
    width INT NOT NULL,
    height INT NOT NULL,
    size INT NOT NULL,
    source VARCHAR(30),
    image_path VARCHAR(8000) NOT NULL
);

-- Gets all images with count of number of times purchased by customers
SELECT Images.id, Images.category, Images.width, Images.height, Images.size, Images.source, Images.image_path, COUNT(Transactions.customerId) AS purchased
FROM Images LEFT JOIN Transactions ON Images.id=Transactions.imageId
GROUP BY Images.id
ORDER BY purchased DESC;

-- Gets all customers who purchased an image (by id)
SELECT *
FROM Customers JOIN Transactions WHERE Transactions.imageId = '$imageId' ;
