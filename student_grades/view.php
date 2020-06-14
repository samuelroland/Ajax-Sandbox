<?php
/**
 *  Projet: xxx
 *  Filename: ICT-151-Revisions
 *  Author: Samuel Roland
 *  Creation date: 08.06.2020
 */

$placeholder = "For SQL injection: insert: ASA'; update grade set gradeValue=6; -- and reload a second time the page... all notes will change to 6... 

OR if you want to change only the notes of the user with ASA initials: update grade SET grade.gradeValue=7.5
WHERE grade.fkStudent = (SELECT person.idPerson FROM person WHERE person.personInitials = \"ASA\" AND person.role=0 LIMIT 1)";
$placeholder = htmlentities($placeholder);

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

    </head>
    <body>
    <form action="/update_injection/" method="post">
        <p>Initiales élèves</p>
        <textarea cols="100" rows="20" name="initials" placeholder="<?= $placeholder ?>"></textarea>
        <input type="submit" value="Rechercher les notes">
    </form>
    </body>
    </html>
<?php
$content = ob_get_clean();
echo $content;
?>