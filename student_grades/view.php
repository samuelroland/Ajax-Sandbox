<?php
/**
 *  Projet: Ajax-Sandbox: Learning to use Ajax
 *  Filename: view.php
 *  Author: Samuel Roland
 *  Creation date: 06.2020
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
    <h1>Rechercher les notes d'un élève</h1>
    <h2>Initiales</h2>
    <textarea id="txtInitials" cols="30" rows="2" name="initials" placeholder="enter initials"></textarea><br>
    <button id="cmdSearch">Rechercher les notes</button>
    <p id="pResult"></p>
    <table>
        <thead>
        <tr>
            <th>Module</th>
            <th>Date</th>
            <th>Note</th>
        </tr>
        </thead>
        <tbody id="tbody">
        <!-- Content generated in js with Ajax call... -->
        </tbody>
    </table>
    </body>
    </html>
<?php
$content = ob_get_clean();
echo $content;
?>