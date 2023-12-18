<?php


require_once "DB/DB.php";
require_once "src/Querys.php";
require_once "src/Process.php";
require_once "src/ProcessErrors.php";
require_once "test.php";
require_once "User.php";
require_once "src/Sends.php";
require_once "src/Builds.php";
require_once "src/validator.php";
require_once "src/DataClean.php";
require_once "src/lang/selector.php";
require_once "src/lang/lang.php";
require_once "Migrate/src/SQLAttributte.php";
require_once "Migrate/src/Migrate.php";

$table = Migration::CreateTable("Usuarios", [
    "id" => SQLAttributes::Id(),
    "Nombre" => SQLAttributes::varchar(45, true),
    "Apellido" => SQLAttributes::varchar(45),
    "Edad" => SQLAttributes::int(true),
    "created_at" => SQLAttributes::createdAt(),
    "updated_at" => SQLAttributes::updatedAt(),
]);


Migration::StartDrop($table);
// header("Content-Type:application/json");

// echo json_encode($resultado);


