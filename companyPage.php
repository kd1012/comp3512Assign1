<?php
require_once 'includes/config.inc.php';
require_once 'includes/databaseHelper.inc.php';
require_once 'includes/companiesDB.inc.php';
require_once 'includes/historyDB.inc.php';
require_once 'includes/helperFunctions.inc.php';

define("QUERY_PARAM", "symbol");

$hasValidData = false;
$compData = []; // Company info
$hisData = [];  // History table data
$finData = [];  // Financials table data
$hasFinData = false;  // Financials table data exists
$hisHigh = "";  // Historical high
$hisLow = "";   // Historical low
$hisTotalVol = ""; // Total volume
$hisAvgVol = "";   // Average volume

/*
 * Empty format function, needed for mkHistoryTbl().
 */
function noFormat($value) {
    return $value;
}

/*
 * Builds the history table from the history data.
 */
function mkHistoryTbl($hisData) {
    // Key is SQL column name, value is [display name, format function]
    // Putting functions into variables is weird in php,
    // see: https://www.php.net/manual/en/functions.variable-functions.php
    $tblHeaders = [
        "date" => ["Date", "noFormat"],
        "volume" => ["Volume", "num2Str"],
        "open" => ["Open", "dollar2Str"],
        "close" => ["Close", "dollar2Str"],
        "high" => ["High", "dollar2Str"],
        "low" => ["Low", "dollar2Str"]
    ];

    echo "<table>";

    // Make the table headers
    echo "<tr>";

    foreach ($tblHeaders as $_=>$arr) {
        echo "<th>$arr[0]</th>";
    }

    echo "</tr>";

    // Add the actual values
    foreach ($hisData as $row) {
        echo "<tr>";

        foreach ($tblHeaders as $attr=>$arr) {
            echo "<td>";
            echo $arr[1]($row[$attr]);
            echo "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
}

/*
 * Builds the financials table from the finance info.
 */
function mkFinanceTbl($finData) {
    echo '<table class="finance-table">';

    // Year is special
    echo "<tr>";
    echo "<th></th>";

    foreach ($finData["years"] as $y) {
        echo "<th>$y</th>";
    }

    echo "</tr>";

    // Do the rest of the table, skip years
    foreach ($finData as $rowName=>$rowData) {
        if ($rowName == "years") {
            continue;
        }

        echo "<tr>";
        echo "<th>";
        echo ucwords($rowName);
        echo "</th>";

        foreach ($rowData as $r) {
            echo "<td>";
            echo dollar2Str($r);
            echo "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
}

if (isQueryParam(QUERY_PARAM)) {
    try {
        $symbol = strtoupper($_GET[QUERY_PARAM]);

        $db = new DatabaseHelper(DB_CONNSTRING, DB_USER, DB_PASS);
        $db->connect();

        $compDB = new CompaniesDB($db);
        $hisDB = new HistoryDB($db);

        $compData = $compDB->getCompanyInfo($symbol);

        if (isset($compData) && count($compData) > 0) {
            // Company symbol is valid
            $hisData = $hisDB->getHistory($symbol);

            $finData = CompaniesDB::decodeFinancials($compData["financials"]);

            if (isset($finData) && count($finData) > 0) {
                $hasFinData = true;
            }

            $hisHigh = dollar2Str($hisDB->getHigh($symbol));
            $hisLow = dollar2Str($hisDB->getLow($symbol));
            $hisTotalVol = num2Str($hisDB->getTotalVolume($symbol));
            $hisAvgVol = num2Str($hisDB->getAverageVolume($symbol));

            $hasValidData = true;
        }

        $db->disconnect();

    } catch (PDOException $e) { die($e->getMessage()); }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/meta.inc.php";?>
    <link rel="stylesheet" href="css/companyPage.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body id="companybody">
    <?php require_once "includes/header.inc.php";?>
    <main class="company-container">
        <?php if (!$hasValidData) { ?>

            <div id="symbol_err">
                <h3>Invalid Company Symbol was Provided</h3>
                <a href="index.php">Go Home</a>
            </div>

        <?php } else { ?>

            <div id="c_info">
                <div id="c_info_ticker">
                    <h1><?=$compData["name"]?> (<?=$compData["symbol"]?>)</h1>
                    <h3><?=$compData["exchange"]?></h3>
                    <p><?=$compData["sector"]?> - <?=$compData["subindustry"]?></p>
                </div>
                <div id="c_info_info">
                    <h3><?=$compData["address"]?></h3>
                    <h3><a href="<?=$compData["website"]?>">Website</a></h3>
                </div>
                <div id="c_info_desc">
                    <p><?=$compData["description"]?></p>
                </div>
            </div>

            <div id="main_content">
                <div id="his_tbl">
                    <h2 id="his_tbl_header">History</h2>
                    <?php mkHistoryTbl($hisData); ?>
                </div>

                <div id="sidebar">
                    <div id="fin_tbl">
                        <h2 id="fin_tbl_header">Financials</h2>
                        <?php if (!$hasFinData) { ?>
                            <h4 id="fin_tbl_err">Financial Information is not available for this company</h4>
                        <?php } else { mkFinanceTbl($finData); }?>
                    </div>

                    <div class="fin_stat"><h3>Historical High: <?=$hisHigh?></h3></div>
                    <div class="fin_stat"><h3>Historical Low: <?=$hisLow?></h3></div>
                    <div class="fin_stat"><h3>Total Volume: <?=$hisTotalVol?></h3></div>
                    <div class="fin_stat"><h3>Average Volume: <?=$hisAvgVol?></h3></div>
                </div>

            </div>



        <?php } ?>
    </main>
    <footer>

    </footer>
</body>
</html>