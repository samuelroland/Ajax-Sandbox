<?php
/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */

//Get all message from a conversation by id
function getMessages($id)
{

    $messages = getByCondition("messages", ["id" => $id], "messages.conversation_id =:id", true);
}

//Send a message to a receiver
function sendMsg($msg)
{

}

//get all conversation of the user logged
function getConversations()
{
    return getAll("conversations");
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
            require "view.php";
        }
    } else {
        require "view.php";
    }
}

function home()
{
    $conversations = getConversations();
    require "view.php";
}

?>