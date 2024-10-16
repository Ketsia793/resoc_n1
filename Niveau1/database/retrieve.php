<?php 

// Retrieve information from SQL queries
function sqlStructure($sqlQuery, $mysqli) {
    $lesInformations = $mysqli->query($sqlQuery);
    return $lesInformations;
}

?>