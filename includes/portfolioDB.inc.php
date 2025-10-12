<?PHP

/*
 * DB table helper class for portfolio.
 *
 * Similar to those in lab14a
 */
class PortfolioDB {
    private static $SQL_FROM = "FROM portfolio";
    private $db;

    /*
     * Takes in a DatabaseHelper object.
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /*
     * Returns the number of companies on a users portfolio.
     */
    public function getCompaniesCount($userId) {
        $op = "COUNT(id)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            " WHERE userId=?";
        return $this->db->fetchAll($sql, $userId)[0]["$op"];;
    }

}

?>