<?php

/**
 * Verwandelt jedes valide Datum in ein Datum welches von SQL benutzt werden kann
 *
 * @param string $date
 * @return date
 */
function toSQLDate(string $date)
{
    return date('Y-m-d H:i:s', strtotime($date));
}

/**
 * Überprüft ob ein String mit einer bestimmten Zeichenabfolge beginnt
 *
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function startsWith(string $haystack, string $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

/**
 * Gibt das erste Element eines Arrays wieder
 *
 * @param array $array
 * @return mixed
 */
function getFirstElement(array $array)
{
    return array_pop(array_reverse($array));
}
