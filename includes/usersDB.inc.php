<?php
/*
 * Assignment 1 - Portfolio Project
 * COMP 3512 - Web 2, Mount Royal University
 * Diesel Thomas and Kiera Dowell
 * Fall 2025
 *
 * Page Title: Users Database Helper Class
 * Page Description:
 * Helper class for accessing the users table.
 *
 */

/*
 * DB table helper class for users.
 *
 * Similar to those in lab14a
 */
class UsersDB {
    private static $SQL_FROM = "FROM users ";
    private static $SQL_ALL_ATTRS = "id, firstname, lastname, city,
                                    country, email, password, salt,
                                    password_sha256 ";
    private $db;

    /*
     * Takes in a DatabaseHelper object.
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /*
     * Returns a minimal list of all customers.
     *
     * Sorted by last name.
     */
    public function getCustomers() {
        $sql = "SELECT id, firstname, lastname " .
            self::$SQL_FROM .
            "ORDER BY lastname ASC";
        return $this->db->fetchAll($sql);
    }



    // TODO: If we need to JOIN tables, do it in the class that will be the FROM table.
    // Ex. "SELECT ... FROM users ... INNER JOIN portfolio ON ..." would end up here.
    // More than likely all joins will be in here.



}

?>