<!-- 
 Assignment 1 - Portfolio Project
 COMP 3512 - Web 2
 Diesel Thomas and Kiera Dowell
 Fall 2025

 Page Title: Index Page
 Page Description:
 This page acts as a home page.





-->


<?php
require_once 'includes/config.inc.php';
require_once 'includes/databaseHelper.inc.php';
require_once 'includes/companiesDB.inc.php';
require_once 'includes/portfolioDB.inc.php';
require_once 'includes/historyDB.inc.php';
require_once 'includes/usersDB.inc.php';
require_once 'includes/helperFunctions.inc.php';


try {
    $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
    $db->connect();

    //Setting up the DB's
    $portDB = new PortfolioDB($db);
    $compDB = new CompaniesDB($db);
    $userDB = new UsersDB($db);

    //Pulling only firstname, lastname and id
    $customers = $userDB->getCustomers();


    //Prepping the total values for the Portfolio Summary
    $companyCount = null;
    $portfolioAmount = null;
    $portfolioValue = null;
    $portfolioList = null;

    //the userID from the query string
    $selectedUserId = getUserID();


    //If there is an userId selected
    if ($selectedUserId) {

        $companyCount = $portDB->getCompaniesCount($selectedUserId);
        $portfolioAmount = $portDB->getSharesSum($selectedUserId);
        $portfolioValue = $portDB->getTotalValue($selectedUserId);

        //Portfolio on userId
        $portfolioList = $portDB->getPortfolioList($selectedUserId);

        // echo '<pre>';
        // var_dump($portfolioList);
        // echo '</pre>';

    }


    // disconnecting the database
    $db->disconnect();

} catch (PDOException $e) {
    die($e->getMessage());
}


/*
Getting User ID from the query string
*/

function getUserID()
{

    if (!isset($_GET['userId']) || !is_numeric($_GET['userId'])) {
        return null;
    }
    return (int) $_GET['userId'];
}

function outputUsersList($customers)
{
    echo '<div class="customers-panel">';
    echo '<h1> Customers </h1>';
    echo '<h3> Name </h3>';


    echo '<ul class="customer-list">';

    foreach ($customers as $userrow) {
        echo "<li>";
        echo '<span class="name">' . $userrow['lastname'] . ', ' . $userrow['firstname'] . '</span>';
        echo '<form method="get" action="">';
        echo '<input type="hidden" name="userId" value="' . $userrow['id'] . '">';
        echo '<button type="sumbit" class="btn btn-secondary"> Portfolio </button>';
        echo '</form>';
        echo '</li>';

    }

    echo '</ul>';
    echo '</div>';


}

function outputPortfolioSummary($selectedUserId, $companyCount, $portfolioAmount, $portfolioValue)
{

    /*
    if a user is seleected then the stuff shows up
    */

    if ($selectedUserId) {

        echo '<div class="portfolio-summary">';
        echo '<h3>Portfolio Summary</h3>';
        echo '<div class="summary-row">';
        echo '<div class="summary-card">';
        echo '<span class="summary-label">Companies</span>';
        echo '<span class="summary-value">' . num2Str($companyCount) . '</span>';
        echo '</div>';
        echo '<div class="summary-card">';
        echo '<span class="summary-label"># Shares</span>';
        echo '<span class="summary-value">' . num2Str($portfolioAmount) . '</span>';
        echo '</div>';
        echo '<div class="summary-card total">';
        echo '<span class="summary-label">Total Value</span>';
        echo '<span class="summary-value">$' . num2Str($portfolioValue) . '</span>';
        echo '</div>';
        echo '</div>'; // summary-row
        echo '</div>';
    } else {
        echo '<div class="portfolio-placeholder">';
        echo '<p>Select a customer to view their portfolio.</p>';
        echo '</div>';
    }


}

function outputPortfolioList($portfolioList)
{

    /*
    Do stuff if there is things in portfolio list
    */

    if (!empty($portfolioList)) {
        echo '<div class="portfolio-details">';
        echo '<h3>Portfolio Details</h3>';
        echo "<table class='portfolio-table'>";
        echo "<tr><th>Symbol</th><th>Name</th><th>Sector</th><th>Amount</th><th>Value</th></tr>";

        foreach ($portfolioList as $row) {

            echo "<tr>";
            echo "<td><a href='companyPage.php?symbol=" . $row["symbol"] . "'>" . $row["symbol"] . "</td>";
            echo "<td><a href='companyPage.php?symbol=" . $row["symbol"] . "'>" . $row['name'] . "</td>";
            echo "<td>" . $row['sector'] . "</td>";
            echo "<td>" . $row['amount'] . "</td>";
            echo "<td>$" . number_format($row['value'], 2) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once "includes/meta.inc.php"; ?>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/common.css">
</head>

<body id="indexbody">
    <?php require_once "includes/header.inc.php"; ?>

    <main class="content-container">


        <?php outputUsersList($customers); ?>


        <section class="portfolio-panel">
            <?php
            outputPortfolioSummary($selectedUserId, $companyCount, $portfolioAmount, $portfolioValue);
            outputPortfolioList($portfolioList);
            ?>
        </section>

    </main>



    </main>

    <footer>

    </footer>


</body>

</html>
