<?php

/*
 * Helper class for PDO.
 *
 * Heavily modified from DatabaseHelper in lab14a.
 */
class DatabaseHelper {
    private $pdo;

    /*
     * Connection string, user, and password as per PDO.
     */
    public function __construct($connString, $user, $pass) {
        $this->connString = $connString;
        $this->user = $user;
        $this->pass = $pass;

        $this->pdo = null;
    }

    /*
     * Makes the connection to the database and sets up PDO.
     */
    public function connect() {
        $this->pdo = new PDO($this->connString, $this->user, $this->pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /*
     * Disconnects from the database and takes down PDO.
     */
    public function disconnect() {
        $this->pdo = null;
    }

    /*
     * Run the provided SQL query, with the optional parameters.
     * Returns a PDOStatement.
     *
     * Modified from lab14a.
     */
    public function runQuery($sql, $parameters=null) {
        $statement = null;

        // If there are parameters then do a prepared statement
        if (isset($parameters)) {
            // Ensure parameters are in an array
            if (!is_array($parameters)) {
                $parameters = array($parameters);
            }

            $statement = $this->getPDO()->prepare($sql);
            $executedOk = $statement->execute($parameters);

            if (!$executedOk) {
                throw new PDOException;
            }

        } else {
            // Execute a normal query
            $statement = $this->getPDO()->query($sql);

            if (!$statement) {
                throw new PDOException;
            }
        }

        return $statement;
    }

    /*
     * Shortcut for runQuery()->fetchAll().
     * Returns an array.
     */
    public function fetchAll($sql, $parameters=null) {
        return $this->runQuery($sql, $parameters)->fetchAll();
    }

    /*
     * Returns the PDO object with error checking.
     *
     * Ensures connect() has been ran.
     */
    private function getPDO() {
        if (isset($this->pdo)) {
            return $this->pdo;
        } else {
            throw new PDOException("No connection to database, please run connect() first");
        }
    }
}

?>