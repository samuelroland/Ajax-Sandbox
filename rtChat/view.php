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
    <?php echo(isset($_SESSION['user']) ? "Etat: {$_SESSION['user']['firstname']} {$_SESSION['user']['lastname']}" : "Etat: Non connecté...");
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
            <div class="listConv flex-1 bg-header">
                <?php foreach ($conversations as $conversation) {
                    ?>
                    <div class="oneConv">
                        Conv: <?= $conversation['id'] ?>.
                        Départ: <?= date("Y-m-d H:i", strtotime($conversation['startdate'])) ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="detailsMsgs flex-4 bg-danger h-100 ">
                <?php foreach ($messages as $message) {
                    ?>
                    <div class="oneMsg">
                        De: <?= $message[''] ?>.
                        <br><em><?= $message['text'] ?></em>
                    </div>
                    <?php
                }
                ?>
                <div class="divSending position-relative ">
                    <textarea class="fullwidth" rows="2" name="text" maxlength="2000" placeholder="Envoyer un message..."></textarea>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    </body>
    </html>
<?php
$content = ob_get_clean();
echo $content;
?>