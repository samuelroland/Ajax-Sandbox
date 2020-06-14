<?php
/**
 *  Projet: xxx
 *  Filename: ICT-151-Revisions
 *  Author: Samuel Roland
 *  Creation date: 08.06.2020
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
        <title>Rechercher les notes d'un élève</title>
        <style>
            td{
                padding: 10px;
                background-color: #1abc9c;
            }
            th{
                padding: 10px;
                background-color: #AD0AD3F7;
            }
        </style>
    </head>
    <body>
    <p>Notes de <?= $grades[0]['firstname'] . " " . $grades[0]['lastname'] . " (" . $grades[0]['initials'] . ") " ?></p>
    <table>
        <thead>
        <tr>
            <th>Module</th>
            <th>Date</th>
            <th>Note</th>
        </tr>
        </thead>
        <tbody>

        <?php
        foreach ($grades as $grade) {
            ?>
            <tr>
                <td><?= $grade['modulename'] ?></td>
                <td><?= date( "d.m.Y", strtotime($grade['date'])) ?></td>
                <td><?= $grade['value'] ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    </body>
    </html>
<?php
$content = ob_get_clean();
echo $content;
?>