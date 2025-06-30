<?php
function get_suggestions($query, $table, $column, $suggestionsDivId, $inputId)
{
    $db_host = 'your-db-host';
    $db_user = 'your-db-user';
    $db_pass = 'your-db-pass';
    $db_name = 'your-db-name';

    $connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($connection->connect_errno) {
        echo "Failed to connect to database";
        exit();
    }

    $sql = "SELECT $column FROM $table WHERE $column LIKE ? LIMIT 10";
    $statement = $connection->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $statement->bind_param("s", $searchTerm);
    $statement->execute();
    $statement->bind_result($resultName);

    $results = array();

    while ($statement->fetch()) {
        $escapedName = htmlentities($resultName);
        $results[] = "<div class='suggestion-item' onclick=\"selectSuggestion(this, '$inputId', '$suggestionsDivId')\">$escapedName</div>";
    }

    $connection->close();
    return $results;
}

if (isset($_GET['t']) && isset($_GET['q']) && isset($_GET['d']) && isset($_GET['i']) && isset($_GET['f'])) {
    $table = $_GET['t'];
    $query = $_GET['q'];
    $suggestionsDivId = $_GET['d'];
    $inputId = $_GET['i'];
    $feature = $_GET['f'];
    $response = '';
    $suggestions = get_suggestions($query, $table, $feature, $suggestionsDivId, $inputId);

    foreach ($suggestions as $suggestion) {
        $response .= $suggestion;
    }

    echo $response;
}
?>