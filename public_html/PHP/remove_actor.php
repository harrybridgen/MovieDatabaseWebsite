<?php
$actorName = $_POST['actor-name'];

$db_host = 'your-db-host';
$db_user = 'your-db-user';
$db_pass = 'your-db-pass';
$db_name = 'your-db-name';

$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($connection->connect_errno) {
    echo "Failed to connect to database";
    exit();
}

$sql = "SELECT actorID, actorImage FROM Actor WHERE actorName = ?";
$statement = $connection->prepare($sql);

if (!$statement) {
    echo "Error preparing statement: " . $connection->error;
    exit();
}

$statement->bind_param("s", $actorName);
$statement->execute();
$statement->bind_result($actorID, $actorImage);
$statement->fetch();
$statement->close();

if ($actorID == null) {
    echo "Actor not found";
    exit();
}

$sql = "SELECT movieID FROM Movie WHERE actorID = ?";
$statement = $connection->prepare($sql);
$statement->bind_param("s", $actorID);
$statement->execute();
$statement->bind_result($movieID);
$statement->fetch();
$statement->close();

if ($movieID != null) {
    echo "Actor $actorName has movies. Remove the associated movies first";
    exit();
}

$sql = "DELETE FROM Actor WHERE actorID = ?";
$statement = $connection->prepare($sql);

if (!$statement) {
    echo "Error preparing statement: " . $connection->error;
    exit();
}

$statement->bind_param("i", $actorID);

if (!($statement->execute())) {
    echo "Error removing Actor: " . $statement->error;
}

echo "Actor $actorName removed successfully";

if ($actorImage && file_exists("../images/actors/$actorImage")) {
    unlink("../images/actors/$actorImage");
    echo "<br>Actor image removed successfully";
}

$statement->close();
$connection->close();
?>