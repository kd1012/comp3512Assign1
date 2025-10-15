<?PHP

/*
 * DB table helper class for history.
 *
 * Similar to those in lab14a
 */
class HistoryDB {
    public const ORDER_NONE = 0;
    public const ORDER_DESC = 1;
    public const ORDER_ASC  = 2;

    private static $SQL_FROM = "FROM history ";
    private static $SQL_ALL_ATTRS = "id, symbol, date, volume,
                                    open, close, high, low ";
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
    public function getHistory($symbol, $order=self::ORDER_DESC) {
        $orderSql = "";

        if ($order == 1) {
            $orderSql = "ORDER BY date DESC";
        } elseif ($order == 2) {
            $orderSql = "ORDER BY date ASC";
        }

        $sql = "SELECT " .
            self::$SQL_ALL_ATTRS .
            self::$SQL_FROM .
            "WHERE symbol=? " .
            $orderSql;
        return $this->db->fetchAll($sql, $symbol);
    }

    /*
     * Returns the highest high of a symbol.
     */
    public function getHigh($symbol) {
        $op = "MAX(high)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            "WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0][$op] ?? null;
    }

    /*
     * Returns the lowest low of a symbol.
     */
    public function getLow($symbol) {
        $op = "MIN(low)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            "WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0][$op] ?? null;
    }

    /*
     * Returns the total volume of a symbol.
     */
    public function getTotalVolume($symbol) {
        $op = "SUM(volume)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            "WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0][$op] ?? null;
    }

    /*
     * Returns the average volume of a symbol.
     */
    public function getAverageVolume($symbol) {
        $op = "AVG(volume)";
        $sql = "SELECT $op " .
            self::$SQL_FROM .
            "WHERE symbol=? LIMIT 1";
        return $this->db->fetchAll($sql, $symbol)[0][$op] ?? null;
    }

}

?>