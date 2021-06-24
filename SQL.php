<?php

class SQL {
    
    public $conn; 
    public $tableName;

    public function __construct($tableName)
    {
        $this->conn = new mysqli("localhost", "admin", "admin", "versicherungen");
        $this->tableName = $tableName;
    }

    function GetTableNames() {
        return array_column($this->conn->query('SHOW TABLES')->fetch_all(),0);
    }

    function GetTableHeaders() {
        $tableName = $this->tableName;

        $query = $this->conn->query("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '$tableName'
            ORDER BY ORDINAL_POSITION
        ");

        while($row = $query->fetch_assoc()){
            $result[] = $row;
        }

        // dunno why i'm getting duplicates:
        $array = array_column($result, 'COLUMN_NAME');
        $result = array_unique($array);

        return $result;

    }

    function GetTableRows() {
        $tableName = $this->tableName;

        $query = "SELECT * FROM $tableName";
        return $this->conn->query($query);
    }

    function handleFormData($formData) {

        $tableName = $this->tableName;
        $keys = array_keys($formData);
        $lastElement = end($keys);

        if (isset($formData["id"])) {
            //update
            $queryBody = "";

            foreach ($keys as $key) {
                if ($key == "db" or $key == "id") { 
                    continue;
                };

                $data = $this->ParseInput($formData[$key]);

                $delimeter = ",";

                if ($lastElement == $key) {
                    $delimeter = "";
                }

                $queryBody .= "`$key` = '$data'$delimeter";

            }
            $id = $formData["id"];

            $query = "UPDATE `$tableName` SET $queryBody WHERE (`ID` = '$id');";
        } else {
            //create
            $columns = "";
            $values = "";

            foreach($keys as $key) {
                if ($key == "db" or $key == "id") { 
                    continue;
                };
                 $delimeter = ",";

                if ($lastElement == $key) {
                    $delimeter = "";
                }

                $columns .= "`$key`$delimeter";
                $value = $this->ParseInput($formData[$key]);
                $values .= "'$value'$delimeter";
            }
            
            $query = "INSERT INTO `$tableName` ($columns) VALUES ($values);";
        }

        $result = $this->conn->query($query);

        return $this->conn->insert_id;
    }

    function DeleteEntry($id) {

        $tableName = $this->tableName;
        $query = "DELETE FROM $tableName WHERE id=$id";
        return $this->conn->query($query);
    }

    function GetEntry($id, $tableName = NULL) {
 
        if ($tableName == NULL) {
            $tableName = $this->tableName;
        }

        $query = "SELECT * FROM $tableName WHERE id=$id";
        return $this->conn->query($query);
    }

    function GetDepartments() {
        $query = "SELECT ID, Bezeichnung FROM Abteilung";
        return $this->conn->query($query);
    }

    function ParseInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
