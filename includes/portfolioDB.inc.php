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

        $sql = "SELECT COUNT(*)" .
            self::$SQL_FROM .
            "WHERE userId=?";

      //  echo "getCompaniesCount";
        return $this->db->fetchAll($sql, $userId);
    }

    /*
    * Returns the sum of the portfolio amount field, it will be used in the number of shares section


    */

    public function getSharesSum ($userId){
        $sql = "SELECT SUM(amount)" . self::$SQL_FROM . "WHERE userId=?";
      //  echo "getsharesSum";
        
        return $this->db->fetchAll($sql, $userId);

    }

    /*
    * The total value is the value of the users portfolio can be determined by adding the value
    (closing stock price of the last history record fo that stock * amount of stock owned) for each of the stocks 
    in the portfolio
    *
    */



    public function getTotalValue ($userID){

      //  echo "getTotalValuefirst";


        $sql = "SELECT SUM (portfolio.amount * (
        SELECT history.close from history WHERE history.symbol = portfolio.symbol ORDER BY history.date DESC LIMIT 1)
        ) as total_value" . self::$SQL_FROM . "WHERE portfolio.userID=?";

       // echo "getTotalValue";

        return $this->db->fetchAll($sql, $userID);

    }


}

?>