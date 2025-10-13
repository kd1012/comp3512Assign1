<?PHP

/*
 * DB table helper class for history.
 *
 * Similar to those in lab14a
 */
class HistoryDB {
    private static $SQL_FROM = "FROM history";
    private $db;

    /*
     * Takes in a DatabaseHelper object.
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /*
     * Returns the history of a symbol.
     *
     * Sorted by descending date.
     */
    public function getAllHistory($symbol) {
        $sql = "SELECT symbol, date, volume, open, close, high, low " .
            self::$SQL_FROM .
            " WHERE symbol=?" .
            " ORDER BY date DESC";
        return $this->db->fetchAll($sql, $symbol);
    }

    /*
     * Returns the highest high of a symbol.
     */
    public function getHigh($symbol) {
        $op = "MAX(high)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            " WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0]["$op"] ?? null;
    }

    /*
     * Returns the lowest low of a symbol.
     */
    public function getLow($symbol) {
        $op = "MIN(low)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            " WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0]["$op"] ?? null;
    }

    /*
     * Returns the total volume of a symbol.
     */
    public function getTotalVolume($symbol) {
        $op = "SUM(volume)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            " WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0]["$op"] ?? null;
    }

    /*
     * Returns the average volume of a symbol.
     */
    public function getAverageVolume($symbol) {
        $op = "AVG(volume)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            " WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0]["$op"] ?? null;
    }

}

?>