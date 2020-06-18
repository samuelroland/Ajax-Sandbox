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
        <title>Recherche d'émojis GitHub</title>
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
            img{
                width: 40px;
            }
        </style>
    </head>
    <body>
    <h1>Recherche d'émojis GitHub</h1>
    <button id="btnGetEmojis">Aller chercher les émojis...</button>
    <br><br>
    <input type="text" placeholder="Enter the emoji name" id="inpSearch"><span> En cours...</span>
    <ul id="ulEmojis">
        <li><img src="https://github.githubassets.com/images/icons/emoji/unicode/1f4af.png?v8" alt=""></li>
    </ul>
    </body>
    </html>
<?php
$content = ob_get_clean();
echo $content;
?>