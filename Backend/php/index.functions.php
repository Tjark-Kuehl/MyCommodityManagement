<?php

/**
 * Überprüft den POST payload ob die Daten mit der Angefragten Funktion überinstimmt
 *
 * @param stdClass $data
 * @param array $requiredFields
 * @return string|bool
 */
function checkFieldData(stdClass $data, array $requiredFields)
{
    // Alle Pflichtfelder durchgehen und gucken ob sie gesetzt wurden
    foreach ($requiredFields as $idx => $rf) {
        if (isset($data->{$rf}) && !empty($data->{$rf})) {
            unset($requiredFields[$idx]);
        }
    }

    // Wenn Pflichtfelder noch nicht gesetzt wurden dann return error
    if (sizeof($requiredFields) !== 0) {
        return "Fehler folgende Variablen wurden nicht gesetzt: " . implode(", ", $requiredFields);
    }

    return true;
}

/**
 * Formatiert das gegebene Array in ein Array welches für Prepared Querys verwendet werden kann
 *
 * @param array $arr
 * @return array
 */
function formatQueryInput(array $arr)
{
    $formattedArray = array();
    foreach ((array)$arr as $key => $val) {
        $formattedArray[":{$key}"] = $val;
    }
    unset($formattedArray[":action"]);
    return $formattedArray;
}
