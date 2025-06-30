<?php
$db_host = 'your-db-host';
$db_user = 'your-db-user';
$db_pass = 'your-db-pass';
$db_name = 'your-db-name';

$id = $_POST['id'];
$upload_type = $_POST['upload_type'];

if (!(isset($_FILES["image"])) || $_FILES["image"]["error"] != 0) {
    echo "Error uploading image. Max size is 2MB.";
    exit();
}

$allowed_types = array("jpg", "jpeg", "png");
$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($connection->connect_errno) {
    echo "Failed to connect to database";
    exit();
}

$table_name = $upload_type == "actor" ? "Actor" : "Movie";
$id_column = $upload_type == "actor" ? "actorID" : "movieID";
$name_column = $upload_type == "actor" ? "actorName" : "movieName";
$image_column = $upload_type == "actor" ? "actorImage" : "movieImage";
$folder_name = $upload_type == "actor" ? "actors" : "movies";

$sql = "SELECT $name_column FROM $table_name WHERE $id_column = ?";
$statement = $connection->prepare($sql);
$statement->bind_param("i", $id);
$statement->execute();
$statement->bind_result($name);
$statement->fetch();

$statement->close();

$file_type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
$file_new_name = str_replace(' ', '_', $name) . '.' . $file_type;
$file_destination = "../images/$folder_name/" . $file_new_name;

if (!(in_array(strtolower($file_type), $allowed_types))) {
    echo "Invalid file type. Only JPG, JPEG and PNG types are allowed.";
    exit();
}

$file_tmp = $_FILES["image"]["tmp_name"];

if (!(move_uploaded_file($file_tmp, $file_destination))) {
    echo "Error uploading image.";
    exit();
}

chmod($file_destination, 0644);

$sql = "UPDATE $table_name SET $image_column = ? WHERE $id_column = ?";
$statement = $connection->prepare($sql);
$statement->bind_param("si", $file_new_name, $id);
$statement->execute();

echo "Image uploaded successfully";

$statement->close();
$connection->close();
?>