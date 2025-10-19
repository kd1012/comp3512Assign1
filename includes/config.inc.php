<!-- 
 Assignment 1 - Portfolio Project
 COMP 3512 - Web 2
 Diesel Thomas and Kiera Dowell
 Fall 2025

 Page Title: Config File setup
 Page Description:





-->


<?php

define('DB_PATH', realpath(__DIR__ . '/../data/stocks.db'));
define('DB_CONNSTRING', 'sqlite:' . DB_PATH);
define('DB_USER', '');
define('DB_PASS', '');

?>
