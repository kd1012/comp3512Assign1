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
     * @Kiera
     *
     * When using SQL function such as COUNT or SUM that return a single value (ie, the count or sum),
     * instead of an array of values like a normal "SELECT id, ... FROM ..." that returns multiple rows of data,
     * php still builds the array the same for both.
     * So if a fetchAll on a "SELECT id, name FROM ..." returns an array like this:
     *  [
     *      ["id" => 1, "name" => "Kiera"],
     *      ["id" => 2, "name" => "Diesel"],
     *      ["id" => 3, ...]
     *  ]
     *
     * A "SELECT COUNT(id) FROM ..." of records will return an array like this:
     *  [
     *      ["COUNT(id)" => 3]
     *  ]
     *
     * So, when returning a value from a function such as getCompaniesCount(),
     * we can cheat a bit and remove the extra arrays since we know that the SQL query will only be returning a single value.
     * This is instead of doing the same thing after we have called the function in our main php code.
     *
     *
     * First we get the value at index 0 from the outer array, giving us: ["COUNT(myColumn)" => 1234],
     * and then get the value of the key from what ever operation we did, giving us: 1234
     *
     * This is what the [0][$op] on the end of the fetchAll is for. (See getCompaniesCount() above)
     * The $op variable is the operation we are doing (COUNT(...), SUM(...), etc),
     * its there just so we dont have to type it twice in the SQL and at the end of the fetchAll statement.
     *
     * The "?? null" is there so that if fetchAll returns an empty array, php doesn't freak out and throw warnings about trying to access
     * a invalid array element, and instead "?? null" will returns null from the function.
     *
     * Also, dont use wildcards (the * symbol) in your SQL, Randy says its bad practice.
     *
     * Feel free to delete this comment :)
     */

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