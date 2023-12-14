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

    public function UpdateData($table="", $data=[], $values=[], $param="id", $param_value="")
    {
        try {
            if (empty($table) || empty($data) || empty($values)) {
                ProcessErrors::displayMessage("Table, attributes, or values cannot be empty", 400, __LINE__);
                return false;
            }
    
            // Verificar que los arreglos tengan la misma longitud
            if (count($data) !== count($values)) {
                ProcessErrors::displayMessage("Attributes and values arrays must have the same length", 400, __LINE__);
                return false;
            }
    
            // Construir la cadena de actualización
            $updateFields = array();
            
            foreach ($data as $key => $attribute) {
                $updateFields[] = "$attribute = :$attribute";
            }
            $updateFieldsString = implode(', ', $updateFields);
            
            // Construir la condición
            if ($param_value !== "") {
                $conditionString = "$param = :$param";
                $mergedData = array_merge(array_combine($data, $values), [$param => $param_value]);
            } else {
                $conditionString = "id = :id";
                $mergedData = array_combine($data, $values);
            }
    
            // Construir la consulta SQL de actualización
            $cmd = "UPDATE $table SET $updateFieldsString WHERE $conditionString";
            $stmt = $this->prepareAndExecuteQuery($cmd, $mergedData);
    
            return ($stmt !== false);
        } catch (Exception $e) {
            echo "Error updating data: " . $e->getMessage(), $e->getCode();
            return false;
        }
    }

    public function DeleteData($table, $param = "id", $param_value = "")
    {
        try {
            if (empty($table)) {
                ProcessErrors::displayMessage("Table cannot be empty", 400, __LINE__);
                return false;
            }

            // Construir la condición
            if ($param_value !== "") {
                $conditionString = "$param = :$param";
                $mergedData = [$param => $param_value];
            } else {
                if(isset($_POST['id']))
                {

                    $conditionString = "id = :id";
                    $mergedData = ["id" => $_POST['id']];
                }
                else
                {
                    return false;
                }
            }

            // Construir la consulta SQL de eliminación
            $cmd = "DELETE FROM $table WHERE $conditionString";
            // Ejecutar la consulta de eliminación
            $stmt = $this->prepareAndExecuteQuery($cmd, $mergedData);

            return ($stmt !== false);
        } catch (Exception $e) {
            ProcessErrors::displayMessage("Error deleting data: " . $e->getMessage(), $e->getCode(), __LINE__);
            return false;
        }
    }

    public function CreateData($table="", $data=[], $values=[], $params="")
    {
        try{

            if (empty($table) || empty($data)) {
                ProcessErrors::displayMessage("Table or data cannot be empty", 400, __LINE__);
                return false;
            }

            $fields = implode(', ', $data);
            $val = ':' . implode(', :', $data);

            $cmd = "INSERT INTO $table ($fields) VALUES ($val)";
            $stmt = $this->prepareAndExecuteQuery($cmd, array_combine($data, $values));

            if ($stmt !== false) {
                if($params === true)
                {
                    return true;
                }
                if ($params !== "") {
                    // Si se especifican campos de retorno, obtener solo esos campos
                    $query = "SELECT $params FROM $table WHERE id = :lastInsertId";
                } else {
                    // Si no se especifican campos, obtener todo el registro
                    $query = "SELECT * FROM $table WHERE id = :lastInsertId";
                }

                // Obtén el ID del último registro insertado
                $lastInsertId = DB::Instance()->Connection()->lastInsertId();
                
                // Realiza una consulta adicional para obtener los datos del último registro
                $data = $this->prepareAndExecuteQuery($query, array(':lastInsertId' => $lastInsertId))->fetch(PDO::FETCH_ASSOC);

                return $data;
            } else {
                return false;
            }
        } catch (Exception $e) {
            ProcessErrors::displayMessage("Error creating data: " . $e->getMessage(), $e->getCode(), __LINE__);
            return false;
        }
    }

    private function prepareAndExecuteQuery($cmd, $data)
    {
        $pdo = DB::Instance()->Connection(); // Obtén la instancia de PDO

        try {
            $stmt = $pdo->prepare($cmd);
            $stmt->execute($data);
            return $stmt;
        } catch (PDOException $e) {
            // Puedes loguear o manejar el error según tus necesidades
            ProcessErrors::displayMessage("Error in query: " . $e->getMessage(), $e->getCode(), __LINE__);
            return false;
        }
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
