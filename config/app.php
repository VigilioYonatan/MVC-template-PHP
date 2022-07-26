<?php

require_once __DIR__ . '/../vendor/autoload.php';

/*
    Variable de entorno
*/
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad(); // para que no mande error si noexisten variables de entorno


require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../helpers/index.php';
/*
 Instanciar conexion database
*/

use Model\ActiveRecord;

ActiveRecord::setDb($cnx);