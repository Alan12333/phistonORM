<?php

class DB
{
    private $db;
    private static $instance;
    private $database, $host, $user, $pass, $driver, $port, $charset;

    private function __construct()
    {
        $this->GetVariables();
        $this->connect();
    }

    private function GetVariables()
    {
        $this->host = "";
        $this->user = "busman";
        $this->pass = "134679";
        $this->database = __DIR__ . '/host.db';;
        $this->driver = "sqlite"; // Cambiar a "sqlite" si es necesario
        $this->port = "3306"; // Cambiar el puerto si es necesario
        $this->charset = "utf8mb4"; // Cambiar el conjunto de caracteres si es necesario
    }

    public static function Instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function connect()
    {
        if ($this->driver === "mysql") {
            try {
                $dsn = "{$this->driver}:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}";
                $this->db = new PDO($dsn, $this->user, $this->pass);

                // Configurar el modo de error de PDO para generar excepciones
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Error de conexión: ' . $e->getMessage());
            }
        } else if ($this->driver === "sqlite") {
            try {
                $dsn = "sqlite :{$this->database}";
                $this->db = new PDO($dsn);

                // Configurar el modo de error de PDO para generar excepciones
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Error de conexión: ' . $e->getMessage());
            }
        }
    }

    public function Connection()
    {
        return $this->db;
    }
}
