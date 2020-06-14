<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accueil Exos ICT-133</title>
    <style>
        body {
            text-align: left;
            font-size: 1.5em;
            background-color: black;
            color: white;
            margin-left: 50px;
            font-family: Helvetica;
        }

        a {
            color: white;
            transition: 0.5s;
        }

        a:hover {
            color: blue;
            transition: 0.5s;

        }

        a:active {
            color: mediumvioletred;
            transition: 1s;
        }

        li {
            color: white;
            padding: 7px;
            list-style: none;
            padding-left: 5px;
        }

        img {
            height: 50px;
            width: 50px;
            background-color: white;
        }

        strong {
            color: red;
        }

    </style>
</head>
<body>
<h1>Accueil Exos ICT-133</h1>


<?php
//uniquement si le script php se trouve à la racine du site.
//$filescollection = scandir($_SERVER['DOCUMENT_ROOT']);  //collection des éléments du dossier qui contient ce fichier.
$filetoexclude = array(".", "..",".const.php",".const.php.example", "internindex.php", ".git", ".gitignore", ".idea", "img-accueil", "index.php", "index.html", "images", "img", "js", "javascript", "style", "css", "html", "pages", "doc", "documentation", "readme.md", "README.md");  //fichier ou dossiers potentiels à exclure. tout le reste sont des dossiers des exercices...
$pathofthescript = $_SERVER['SCRIPT_FILENAME'];
$dossierduscript = substr($pathofthescript, 0, strripos($pathofthescript, "\\") + 1);

//prendre la valeur de path dans la querystring
$path = $dossierduscript;

if (isset($_GET['path'])) {
    $path = $_GET['path'];
    $path = str_replace(" ", "", $path);    //enleve les espaces au path
    //Afficher qu'on se trouve dans un dossier et pas à la racine du site:
    $path = str_replace($dossierduscript, "", $path);
    echo "<h4><strong>Position: </strong>$path</h4>";

} else {
    $path = str_replace($dossierduscript, "", $path);
    echo "<h4><strong>Position: </strong>Racine du site</h4>";
}
if (substr($path, 1, 1) == "/" || substr($path, 1, 1) == "\\") {
    $path = substr($path, 1);
}
$dossieractuel = $path;
$filescollection = scandir($dossierduscript);
if (strlen($path) != 0) {
    $filescollection = scandir($path);
}

$pathfolderlogo = "img-accueil\\folderlogo.png";
function checkisafolder($folder, $filetoexclude)    //check si l'élément est un dossier, en regardant la liste des fichiers exclus.
{
    for ($i = 0; $i < count($filetoexclude); $i++) {
        if ($folder == $filetoexclude[$i] || strpos($folder, ".txt") == true) {
            return false;   //retourne que folder n'est pas un dossier d'exercices.
        }
    }
    //une fois tout vérifié, si il n'est pas sorti de la fonction --> c'est un dossier d'exercices !
    return true;
}

function format($name)
{ //formater le nom en enlevant les séparateurs.
    //Si il trouve - ou _ ou . alors il remplace par un espace
    $name = str_replace("-", " ", $name);
    $name = str_replace("_", " ", $name);
    $name = str_replace(".", " ", $name);

    //cas spécial des dossiers:
    if (strtolower($name) == "jfl") {
        $name .= " (Just For Learning)";
    }
    return $name;
}

function integratecontent($subfolder, $filetoexclude) //intégre les fichiers php du dossier dans une sous-liste
{
    $content = "";
    foreach (scandir($subfolder) as $phpfile) {   //Pour tous les fichiers trouvés à la racine.
        if (checkisafolder($phpfile, $filetoexclude) == true && (stripos($phpfile, ".php") || stripos($phpfile, ".html"))) {
            $content .= "<li ><a href='$subfolder$phpfile' >" . "-- " . $phpfile . "</a></li>";
        }
    }
    return $content;
}

function containsphpfiles($subfolder, $filetoexclude)
{
    foreach (scandir($subfolder) as $file) {   //Pour tous les fichiers trouvés à la racine.
        if (stripos($file, ".php") > -1 && $file != "index.php") {  //si le fichier est un fichier php mais pas un index.
            return true;
        }
    }

    return false;
}


//Liste des dossiers trouvés:
foreach ($filescollection as $file) {   //Pour tous les fichiers trouvés à la racine.

    if (checkisafolder($file, $filetoexclude) == true) {//Si l'élément est un dossier d'exercices
        //générer le path du sous dossier:
        $subfolder = "";
        $subfolder = $path . "/" . $file . "/";
        if (substr($subfolder, 0, 1) == "/" || substr($subfolder, 1, 1) == "\\") {
            $subfolder = substr($subfolder, 1);
        }

        $formatedname = format($file);   //créer son nom formaté pour le nom de l'exercice à partir du nom du dossier sans les séparateurs.
        //TODO: $subfolderpath pour rajouter fichier et envoyer dans les fonctions.
        //Ajouter une image devant si contient d'autres exercices (donc si contient un index.php)
        if (file_exists($subfolder . "index.php") == 1) { //si contient un index.php
            echo "<li><a href=\"$subfolder" . "index.php\">" . "Exo: " . $formatedname . "</a></li>";  //lien direct sur index.php
        } else if (containsphpfiles($subfolder, $filetoexclude) == true) { //si contient d'autres fichiers php
            echo "<br><li>" . "Exo: " . $formatedname . "<ul>" . integratecontent($subfolder, $filetoexclude) . "</ul></li>";
        } else {    //si ne contient pas de php alors c'est un dossier contenant des exercices
            echo "<li><a href='?path=$subfolder'><img src='$pathfolderlogo'>Dossier: $formatedname</a></li>";
        }

        //le rajouter à la liste de liens vers les exercices:
        //echo "<li><a href=\"" . $file . "/index.php\">" . $formatedname . "</a></li>";

    }
}

?>
</body>
</html>