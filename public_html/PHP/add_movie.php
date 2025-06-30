<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$actorName = $_POST['actor-name'];
$movieGenre = $_POST['movieGenre'];
$movieName = $_POST['movieName'];
$movieRating = $_POST['movieRating'];
$movieYear = $_POST['movieYear'];

$db_host = 'your-db-host';
$db_user = 'your-db-user';
$db_pass = 'your-db-pass';
$db_name = 'your-db-name';
$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($connection->connect_errno) {
    echo "Failed to connect to database";
    exit();
}

$actorID = null;
$sql = "SELECT actorID FROM Actor WHERE actorName = ?";
$statement = $connection->prepare($sql);

if ($statement === false) {
    echo "Error preparing statement: " . $connection->error;
    exit();
}

$statement->bind_param("s", $actorName);
$statement->execute();
$statement->bind_result($id);

if ($statement->fetch()) {
    $actorID = $id;
}

$statement->close();

if ($actorID == null) {
    echo "Actor $actorName not found";
    exit();
}

$sql = "INSERT INTO Movie (actorID, movieGenre, movieName, movieRating, movieYear) VALUES (?, ?, ?, ?, ?)";
$statement = $connection->prepare($sql);

if ($statement === false) {
    echo "Error preparing statement: " . $connection->error;
    exit();
}

$statement->bind_param("isssi", $actorID, $movieGenre, $movieName, $movieRating, $movieYear);

if (!($statement->execute())) {
    echo "Error adding movie: " . $statement->error;
    exit();
}

echo "Movie $movieName added successfully";

$statement->close();
$connection->close();
?>