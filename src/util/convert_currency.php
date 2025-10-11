<?php
function convert_currency($price)
{
    $array = str_split(strrev($price));
    $formatted = [];
    $counter = 0;

    foreach ($array as $char) {
        if ($counter == 3) {
            $formatted[] = '.';
            $counter = 0;
        }
        $formatted[] = $char;
        $counter++;
    }

    echo strrev(implode('', $formatted)) . "₫";
}