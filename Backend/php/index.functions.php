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
 * Formatiert das gegebene Array in ein Array welches für Prepared Querys
 * verwendet werden kann
 *
 * @param array $arr
 * @return array
 */
function formatQueryInput(array $arr)
{
    $formattedArray = array();
    foreach ((array) $arr as $key => $val) {
        $formattedArray[":{$key}"] = $val;
    }
    unset($formattedArray[":action"]);
    return $formattedArray;
}

/**
 * Überprüft ob ein Datensatz von Artikeln für das einfügen in die
 * Datenbank korrekt sind
 *
 * @param array $articles
 * @return bool
 */
function checkIfArticlesAreValid(array $articles)
{
    $requiredValues = ["id", "rechnungsposition", "menge"];
    foreach ($articles as $val) {
        foreach ($requiredValues as $rv) {
            if (!isset($val->{$rv}) || empty($val->{$rv})) {
                return false;
            }
        }
    }
    return true;
}
