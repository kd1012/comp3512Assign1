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
            " WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0] ?? [];
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