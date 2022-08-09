<?php


require_once __DIR__ . '/../vendor/autoload.php';

/*
Variable de entorno
*/
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad(); // para que no mande error si noexisten variables de entorno

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

use App\ActiveRecord;
use App\DB;
/*
 Instanciar conexion database
*/

$cnx  = new DB();
ActiveRecord::setDb($cnx->pdo);