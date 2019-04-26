<?php
/**
 * Nutzt das GZIP Kompressionsverfahren für versendete Pakete
 */
ob_start('ob_gzhandler');

/**
 * no-cors fix
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");
header("Cache-Control: no-cache");
header_remove("X-Powered-By");

/**
 * Includes
 */
require_once "./includes/database.inc.php";
require_once "./classes/GermanDate.class.php";
require_once "./index.functions.php";

/**
 * Globale db Variable zu Lokaler Variable 
 */
$db = $GLOBALS["db"];

/**
 * Fängt alle POST requests ab und geht die möglichen Aktionen durch
 */
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $response = new stdClass();
    $error = null;
    $data = json_decode(file_get_contents("php://input"));

    switch ($data->action) {
        case 'addKunde':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true 
             * enthalten ist
             */
            $fd = checkFieldData($data, ["name", "strasse", "strassennummer", "plz", "ort", "telefon", "email"]);

            /**
             * Wenn die field data nicht true ist dann abbrechen und error ausgeben
             */
            if ($fd !== true) {
                $error = $fd;
                break;
            }

            /**
             * Bereitet den SQL query vor
             */
            $stmt = $db->prepare("INSERT INTO kunden (`name`, vorname, strasse, strassennummer, plz, ort, telefon, email) VALUES (:name, :vorname, :strasse, :strassennummer, :plz, :ort, :telefon, :email)");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
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

    /**
     * Fängt aufgetretene Fehler ab oder gibt ein success = true zurück
     * wenn keine Fehler augetreten ist
     */
    if (is_null($error)) {
        $response->success = true;
    } else {
        $response->msg = $error;
        $response->success = false;
    }

    /**
     * Verwandelt die Antwort in ein JSON Objekt und gibt sie aus
     */
    echo json_encode($response);
}

ob_end_flush();
exit;
