<?php 

// Retrieve information from SQL queries
function sqlStructure($sqlQuery, $mysqli) {
    // $laQuestionEnSql = $sqlQuery;

    $lesInformations = $mysqli->query($sqlQuery);

    // Vérification
    if ( ! $lesInformations)
    {
        echo("Échec de la requete : " . $mysqli->error);
    } 
    else {
        echo "Succès";
    }
    return $lesInformations;
}

?>