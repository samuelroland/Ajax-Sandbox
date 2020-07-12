<?php
/**
 *  Projet: Ajax-Sandbox: Learning to use Ajax
 *  Filename: index.php
 *  Author: Samuel Roland
 *  Creation date: 06.2020
 */

require "CRUDModel.php";
ini_set("memory_limit", "-1");  // pas de limite de mémoire (pas génial comme option, mais pas trouvé autre chose qui fonctionne)

function trimIt($value)
{
    return trim($value, "\t\n\r\0\x0B");
}

$data = (array)json_decode(file_get_contents("php://input"));
$whereString = "";  //string of where clause in the SQL query

if ($_GET['action'] == "getGrades") {   //Ajax Call

    if (isset($data['initials'])) {
        $whereString = "WHERE person.personInitials = '" . trimIt($data['initials']) . "' AND person.role = 0";
    } else {
        if (isset($data['firstname'], $data['lastname'])) {
            $whereString = "WHERE person.personFirstname = '" . trimIt($data['firstname']) . "' AND person.personLastname = '" . trimIt($data['lastname']) . "' AND person.role = 0;";
        }
    }
    $query = "SELECT person.personInitials AS initials, person.personFirstName AS firstname, person.personLastName AS lastname, grade.gradeValue as value, evaluation.testDate as date, module.moduleShortName as modulename FROM person 
INNER JOIN grade ON grade.fkStudent = person.idPerson
INNER JOIN evaluation ON evaluation.idEvaluation = grade.fkEval
INNER JOIN moduleInstance ON moduleInstance.idModuleInstance = evaluation.fkModuleInstance
INNER JOIN module ON module.idModule = moduleInstance.fkModule 
{$whereString}";
    $grades = Query($query, null, true);
    if (empty($grades) == false) {
        echo json_encode($grades);  //return the data in json format for the ajax call
    } else {
        if (isset($data['initials'])){
            echo json_encode(["error" => "user " . trimIt($data['initials']). " not found..."]);
        }else{
            echo json_encode(["error" => "user " . trimIt($data['firstname']). " ". trimIt($data['lastname']). " not found..."]);
        }

    }

} else {
    require "view.php";
}

?>