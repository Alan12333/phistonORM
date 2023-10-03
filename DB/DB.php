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
        $archivo = 'db.dset';
        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            $lineas = explode("\n", $contenido);
            $configuracion = array();
            foreach ($lineas as $linea) {
                $parts = explode(':', $linea, 2);
                if (count($parts) === 2) {
                    $clave = trim($parts[0]);
                    $valor = trim($parts[1]);
                    $val = explode(";",$valor);
                    $configuracion[$clave] = $val[0];
                }
            }
            $this->driver = isset($configuracion['driver']) ? $configuracion['driver'] : "";
            $this->host = isset($configuracion['host']) ? $configuracion['host'] : "";
            $this->user = isset($configuracion['user']) ? $configuracion['user'] : "";
            $this->pass = isset($configuracion['password']) ? $configuracion['password'] : "";
            $this->database = isset($configuracion['database']) ? $configuracion['database'] : "";
            $this->port = isset($configuracion['port']) ? $configuracion['port'] : "";
            $this->charset = isset($configuracion['charset']) ? $configuracion['charset'] : "";
        }
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
                $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}";
                $this->db = new PDO($dsn, $this->user, $this->pass);
    
                // Configurar el modo de error de PDO para generar excepciones
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Error de conexión: ' . $e->getMessage());
            }
        } else {
            die('Driver no compatible: ' . $this->driver);
        }
    }

    public function Connection()
    {
        return $this->db;
    }
}
