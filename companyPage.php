<?php
require_once 'includes/config.inc.php';
require_once 'includes/databaseHelper.inc.php';
require_once 'includes/companiesDB.inc.php';
require_once 'includes/historyDB.inc.php';
require_once 'includes/helperFunctions.inc.php';

try {
    $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
    $db->connect();

    $hisT = new HistoryDB($db);

    $data = $hisT->getAllHistory("MMM");

    $db->disconnect();

} catch (PDOException $e) { die($e->getMessage()); }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/meta.inc.php";?>
</head>
<body>
    <?php require_once "includes/header.inc.php";?>
    <main>
    <pre>
    <?php print_r($data); ?>
    </pre>

    </main>
    <footer>

    </footer>
</body>
</html>