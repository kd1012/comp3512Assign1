<?php
/*
 * Assignment 1 - Portfolio Project
 * COMP 3512 - Web 2, Mount Royal University
 * Kiera Dowell and Diesel Thomas
 * Fall 2025
 *
 * Page Title: Companies Database Helper Class
 * Page Description:
 * Helper class for accessing the companies table.
 *
 */

/*
 * DB table helper class for companies.
 *
 * Similar to those in lab14a
 */
class CompaniesDB {
    private static $SQL_FROM = "FROM companies ";
    private static $SQL_ALL_ATTRS = "symbol, name, sector, subindustry,
                                    address, exchange, website, description,
                                    latitude, longitude, financials ";
    private $db;

    /*
     * Takes in a DatabaseHelper object.
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /*
     * Returns all the information about a company from their symbol.
     */
    public function getCompanyInfo($symbol) {
        $sql = "SELECT " .
            self::$SQL_ALL_ATTRS .
            self::$SQL_FROM .
            "WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0] ?? [];
    }

    /*
     * Returns all information about all companies.
     */
    public function getAllCompanies() {
        // Note: probably best to return a reduced set of information
        // (e.g. symbol, name, description) when returning all companies,
        // However, API requirements did not specify.
        $sql = "SELECT " .
            self::$SQL_ALL_ATTRS .
            self::$SQL_FROM;
        return $this->db->fetchAll($sql);
    }

    /*
     * Decodes the financials text field into a php associative array.
     */
    public static function decodeFinancials($financials) {
        if ($financials == "") {
            return [];
        }

        return json_decode($financials, $associative=true);
    }
}

?>