<?php

namespace Main\Utils;

use PDO;

class DB
{
    private static ?DB $instance = null;
    private ?PDO $conn = null;

    private string $host;
    private string $user;
    private string $pass;
    private string $dbname;

    //  Private constructor (Singleton rule)
    private function __construct()
    {
        $this->host   = $_ENV["DB_HOST"];
        $this->user   = $_ENV["DB_USER"];
        $this->pass   = $_ENV["DB_PASS"];
        $this->dbname = $_ENV["DB_NAME"];

        $this->connect();
    }

    //  Single access point
    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    //  Create PDO connection once
    private function connect(): void
    {
        $conn_str = "mysql:host={$this->host};dbname={$this->dbname}";

        $this->conn = new PDO($conn_str, $this->user, $this->pass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // What other classes will use
    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
