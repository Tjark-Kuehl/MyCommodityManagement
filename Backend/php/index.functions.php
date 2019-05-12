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
    $requiredValues = ["id", "auftragsposition", "menge"];
    foreach ($articles as $val) {
        foreach ($requiredValues as $rv) {
            if (!isset($val->{$rv}) || empty($val->{$rv})) {
                return false;
            }
        }
    }
    return true;
}

/**
 * Entfernt eine Auftrag
 *
 * @param integer $auftragsId
 * @return void
 */
function removeAuftrag(int $auftragsId)
{
    /**
     * Bereitet den SQL query vor und führt ihn aus
     */
    $stmt = $GLOBALS["db"]->prepare("DELETE FROM auftrag WHERE id = :id");
    $stmt->execute(formatQueryInput(["id" => $auftragsId]));
}

/**
 * Bereitet die für eine Auftrag benötigen Daten vor
 *
 * @param integer $auftragsId
 * @return array
 */
function prepareAuftragData(int $auftragsId)
{
    /**
     * Bereitet den SQL query vor und führt ihn aus
     */
    $stmt = $GLOBALS["db"]->prepare("SELECT
        a.ean,
        a.bezeichnung,
        a.preis,
        ra.auftragsposition,
        ra.menge,
        k.id AS kundennr,
        CONCAT(k.vorname, ' ', k.`name`) AS kundenname,
        r.erstellt_zeit
    FROM auftrag r
    JOIN kunden k ON k.id = r.kunde_id
    JOIN auftrag_artikel ra ON ra.auftrag_id = r.id
    JOIN artikel a ON a.id = ra.artikel_id
    WHERE r.id = :id");

    $stmt->execute(formatQueryInput(["id" => $auftragsId]));

    /**
     * Speichert alle Zeilen in ein array und gibt es zurück
     */
    $rows = [];
    while ($row = $stmt->fetch()) {
        if (!isset($rows[$row->auftragsposition])) {
            $rows[$row->auftragsposition] = [];
        }

        $rows[$row->auftragsposition][] = $row;
    }

    return $rows;
}

function getData($db, string $sql, array $data = []) {
    /**
     * Bereitet den SQL query vor und führt ihn aus
     */
    $stmt = $db->prepare($sql);

    $stmt->execute(formatQueryInput($data));

    /**
     * Speichert alle Zeilen in ein array und gibt es zurück
     */
    $rows = [];
    while ($row = $stmt->fetch()) {
        $rows[] = $row;
    }

    return $rows;
}