<?php
/*
 * Assignment 1 - Portfolio Project
 * COMP 3512 - Web 2, Mount Royal University
 * Kiera Dowell and Diesel Thomas
 * Fall 2025
 *
 * Page Title: Portfolio API
 * Page Description:
 * JSON API for the portfolio table.
 * Provides a list of portfolios for a customer from their userId.
 *
 */

require_once '../includes/config.inc.php';
require_once '../includes/databaseHelper.inc.php';
require_once '../includes/portfolioDB.inc.php';
require_once '../includes/helperFunctions.inc.php';

define("QUERY_PARAM", "ref");

$portData = [];
$hasValidData = false;

try {
    $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
    $db->connect();

    $portDB = new PortfolioDB($db);

    if (isQueryParam(QUERY_PARAM)) {
        $selectedUserId = strtoupper($_GET[QUERY_PARAM]);

        $portData = $portDB->getAllPortfolio($selectedUserId);

    } 

    $db->disconnect();
    $hasValidData = true;

} catch (PDOException $e) { die($e->getMessage()); }

// Ensure Content-Type does not get set if we have an error
if ($hasValidData) {
    header('Content-Type: application/json');
    echo json_encode($portData, JSON_NUMERIC_CHECK + JSON_PRETTY_PRINT);
}
?>


