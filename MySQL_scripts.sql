CREATE TABLE Images (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,    
    category VARCHAR(30),
    width INT NOT NULL,
    height INT NOT NULL,
    size INT NOT NULL,
    source VARCHAR(30),
    image_path VARCHAR(8000) NOT NULL
);

$insert_query = "INSERT INTO Images(category, width, height, size, source, image_path) VALUES ('".$category."','".$width."','".$height."','".$sizeOfFile."','".$source."','".$target_file."');";

$delete_query = "DELETE FROM Images WHERE id=".$_POST["image_id"];