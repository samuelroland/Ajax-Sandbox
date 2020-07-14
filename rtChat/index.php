<?php
/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */
session_start();
require "CRUDModel.php";
require "model.php";
require "controler.php";

//var_dump($_SESSION);
//var_dump($_GET);
//var_dump($_POST);
$data = (array)json_decode(file_get_contents("php://input"));

function trimIt($value)
{
    return trim($value, "\t\n\r\0\x0B");
}

//selon l'action
switch ($_GET['action']) {
    case "getMessages": //AJAX Call
        getMessages($_GET['id']);
        break;
    case "sendMsg": //AJAX Call
        sendMsg($data);
        break;
    case "logout":
        logout();
        break;
    default:
        if (isset($_SESSION['user']) == false) {
            login($_POST);
        } else {
            home();
        }

        break;
}
?>