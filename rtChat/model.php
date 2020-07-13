<?php
/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */

//Get all message from a conversation by id
function getAllMessages($id)
{
    $messages = getByCondition("messages", ["id" => $id], "messages.conversation_id =:id", true);

    //Add sender informations:
    foreach ($messages as $key => $message) {
        $messages[$key]['sender'] = getOne("users", $message['sender_id']);
    }
    return $messages;
}

//Send a message to a receiver
function createMsg($msg)
{
    createOne("messages", $msg);
}

//Get all conversation of the user logged
function getConversations($id)
{
    $query = "SELECT conversations.id, conversations.name, conversations.startdate, conversations.type FROM conversations 
INNER JOIN interact ON interact.conversation_id = conversations.id
INNER JOIN users ON users.id = interact.user_id
WHERE users.id =:id";

    $conversations = Query($query, ['id' => $id], true);

    foreach ($conversations as $key => $conversation) {
        $conversations[$key]['members'] = getMembersFromAConversation($conversation['id']);
    }
    var_dump($conversations);
    return $conversations;
}

function getMembersFromAConversation($id)
{
    $query = "SELECT users.id, users.firstname, users.lastname FROM interact 
INNER JOIN users on interact.user_id = users.id
WHERE interact.conversation_id =:id";

    $members = Query($query, ['id' => $id], true);
    return $members;
}

?>