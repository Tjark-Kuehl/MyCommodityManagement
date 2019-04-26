<?php

ob_start('ob_gzhandler');
//session_start();

/* no-cors fix */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");
header("Cache-Control: no-cache");
header_remove("X-Powered-By");

/* Includes */
include_once "./includes/database.inc.php";
include_once "./classes/GermanDate.class.php";

/* Local db variable */
$db = $GLOBALS["db"];

function checkFieldData(stdClass $data, array $requiredFields)
{
    if (empty($data)) {
        return "Fehler es sind keine POST variabeln gesetzt";
    }

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

function formatQueryInput(array $arr)
{
    $formattedArray = array();
    foreach ((array)$arr as $key => $val) {
        $formattedArray[":{$key}"] = $val;
    }
    unset($formattedArray[":action"]);
    return $formattedArray;
}

/* Early catch api requests */
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $response = new stdClass();
    $error = null;
    $data = json_decode(file_get_contents("php://input"));

    switch ($data->action) {
        case 'addKunde':
            // Gibt die field data wieder in der entweder ein Fehler oder ein true enthalten ist
            $fd = checkFieldData($data, ["name", "strasse", "strassennummer", "plz", "ort", "telefon", "email"]);

            // Wenn die field data nicht true ist dann abbrechen und error ausgeben
            if ($fd !== true) {
                $error = $fd;
                break;
            }

            // Bereitet den SQL query vor
            $stmt = $db->prepare("INSERT INTO kunden (`name`, vorname, strasse, strassennummer, plz, ort, telefon, email) VALUES (:name, :vorname, :strasse, :strassennummer, :plz, :ort, :telefon, :email)");

            // Formatiert die POST Daten um im query verwendet zu werden und führt den query aus
            try {
                $stmt->execute((array)$data);
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in addKunde!";
                break;
            }

            break;
        default:
            $error = "POST Aktion wurde nicht gesetzt.";
            break;
    }

    /* Check error response */
    if (is_null($error)) {
        $response->success = true;
    } else {
        $response->msg = $error;
        $response->success = false;
    }

    echo json_encode($response);
}

ob_end_flush();
exit;
