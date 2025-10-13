<?PHP

/*
 * DB table helper class for companies.
 *
 * Similar to those in lab14a
 */
class CompaniesDB {
    private static $SQL_FROM = "FROM companies";
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
        $sql = "SELECT symbol, name, sector, subindustry, address,
            exchange, website, description, financials " .
            self::$SQL_FROM .
            " WHERE symbol=?";
        return $this->db->fetchAll($sql, $symbol);
    }

    /*
     * Decodes the financials text field into a php associative array.
     */
    public static function decodeFinancials($financials) {
        if ($financials == "") {
            return [];
        }

        return json_decode($financials);
    }

    // /*
    // returns the count of the companies tied to that userId
    // */
    public function getCompanyCountfromUserID($userID){
        $sql = "SELECT COUNT(DISTINCT companies.symbol)" . self::$SQL_FROM
        . "INNER JOIN portfolio on companies.symbol = portfolio.symbol
        WHERE portfolio.userId = companies.userId";

        return $this->db->fetchAll($sql, $userID);

    }



}

?>