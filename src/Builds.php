<?php
class Builds
{
    public function ExecuteData($cmd)
    {
        $data = array();
        $db = DB::Instance();
        $stmt = $db->Connection()->query($cmd);
        if ($stmt) {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($data) > 0) {
                return $data;
            } else {
                ProcessErrors::displayMessage("No values found", 345, __LINE__);
            }
        } else {
            // Manejo de errores en caso de consulta fallida
            $errorInfo = $db->Connection()->errorInfo();
            ProcessErrors::displayMessage("Database error: " . $errorInfo[2], $errorInfo[1], __LINE__);
        }
    }

    public function UpdateData($cmd)
    {
    }

    public function DeleteData($cmd)
    {
    }

    public function CreateData($cmd)
    {
    }

    public function ExecuteQuery($cmd)
    {
        $data = array();
        $db = DB::Instance();
        $pdo = $db->Connection(); // Obtén la instancia de PDO

        $explode = explode(" ", $cmd);
        $queryType = strtoupper($explode[0]);

        if ($queryType === "SELECT") {
            try {
                $stmt = $pdo->prepare($cmd);
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($data) > 0) {
                    return $data;
                } else {
                    ProcessErrors::displayMessage("No values found", 345, __LINE__);
                }
            } catch (PDOException $e) {
                die('Error in query: ' . $e->getMessage());
            }
        } else {
            try {
                $stmt = $pdo->prepare($cmd);
                $result = $stmt->execute();

                if ($result) {
                    return $stmt->rowCount(); // Retorna el número de filas afectadas
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                die('Error in query: ' . $e->getMessage());
            }
        }
    }
}
