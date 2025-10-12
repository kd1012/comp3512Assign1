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

    return "$ " . number_format($value, $decimals);
}

/*
 * Formats numbers nicely.
 */
function num2Str($value) {
    return number_format($value, 0);
}


?>