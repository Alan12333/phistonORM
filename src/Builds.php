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
        $explode = explode(" ", $cmd);
        if ($explode[0] === "SELECT") {
            $stringsacpe = mysqli_real_escape_string($db->Connection(), $cmd);
            $result = mysqli_query($db->Connection(), $stringsacpe);
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            if (count($data) > 0) {
                return $data;
            } else {
                ProcessErrors::displayMessage("Not values found", 345, __LINE__);
            }
        } else if ($explode[0] === "UPDATE") {
            $result = mysqli_query($db->Connection(), $cmd);
            return $result;
        } else if ($explode[0] === "DELETE") {
            $result = mysqli_query($db->Connection(), $cmd);
            return $result;
        } else if ($explode[0] === "INSERT") {
            $result = mysqli_query($db->Connection(), $cmd);
            return $result;
        }
    }
}
