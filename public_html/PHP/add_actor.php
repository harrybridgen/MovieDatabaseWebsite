<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$actorName = $_POST['actor-name'];

if (!($actorName)) {
    exit();
}

$db_host = 'your-db-host';
$db_user = 'your-db-user';
$db_pass = 'your-db-pass';
$db_name = 'your-db-name';

$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($connection->connect_errno) {
    echo "Failed to connect to database";
    exit();
}

$sql = "INSERT INTO Actor (actorName) VALUES (?);";
$statement = $connection->prepare($sql);

if ($statement === false) {
    echo "Error preparing statement: " . $connection->error;
    exit();
}
$statement->bind_param("s", $actorName);

if (!($statement->execute())) {
    echo "Error adding actor: " . $statement->error;
    exit();
}

echo "Actor $actorName added successfully";
$statement->close();
$connection->close();
?>