<?php
/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */

//Get all message from a conversation by id of the conversation
function getMessages($id)
{
    $messages = getAllMessages($id);
    if (empty($messages)) {
        $error = [
            "error" => [
                "text" => "Conversation non trouvée..."
            ]
        ];
        echo json_encode($error);
    } else {
        echo json_encode($messages);
    }
}

//Send a message to a receiver
function sendMsg($data)
{
    $msg['text'] = $data['text'];
    $msg['date'] = date("Y-m-d H:i:s", time());
    $msg['sender_id'] = $_SESSION['user']['id'];
    $msg['conversation_id'] = $data['conversation_id'];
    createMsg($msg);    //create with msg with 4 fields

    //add 2 fields for send back a response with more data
    $msg['time'] = date("H:i", strtotime($msg['date']));
    $msg['sender'] = getOne("users", $msg['sender_id']);
    echo json_encode($msg); //write the response in json format for the ajax call
}


//Login the user
function login($info)
{
    //Get the user with his firstname (firstname is unique!)
    $theUser = getByCondition("users", ["firstname" => $info['firstname']], "firstname =:firstname", false);

    if ($theUser != null) { //if user has been found...
        if (password_verify($info['password'], $theUser['password']) == true) { //if login info are right
            unset($theUser['password']);
            $_SESSION['user'] = $theUser;   //log the user
        }
        home();
    } else {
        home();
    }
}

function logout()
{
    unset($_SESSION['user']);
    home();
}

function home()
{
    $conversations = getConversations($_SESSION['user']['id']);
    require "view.php";
}

?>