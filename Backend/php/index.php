<?php

ob_start('ob_gzhandler');
//session_start();

// no-cors fix
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Development");
header("Content-Type: application/json");
header("Cache-Control: no-cache");
header_remove("X-Powered-By");

include_once "./includes/inc.database.php";
include_once "./classes/class.germanDate.php";

var_dump($db);
die();

/* Early catch api requests */
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $response = new stdClass();
    $error = null;
    $data = json_decode(trim(file_get_contents("php://input")));

    switch ($data->action) {
        case '':
            if (!$data->xyz) {
                $error = "Error xyz is not set!";
                break;
            }
            break;
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
    die();
}

ob_end_flush();
