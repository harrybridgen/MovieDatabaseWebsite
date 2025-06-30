<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$sql = "SELECT Actor.actorID, Actor.actorName, Actor.actorImage, Movie.movieName
            FROM Actor
            LEFT JOIN Movie ON Actor.actorID = Movie.actorID
            WHERE Actor.actorName = ?";

$statement = $connection->prepare($sql);
$statement->bind_param("s", $search);
$statement->execute();
$statement->bind_result($actorID, $actorName, $actorImage, $movieName);

$movies = array();
while ($statement->fetch()) {
    if (!empty($movieName)) {
        $movies[] = $movieName;
    }
}

if (empty($actorName)) {
    ?>

    <div class="movie-details">
        <p><strong>Actor not found</strong></p>
    </div>

    <?php
    return;
}
if (empty($actorImage)) {
    ?>

    <div class="movie-container">
        <div class="movie-image">
            <form id="upload-form" onsubmit="submitFormPopup(event, 'form-response', 'PHP/upload_image.php')">
                <label for="image">Upload an image for this Actor</label>
                <br>
                <input type="file" id="image" name="image" accept="image/*" required>
                <br><br>
                <input type="submit" value="Upload">
                <input type="hidden" name="id" value="<?php echo htmlentities($actorID); ?>">
                <input type="hidden" name="upload_type" value="actor">
            </form>
        </div>
        <div class="movie-details">
            <h2><?php echo htmlentities($actorName); ?></h2>
            <p><strong>Movies:</strong></p>

            <?php if (!empty($movies)) {
                foreach ($movies as $movie) { ?>

                    <p><?php echo htmlentities($movie); ?></p>

                <?php }
            } else { ?>

                <p>No movies found for this actor</p>

            <?php } ?>
        </div>
    </div>

    <?php
} else {
    ?>

    <div class="movie-container">
        <div class="movie-image">
            <img src="images/actors/<?php echo htmlentities($actorImage); ?>"
                alt="<?php echo htmlentities($actorName); ?>" />
        </div>
        <div class="movie-details">
            <h2><?php echo htmlentities($actorName); ?></h2>
            <p><strong>Movies:</strong></p>

            <?php if (!empty($movies)) {
                foreach ($movies as $movie) { ?>

                    <p><?php echo htmlentities($movie); ?></p>

                <?php }
            } else { ?>

                <p>No movies found for this actor</p>

            <?php } ?>
        </div>
    </div>

    <?php
}
$statement->close();
$connection->close();
?>