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
require_once "./includes/functions.inc.php";
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
    $action = $data->action;

    switch ($action) {
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
                $stmt->execute(formatQueryInput((array) $data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            break;
        case 'addArtikel':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["ean", "bezeichnung", "preis"]);

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
            $stmt = $db->prepare("INSERT INTO artikel (ean, bezeichnung, kurztext, preis, bild, inaktiv) VALUES (:ean, :bezeichnung, :kurztext, :preis, :bild, :inaktiv)");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array) $data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            break;
        case 'addLager':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["bezeichnung"]);

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
            $stmt = $db->prepare("INSERT INTO lager (bezeichnung, inhouse, strasse, strassennummer, plz, ort, inaktiv) VALUES (:bezeichnung, :inhouse, :strasse, :strassennummer, :plz, :ort, :inaktiv)");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array) $data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            break;
        case 'addRechnung':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["kunde_id", "artikel"]);

            /**
             * Wenn die field data nicht true ist dann abbrechen und error ausgeben
             */
            if ($fd !== true) {
                $error = $fd;
                break;
            }

            /**
             * Zieht die Artikel aus dem payload
             */
            $artikel = $data->artikel;
            unset($data->artikel);

            /**
             * Formatiert das lieferdatum zu einem von SQL erkennbarem Datum
             */
            if (isset($data->lieferdatum) && !empty($data->lieferdatum)) {
                $data->lieferdatum = toSQLDate($data->lieferdatum);
            }

            /**
             * Überprüft ob die Artikel korrekt vorliegen
             */
            if (checkIfArticlesAreValid($artikel) !== true) {
                $error = "Fehler in {$action} die gesendeten Artikel sind nicht korrekt!";
                break;
            }

            $rechnungsId = null;
            try {
                /**
                 * Bereitet den SQL query vor
                 */
                $stmt = $db->prepare("INSERT INTO rechnung (kunde_id, bezeichnung, lieferdatum) VALUES (:kunde_id, :bezeichnung, :lieferdatum)");

                /**
                 * Formatiert die POST Daten um im query verwendet zu werden und führt den
                 * query aus
                 */
                $stmt->execute(formatQueryInput((array) $data));
                $rechnungsId = $db->lastInsertId();
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            try {
                /**
                 * Wenn die rechnungsId nicht gesetzt wurde dann abbrechen
                 */
                if (is_null($rechnungsId)) {
                    throw new Exception();
                }

                /**
                 * Bereitet den SQL query vor
                 */
                $stmt = $db->prepare("INSERT INTO rechnung_artikel (rechnung_id, artikel_id, rechnungsposition, menge) VALUES (:rechnung_id, :artikel_id, :rechnungsposition, :menge)");

                /**
                 * Wenn die erste Anfrage erfolgreich war die Rechnungs Artikel einfügen
                 */
                foreach ($artikel as $a) {
                    $stmt->execute(formatQueryInput(["rechnung_id" => $rechnungsId, "artikel_id" => $a->id, "rechnungsposition" => $a->rechnungsposition, "menge" => $a->menge]));
                }
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
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
