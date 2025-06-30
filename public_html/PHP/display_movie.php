<?php
$search = $_GET['value'];
$db_host = 'your-db-host';
$db_user = 'your-db-user';
$db_pass = 'your-db-pass';
$db_name = 'your-db-name';

$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($connection->connect_errno) {
    echo "Failed to connect to database";
    exit();
}

$sql = "SELECT Movie.movieID, Movie.movieName, Movie.movieRating, Movie.movieYear, Movie.movieImage, Movie.movieGenre, Actor.actorName
          FROM Movie
          JOIN Actor ON Movie.actorID = Actor.actorID
          WHERE Movie.movieName = ?";

$statement = $connection->prepare($sql);
$statement->bind_param("s", $search);
$statement->execute();
$statement->bind_result($movieID, $movieName, $movieRating, $movieYear, $movieImage, $movieGenre, $actorName);
$statement->fetch();
if (empty($movieName)) {
    ?>

    <div class="movie-details">
        <p><strong>Movie not found</strong></p>
    </div>

    <?php
    return;
}
if (empty($movieImage)) {
    ?>
    <div class="movie-container">
        <div class="movie-image">
            <form id="upload-form" onsubmit="submitFormPopup(event, 'form-response', 'PHP/upload_image.php')">
                <label for="image">Upload an image for this movie</label>
                <br>
                <input type="file" id="image" name="image" accept="image/*" required>
                <br><br>
                <input type="submit" value="Upload">
                <input type="hidden" name="id" value="<?php echo htmlentities($movieID); ?>">
                <input type="hidden" name="upload_type" value="movie">
            </form>
        </div>
        <div class="movie-details">
            <h2><?php echo htmlentities($movieName); ?></h2>
            <p><strong>Actor: </strong><?php echo htmlentities($actorName); ?></p>
            <p><strong>Year: </strong><?php echo htmlentities($movieYear); ?></p>
            <p><strong>Genre: </strong><?php echo htmlentities($movieGenre); ?></p>
            <p><strong>Rating: </strong><?php echo htmlentities($movieRating); ?>/10</p>
        </div>
    </div>

    <?php
} else {
    ?>
    <div class="movie-container">
        <div class="movie-image">
            <img src="images/movies/<?php echo htmlentities($movieImage); ?>"
                alt="<?php echo htmlentities($movieName); ?>" />
        </div>
        <div class="movie-details">
            <h2><?php echo htmlentities($movieName); ?></h2>
            <p><strong>Actor: </strong><?php echo htmlentities($actorName); ?></p>
            <p><strong>Year: </strong><?php echo htmlentities($movieYear); ?></p>
            <p><strong>Genre: </strong><?php echo htmlentities($movieGenre); ?></p>
            <p><strong>Rating: </strong><?php echo htmlentities($movieRating); ?>/10</p>
        </div>
    </div>

    <?php
}

$statement->close();
$connection->close();
?>