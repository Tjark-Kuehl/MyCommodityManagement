<?php

function toSQLDate($date)
{
    return date('Y-m-d H:i:s', strtotime($date));
}

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function getFirstElement($array)
{
    return array_pop(array_reverse($array));
}