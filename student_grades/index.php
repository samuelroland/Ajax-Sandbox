<?php
/**
 *  Projet: ICT-151-SandBox
 *  Filename: index.php
 *  Author: Samuel Roland
 *  Creation date: 06.02.2020
 */

require "CRUDModel.php";
ini_set("memory_limit", "-1");  // pas de limite de mémoire (pas génial comme option, mais pas trouvé autre chose qui fonctionne)
var_dump($_POST);

if (empty($_POST)==false) {
    $query = "SELECT person.personInitials AS initials, person.personFirstName AS firstname, person.personLastName AS lastname, grade.gradeValue as value, evaluation.testDate as date, module.moduleShortName as modulename FROM person 
INNER JOIN grade ON grade.fkStudent = person.idPerson
INNER JOIN evaluation ON evaluation.idEvaluation = grade.fkEval
INNER JOIN moduleInstance ON moduleInstance.idModuleInstance = evaluation.fkModuleInstance
INNER JOIN module ON module.idModule = moduleInstance.fkModule
WHERE person.personInitials = '".$_POST['initials']."' AND person.role = 0";
    $grades = Query($query, null, true);
    require "grades.php";
} else {

    require "view.php";
}

?>