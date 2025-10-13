<?php

require_once 'includes/config.inc.php';
require_once 'includes/databaseHelper.inc.php';
require_once 'includes/companiesDB.inc.php';
require_once 'includes/historyDB.inc.php';
require_once 'includes/usersDB.inc.php';
require_once 'includes/helperFunctions.inc.php';


try {
    $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
    $db->connect();

    $userDB = new UsersDB($db);
    $userdata = $userDB->getAll();

    $compDB = new CompaniesDB($db);
    $compData = $compDB->getAll();

    

    $db->disconnect();

} catch (PDOException $e) { die($e->getMessage()); }

/*
Getting User ID from the query string
*/

function getUserID(){

    if (!isset($_GET['userId']) || !is_numeric($_GET['userId'])) {
        die("Invalid or missing userId");
    }
    return (int)$_GET['userId'];
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php require_once "includes/meta.inc.php";?>
</head>

<body>
<?php require_once "includes/header.inc.php";?>
    <main>
<?php print_r($data); ?>

    </main>

    <p> Comapnies count </p>

    <?php
    
    echo " <h2> Companies count " . $compDB-> getCompanyCountfromUserID(getUserID()) . "from companies </h2>";


     ?>

    <footer>

    </footer>


</body>

</html>