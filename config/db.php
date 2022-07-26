<?php
$cnx = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME']
);

if (!$cnx) {
    die("No se pudó conectar a la base de datos" . mysqli_connect_error());
}

mysqli_query($cnx, "SET NAMES 'utf8'");