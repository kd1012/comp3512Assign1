<?PHP

/*
 * DB table helper class for portfolio.
 *
 * Similar to those in lab14a
 */
class PortfolioDB {
    private static $SQL_FROM = " FROM portfolio ";
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
        $sql = "SELECT $op" .
            self::$SQL_FROM .
            "WHERE userId=? LIMIT 1";
        return $this->db->fetchAll($sql, $userId)[0][$op] ?? null;
    }


    /*
    * Returns the sum of the portfolio amount field, it will be used in the number of shares section

    */

    public function getSharesSum ($userId){

        $op = "SUM(amount)";
        $sql = "SELECT $op" .
            self::$SQL_FROM .
            "WHERE userId=?";

        return $this->db->fetchAll($sql, $userId)[0][$op] ?? null;

    }

    /*
    * The total value is the value of the users portfolio can be determined by adding the value
    (closing stock price of the last history record of that stock * amount of stock owned) for each of the stocks
    in the portfolio
    */

    public function getTotalValue ($userID){

        $op = "SUM(portfolio.amount * (SELECT history.close FROM history WHERE history.symbol = portfolio.symbol ORDER BY history.date DESC LIMIT 1))";
        $sql = "SELECT $op" . self::$SQL_FROM .
            "WHERE userId=?";

        $result = $this->db->fetchAll($sql, $userID);
        return $result[0][$op] ?? null;

    }

}

?>