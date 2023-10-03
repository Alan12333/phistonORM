<?php


include "DB/DB.php";
include "src/Querys.php";
include "src/Process.php";
include "src/ProcessErrors.php";
include "test.php";
include "src/Sends.php";
include "src/Builds.php";
require_once "src/validator.php";
require_once "src/DataClean.php";
require_once "src/lang/selector.php";
require_once "src/lang/lang.php";

$resultado = test::store();

header("Content-Type:application/json");

echo json_encode($resultado);

