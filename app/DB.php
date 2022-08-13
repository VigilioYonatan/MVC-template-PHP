<?php

namespace App;

use PDO;

class DB
{
    protected const HOST = '';
    protected const USER = '';
    protected const PASS = '';
    protected const DB   = '';
    public function __construct()
    {
        $this->HOST = $_ENV['DB_HOST'];
        $this->USER =  $_ENV['DB_USER'];
        $this->PASS =  $_ENV['DB_PASS'];
        $this->DB =    $_ENV['DB_NAME'];
        $this->pdo = new PDO(
            "pgsql:host=$this->HOST;dbname=$this->DB",
            $this->USER,
            $this->PASS
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}