<?php
function convert_datetime($datetime)
{
    $date = new DateTime($datetime);
    $formattedDate = $date->format("d/m/Y H:i:s");
    echo $formattedDate;
}