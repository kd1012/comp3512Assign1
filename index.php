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
    $userData = $userDB->getAllUsers();

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
        echo '<button type="sumbit" class="button-customers"> Portfolio </button>';
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
        echo '<div class="summary-card"><span class="summary-label"># Shares</span><span class="summary-value">' . num2Str($portfolioAmount) . '</span></div>';
        echo '<div class="summary-card total"><span class="summary-label">Total Value</span><span class="summary-value">$' . num2Str($portfolioValue) . '</span></div>';
        echo '</div>';

    } else {
        echo '<div class="portfolio-placeholder"><p>Select a customer to view their portfolio.</p></div>';
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

<?php

//$db->disconnect();


/*
 * @Kiera
 *
 * getCompaniesCount(), getSharesSum(), and getTotalValue() are showing up as 1 because they are actually returning arrays.
 * Apparently number_format, or maybe the cast to float turns them into 1, presumably because that is the number of elements in the array.
 * I have fixed getCompaniesCount() in portfolioDB.inc.php, see the note in there for a more detailed explanation of the problem and the solution.
 *
 * Some other recommendations I have,
 * For the most part, you shouldn't need to cast variables, php is pretty good at figuring it out, and it could cause weird issues with int to floats
 *
 * (I know your prototyping right now, so this probably doesn't matter just yet, but) try to keep most of your php code before the <html> starts.
 * Try to either save the needed data into variables, or create functions to generate the html, then call/use them inside the html. See companyPage.php
 *
 * I have made some helper function available in helperFunctions.inc.php. Feel free to add to this file! Specifically, I have some formatting functions for
 * dollar values and large numbers (dollar2Str() and num2Str()) that add the $ sign and commas so that formatting will be consistent.
 * Feel free to use your own number_format() if you want though!
 *
 * Also, since companyPage is effectively done, feel free to steal techniques and things from there.
 *
 *
 * For the record, I don't mean any of this in a condescending way. You are doing a great job! and I'm glad that you are my partner!
 *
 */


?>