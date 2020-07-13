<?php
/**
 * Mini projet: rtChat
 * Auteur: Samuel Roland
 * But: mettre en pratique l'apprentissage de Ajax et de l'asynchrone
 * Date: juillet 2020.
 */

ob_start();
?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap-grid.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap-reboot.css">


        <!-- Jquery files -->
        <script src="node_modules/jquery/dist/jquery.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>

        <link rel="stylesheet" href="library.css">
        <link rel="stylesheet" href="chat.css">
        <title>Rechercher les notes d'un élève</title>
        <script src="global.js"></script>
        <style>
            td {
                padding: 10px;
                background-color: #1abc9c;
            }

            th {
                padding: 10px;
                background-color: #AD0AD3F7;
            }
        </style>
    </head>
    <body>
    <h1>
        <?php echo(isset($_SESSION['user']) ? "Connecté: {$_SESSION['user']['firstname']} {$_SESSION['user']['lastname']}" : "Non connecté...");
        echo "</h1>";
        if (isset($_SESSION['user']) == false) {
            ?>
            <form action="?action=login" method="post">
                <input type="text" placeholder="firstname" name="firstname">
                <input type="password" placeholder="password" name="password">
                <input type="submit" value="Connexion">
            </form>
            <?php
        } else { ?>
            <div class="total flexdiv bg-info">
                <input type="hidden" id="userJson" value='<?= json_encode($_SESSION['user']) ?>'>
                <div class="listConv flex-1 bg-header">
                    <?php foreach ($conversations as $conversation) {
                        if ($conversation['type'] == 1) {  //is a private conversation with 2 persons
                            //Find the member that is not me (called $othermember)
                            if ($conversation['members'][0]['id'] == $_SESSION['user']['id']) {
                                $othermember = $conversation['members'][1];
                            } else {
                                $othermember = $conversation['members'][0];
                            }
                            //When $othermember founded, we can display the conversation info:
                            ?>
                            <div class="oneConv" data-id="<?= $conversation['id'] ?>">
                                <h4><?= $othermember['firstname'] . " " . $othermember['lastname'] ?></h4>
                                depuis le <?= date("d.m.Y H:i", strtotime($conversation['startdate'])) ?>
                            </div>
                            <?php
                        } else {    //else it's a group conversation
                            ?>
                            <div class="oneConv" data-id="<?= $conversation['id'] ?>">
                                <h4>Groupe: <?= $conversation['name'] ?></h4>
                                depuis le <?= date("d.m.Y H:i", strtotime($conversation['startdate'])) ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="oneConv newConv"><strong>Nouvelle conversation</strong></div>
                </div>
                <div class="divMsgs flex-4">
                    <div class="divDetails">
                        <div id="divMsgsDetails">
                            <?php foreach ($messages as $message) {
                                ?>
                                <div class="<?= ($message['sender']['id'] == $_SESSION['user']['id']) ? "box-alignright" : "" ?>">
                                    <div class="oneMsg">
                                        De:
                                        <strong><?= $message['sender']['firstname'] . " " . $message['sender']['lastname'] ?></strong>
                                        <br><em><?= $message['text'] ?></em>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <p>Aucune conversation sélectionnée...</p>
                        </div>
                        <div class="divSending flexdiv">
                        <textarea class="fullwidth txtSend" rows="2" name="text" maxlength="2000"
                                  placeholder="Envoyer un message..."></textarea>
                            <div class="p-1 divButtons">
                                <button>Envoyer</button>
                                <button>Vider</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <h1 class="takeplace">some space</h1>
            <h1 class="takeplace">some space</h1>
            <h1 class="takeplace">some space</h1>
            <h1 class="takeplace">some space</h1>
            <?php
        }
        ?>

    </body>
    </html>
<?php
$content = ob_get_clean();
echo $content;
?>