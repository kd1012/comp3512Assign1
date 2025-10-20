<?php
/*
 * Assignment 1 - Portfolio Project
 * COMP 3512 - Web 2, Mount Royal University
 * Kiera Dowell and Diesel Thomas
 * Fall 2025
 *
 * Page Title: API Tester Page
 * Page Description:
 * Provides example links for the JSON API.
 *
 */

$apiList = [
    [["api/companies.php"], "Returns a list of all companies information."],
    [["api/companies.php?ref=ADS", "api/companies.php?ref=LMT"], "Returns a list with a single company's information."],
    [["api/portfolio.php?ref=8", "api/portfolio.php?ref=10"], "Returns a list of portfolios for a customer ID."],
    [["api/history.php?ref=ADS", "api/history.php?ref=ADI"], "Returns a list of history information of a company's stock."]
];

/*
 * Builds the API list table from an array of [["url1", "url2", ...], "description"]
 */
function mkApiTbl($apiList) {
    echo '<table class="api-table">';

    // Make the table headers
    echo "<tr>";
    echo "<th>URL</th>";
    echo "<th>Description</th>";
    echo "</tr>";

    // Add the actual values
    foreach ($apiList as $row) {
        echo "<tr>";

        echo "<td><ul>";

        foreach ($row[0] as $link) {
            echo "<li><a href='$link'>$link</a></li>";
        }

        echo "</ul></td>";

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
<main class="api-container">
    <section class="api-header">
    <h1>API List</h1>
    <p>Example links for the JSON API</p>
    </section>
    <section>
    <?php mkApiTbl($apiList); ?>
    </section>
</main>

</body>
</html>