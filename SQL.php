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

        return array_column($result, 'COLUMN_NAME');

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

                $data = $formData[$key];

                $delimeter = ",";

                if ($lastElement == $key) {
                    $delimeter = "";
                }

                $queryBody .= "`$key` = '$data' $delimeter";

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

                $columns .= "`$key` $delimeter";
                $value = $formData[$key];
                $values .= "'$value' $delimeter";
            }
            
            $query = "INSERT INTO `$tableName` ($columns) VALUES ($values);";
        }


        return $this->conn->query($query);
    }


    function EmployeeDataHandler($postRequest, $id=NULL) {

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $id = $this->ParseInput($postRequest["employeeId"]);
        $employeenumber = $this->ParseInput($postRequest["employeenumber"]);
        $name = $this->ParseInput($postRequest["name"]);
        $firstname = $this->ParseInput($postRequest["firstname"]);
        $birthday = $this->ParseInput($postRequest["birthday"]);
        $phone = $this->ParseInput($postRequest["phone"]);
        $mobil = $this->ParseInput($postRequest["mobile"]);
        $email = $this->ParseInput($postRequest["email"]);
        $room = $this->ParseInput($postRequest["room"]);
        $isLeader = isset($postRequest["is_leader"]) ? "J" : "N";
        $departmentId = $this->ParseInput($postRequest["department"]);


        if ($id) {
            // Eintrag ändern
            $sql = "UPDATE `Mitarbeiter` SET 
                `Personalnummer` = '$employeenumber',
                `Name` = '$name',
                `Vorname` = '$firstname',
                `Geburtsdatum` = '$birthday',
                `Telefon` = '$phone',
                `Mobil` = '$mobil',
                `Email` = '$email',
                `Raum` = '$room',
                `Ist_Leiter` = '$isLeader',
                `Abteilung_ID` = '$departmentId'
                WHERE (`ID` = '$id');";

        } else {
            // Eintrag neu einfügen
            $sql = "INSERT INTO `Mitarbeiter` (
                `Personalnummer`,
                `Name`,
                `Vorname`,
                `Geburtsdatum`,
                `Telefon`,
                `Mobil`,
                `Email`,
                `Raum`,
                `Ist_Leiter`,
                `Abteilung_ID`
            ) VALUES (
                '$employeenumber',
                '$name',
                '$firstname',
                '$birthday',
                '$phone',
                '$mobil',
                '$email',
                '$room',
                '$isLeader',
                '$departmentId'
                )";
        }

        $result = true;

        if ($this->conn->query($sql) === false) {
            $result = "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $this->conn->close();

        return $result;

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
