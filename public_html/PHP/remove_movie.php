<?php
if (isset($_POST['movie-name'])) {
    $movieName = $_POST['movie-name'];

    $db_host = 'your-db-host';
    $db_user = 'your-db-user';
    $db_pass = 'your-db-pass';
    $db_name = 'your-db-name';

    $connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($connection->connect_errno) {
        echo "Failed to connect to database";
        exit();
    }

    $sql = "SELECT movieID, movieImage FROM Movie WHERE movieName = ?";
    $statement = $connection->prepare($sql);

    if (!$statement) {
        echo "Error preparing statement: " . $connection->error;
        exit();
    }

    $statement->bind_param("s", $movieName);
    $statement->execute();
    $statement->bind_result($movieID, $movieImage);
    $statement->fetch();
    $statement->close();

    if ($movieID == null) {
        echo "Movie not found";
        exit();
    }

    $sql = "DELETE FROM Movie WHERE movieID = ?";
    $statement = $connection->prepare($sql);

    if (!$statement) {
        echo "Error preparing statement: " . $connection->error;
        exit();
    }

    $statement->bind_param("i", $movieID);

    if (!($statement->execute())) {
        echo "Error removing movie: " . $statement->error;
        exit();
    }

    echo "Movie $movieName removed successfully";

    if ($movieImage && file_exists("../images/movies/$movieImage")) {
        unlink("../images/movies/$movieImage");
        echo "<br>Movie image removed successfully";
    }

    $statement->close();
    $connection->close();
}
?>