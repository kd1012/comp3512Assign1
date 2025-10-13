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

    //the userID from the query string
    $selectedUserId = getUserID();


    //If there is an userId selected
    if ($selectedUserId) {

        $companyCount = $portDB->getCompaniesCount($selectedUserId);
        $portfolioAmount = $portDB->getSharesSum($selectedUserId);
        $portfolioValue = $portDB->getTotalValue($selectedUserId);
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
    echo '<ul>';
    foreach ($customers as $userrow) {
        echo "<li>";
        echo '<span class="name">' . $userrow['lastname'] . ', ' . $userrow['firstname'] . '</span>';
        echo '<form method="get" action="">';
        echo '<input type="hidden" name="userId" value="' . $userrow['id'] . '">';
        echo '<button type="sumbit"> Portfolio </button>';
        echo '</form>';
        echo '</li>';

    }

    echo '</ul>';

}

function outputPortfolio(){
    

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

    <h2>Customers</h2>
    <h1>Name</h1>

    
    <?php
    outputUsersList($customers);

    
    /*
    if a user is seleected then the stuff shows up

    */

    if ($selectedUserId): ?>

        <div class="portfolio">
            <h3>Portfolio Summary</h3>
            <p><strong>User ID:</strong> <?= $selectedUserId ?></p>
            <p><strong>Companies owned:</strong> <?= number_format(((float) $companyCount), 0) ?></p>
            <p><strong>Total shares owned:</strong> <?= number_format((float) $portfolioAmount, 0) ?></p>
            <p><strong>Total portfolio value:</strong> $<?= number_format((float) $portfolioValue, 2) ?></p>
        </div>
    <?php endif; ?>


    <main>




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