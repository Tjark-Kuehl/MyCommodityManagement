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

/* Early catch api requests */
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $response = new stdClass();
    $error = null;
    $data = json_decode(file_get_contents("php://input"));

    switch ($data->action) {
        /* #region Kunden */
        case 'addKunde':
            if (empty($data)) {
                $error = "Fehler es sind keine POST variabeln gesetzt";
                break;
            }

            // Alle Pflichtfelder durchgehen und gucken ob sie gesetzt wurden
            $required_fields = ["name", "strasse", "strassennummer", "plz", "ort", "telefon"];
            foreach ($required_fields as $rf) {
                if (isset($data->{$rf}) && !empty($data->{$rf})) {
                    unset($rf);
                }
            }

            $stmt = $pdo->prepare("INSERT INTO kunden (`name`, vorname, strasse, strassennummer, plz, ort, telefon, email)
                                   VALUES (:name, :vorname, :strasse, :strassennummer, :plz, :ort, :telefon, :email)");

            break;
        /* #endregion */
        default:
            $error = "Action is not set!";
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
