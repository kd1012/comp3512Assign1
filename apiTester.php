<?php

$apiList = [
    ["api/companies.php", "Returns a list of all companies information"],
    ["api/companies.php?ref=ADS", "Returns a list of a single companies information (Alliance Data Systems)"],
    ["api/companies.php?ref=LMT", "Returns a list of a single companies information (Lockheed Martin Corp.)"],
    ["api/portfolio.php?ref=8", "Returns a list of "],
    ["api/portfolio.php?ref=10", "Returns a list of a single companies information"],
];

/*
 * Builds the API list table from an array of ["url", "description"]
 */
function mkApiTbl($apiList) {
    echo "<table>";

    // Make the table headers
    echo "<tr>";
    echo "<th>URL</th>";
    echo "<th>Description</th>";
    echo "</tr>";

    // Add the actual values
    foreach ($apiList as $row) {
        echo "<tr>";
        echo "<td><a href='$row[0]'>$row[0]</a></td>";
        echo "<td>$row[1]</td>";
        echo "</tr>";
    }

    echo "</table>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/meta.inc.php";?>
    <link rel="stylesheet" href="css/apiTester.css">
</head>
<body>
    <?php require_once "includes/header.inc.php";?>
<main>
    <h2>API List</h2>
    <?php mkApiTbl(); ?>
</main>
<footer>

</footer>
</body>
</html>