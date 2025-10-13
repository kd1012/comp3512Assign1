<?php
//Files to be linked, feel free to comment out any of them if they are not neccesary for that exact file
require_once 'apiTester.php';

require_once 'includes/config.inc.php';
require_once 'includes/header.inc.php';
require_once 'includes/companiesDB.inc.php';
require_once 'includes/databaseHelper.inc.php';
require_once 'includes/portfolioDB.inc.php';
require_once 'includes/historyDB.inc.php';
require_once 'includes/usersDB.inc.php';


require_once 'api/companies.php';
require_once 'api/history.php';
require_once 'api/portfolio.php';




try {
    $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
    $db->connect();

    $portDB = new PortfolioDB($db);
   //$portdata = $portDB->getAll();

    $compDB = new CompaniesDB($db);
   // $compData = $compDB->get();

    $userDB = new UsersDB($db);

    $userData = $userDB ->getAllUsers();
    
    $customers = $userDB ->getCustomers();

    $companyCount = null;
    $portfolioAmount = null;
    $portfolioValue = null;

    $selectedUserId = getUserID();

    echo $selectedUserId;
    
    if($selectedUserId) {

        $companyCount = $portDB ->getCompaniesCount($selectedUserId);
        $portfolioAmount = $portDB ->getSharesSum($selectedUserId);
        echo "outside";
        $portfolioValue = $portDB ->getTotalValue($selectedUserId);

    } 


    $db->disconnect();

} catch (PDOException $e) { die($e->getMessage()); }

/*
Getting User ID from the query string
*/

function getUserID(){

    if (!isset($_GET['userId']) || !is_numeric($_GET['userId'])) {
        return null;
    }
    return (int)$_GET['userId'];
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
<head>
    <?php require_once "includes/meta.inc.php";?>
    <link rel="stylesheet" href="css/index.css">
</head>

</head>

<body id="indexbody">
<?php require_once "includes/header.inc.php";?>

    <h2>Customers</h2>
    <h1>Name</h1>


    <ul>

<?php 

// foreach($customers as $user){

//     echo "<li>";
//     echo "<span class=name>" . $user['firstname'] . ", " . $user['lastname'] . "</span>";
//     echo '<form method="get" action="" >' ;
// }


foreach ($customers as $user): ?>
    <li>
        <span class="name"><?= $user['firstname'] . ' ' . $user['lastname'] ?></span>
        <form method="get" action="">
            <input type="hidden" name="userId" value="<?= $user['id'] ?>">
            <button type="submit">Portfolio</button>
        </form>
    </li>
<?php endforeach; 
?>
</ul>


<?php 
/*
if a user is seleected then the stuff shows up

*/

if ($selectedUserId): ?>

    <div class="portfolio">
        <h3>Portfolio Summary</h3>
        <p><strong>User ID:</strong> <?= $selectedUserId ?></p>
        <p><strong>Companies owned:</strong> <?= number_format(((float)$companyCount),0) ?></p>
        <p><strong>Total shares owned:</strong> <?= number_format((float)$portfolioAmount, 0) ?></p>
        <p><strong>Total portfolio value:</strong> $<?= number_format((float)$portfolioValue, 2) ?></p>
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

?>