<?php
require_once '../includes/config.inc.php';
require_once '../includes/databaseHelper.inc.php';
require_once '../includes/companiesDB.inc.php';
require_once '../includes/helperFunctions.inc.php';

define("QUERY_PARAM", "ref");

$compData = [];
$hasValidData = false;

try {
    $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
    $db->connect();

    $compDB = new CompaniesDB($db);

    if (isQueryParam(QUERY_PARAM)) {
        $symbol = strtoupper($_GET[QUERY_PARAM]);

        // Put single company info in an array to be consistent
        // with the output of getAllCompanies()
        $compData = [$compDB->getCompanyInfo($symbol)];

    } else {
        $compData = $compDB->getAllCompanies();
    }

    $db->disconnect();
    $hasValidData = true;

} catch (PDOException $e) { die($e->getMessage()); }

// Ensure Content-Type does not get set if we have an error
if ($hasValidData) {
    header('Content-Type: application/json');
    echo json_encode($compData, JSON_NUMERIC_CHECK + JSON_PRETTY_PRINT);
}
?>


