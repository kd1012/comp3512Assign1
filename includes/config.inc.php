<?php
/*
 * Assignment 1 - Portfolio Project
 * COMP 3512 - Web 2, Mount Royal University
 * Kiera Dowell and Diesel Thomas
 * Fall 2025
 *
 * Page Title: PDO Database Config
 * Page Description:
 * Defines common parameters for connecting to the database.
 *
 */

define('DB_PATH', realpath(__DIR__ . '/../data/stocks.db'));
define('DB_CONNSTRING', 'sqlite:' . DB_PATH);
define('DB_USER', '');
define('DB_PASS', '');

?>
