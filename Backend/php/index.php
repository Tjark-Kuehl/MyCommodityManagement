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
require_once './vendor/autoload.php';
require_once "./includes/database.inc.php";
require_once "./includes/functions.inc.php";
require_once "./includes/invoice.inc.php";
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
            $fd = checkFieldData($data, ["name", "strasse", "hausnummer", "plz", "ort", "telefon", "email"]);

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
            $stmt = $db->prepare("INSERT INTO kunden (`name`, vorname, strasse, hausnummer, plz, ort, telefon, email) VALUES (:name, :vorname, :strasse, :hausnummer, :plz, :ort, :telefon, :email)");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array)$data));
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
                $stmt->execute(formatQueryInput((array)$data));
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
            $stmt = $db->prepare("INSERT INTO lager (bezeichnung, inhouse, strasse, hausnummer, plz, ort, inaktiv) VALUES (:bezeichnung, :inhouse, :strasse, :hausnummer, :plz, :ort, :inaktiv)");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array)$data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            break;
        case 'addLagerArtikel':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["artikel_id", "lager_id", "menge"]);

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
            $stmt = $db->prepare("INSERT INTO lager_artikel (artikel_id, lager_id, menge) VALUES (:artikel_id, :lager_id, :menge) ON DUPLICATE KEY UPDATE menge = menge + VALUES(menge)");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array)$data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            break;
        case 'addAuftrag':
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

            $auftragsId = null;
            try {
                /**
                 * Bereitet den SQL query vor
                 */
                $stmt = $db->prepare("INSERT INTO auftrag (kunde_id, bezeichnung, lieferdatum) VALUES (:kunde_id, :bezeichnung, :lieferdatum)");

                /**
                 * Formatiert die POST Daten um im query verwendet zu werden und führt den
                 * query aus
                 */
                $stmt->execute(formatQueryInput((array)$data));
                $auftragsId = $db->lastInsertId();
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            try {
                /**
                 * Wenn die auftragsId nicht gesetzt wurde dann abbrechen
                 */
                if (is_null($auftragsId)) {
                    throw new Exception();
                }

                /**
                 * Bereitet den SQL query vor
                 */
                $stmt = $db->prepare("INSERT INTO auftrag_artikel (auftrag_id, artikel_id, auftragsposition, menge) VALUES (:auftrag_id, :artikel_id, :auftragsposition, :menge)");

                /**
                 * Wenn die erste Anfrage erfolgreich war die auftrags Artikel einfügen
                 */
                foreach ($artikel as $a) {
                    $stmt->execute(formatQueryInput(["auftrag_id" => $auftragsId, "artikel_id" => $a->id, "auftragsposition" => $a->auftragsposition, "menge" => $a->menge]));
                }
            } catch (Exception $e) {
                removeAuftrag($auftragsId);
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }

            /**
             * Holt die für das PDF benötigten Daten aus der Datenbank
             */
            $auftragsData = prepareAuftragData($auftragsId);

            /**
             * Erstellt die PDF Datei für die auftrag
             */
            generatePDF($auftragsData);

            break;
        case 'getKunden':
            $SQL = "SELECT * FROM kunden WHERE inaktiv = 0";
            $response->data = getData($db, $SQL);
            break;
        case 'getArtikel':
            $SQL = "SELECT * FROM artikel WHERE inaktiv = 0";
            $response->data = getData($db, $SQL);
            break;
        case 'getLager':
            $SQL = "SELECT * FROM lager WHERE inaktiv = 0";
            $response->data = getData($db, $SQL);
            break;
        case 'getAuftraege':
            $SQL = "SELECT * FROM auftrag";
            $response->data = getData($db, $SQL);
            break;
        case 'deleteKunden':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["id"]);

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
            $stmt = $db->prepare("UPDATE kunden SET inaktiv = 1, geloescht_zeit = now() WHERE id = :id");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array)$data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }
            break;
        case 'deleteArtikel':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["id"]);

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
            $stmt = $db->prepare("UPDATE artikel SET inaktiv = 1, geloescht_zeit = now() WHERE id = :id");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array)$data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }
            break;
        case 'deleteLager':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["id"]);

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
            $stmt = $db->prepare("UPDATE lager SET inaktiv = 1, geloescht_zeit = now() WHERE id = :id");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array)$data));
            } catch (Exception $e) {
                $error = "Fehler bei der Ausführung des querys in {$action}!";
                break;
            }
            break;
        case 'deleteAuftraege':
            /**
             * Gibt die field data wieder in der entweder ein Fehler oder ein true
             * enthalten ist
             */
            $fd = checkFieldData($data, ["id"]);

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
            $stmt = $db->prepare("DELETE FROM auftrag WHERE id = :id");

            /**
             * Formatiert die POST Daten um im query verwendet zu werden und führt den
             * query aus
             */
            try {
                $stmt->execute(formatQueryInput((array)$data));
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
     * wenn keine Fehler augetreten sind
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
