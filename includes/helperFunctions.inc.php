<?php

/*
 * Converts float values into rounded dollar strings.
 */
function dollar2Str($value) {
    $decimals = 2;
    if ($value >= 1000 || $value <= -1000) {
        # Ignore cents over $1000
        $decimals = 0;
    }

    return "$&nbsp" . number_format($value, $decimals);
}

/*
 * Formats large numbers nicely.
 */
function num2Str($value) {
    return number_format($value, 0);
}

/*
 * Returns true if the query parameter $name is not empty.
 */
function isQueryParam($name) {
    return isset($_GET[$name]) && $_GET[$name] != "";
}

?>