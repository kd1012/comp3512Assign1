<?php
/*
 * Assignment 1 - Portfolio Project
 * COMP 3512 - Web 2, Mount Royal University
 * Diesel Thomas and Kiera Dowell
 * Fall 2025
 *
 * Page Title: History API
 * Page Description:
 * JSON API for the history table.
 * Provides history information about a company from their symbol.
 *
 */

require_once '../includes/config.inc.php';
require_once '../includes/databaseHelper.inc.php';
require_once '../includes/historyDB.inc.php';
require_once '../includes/helperFunctions.inc.php';

define("QUERY_PARAM", "ref");

$hisData = [];
$hasValidData = false;

try {
    $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
    $db->connect();

    $hisDB = new HistoryDB($db);

    if (isQueryParam(QUERY_PARAM)) {
        $symbol = strtoupper($_GET[QUERY_PARAM]);
        $hisData = $hisDB->getHistory($symbol, HistoryDB::ORDER_ASC);
    }

    $db->disconnect();
    $hasValidData = true;

} catch (PDOException $e) { die($e->getMessage()); }

// Ensure Content-Type does not get set if we have an error
if ($hasValidData) {
    header('Content-Type: application/json');
    echo json_encode($hisData, JSON_NUMERIC_CHECK + JSON_PRETTY_PRINT);
}
?>


