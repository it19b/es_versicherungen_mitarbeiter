<?php

class SQL {
    
    function GetConnection() {
        $servername = "localhost";
        $username = "admin";
        $password = "admin";
        $database = "versicherungen";

        return new mysqli($servername, $username, $password, $database); 
    }


    function EmployeeDataHandler($postRequest, $id=NULL) {

        $conn = $this->GetConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
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
            $sql = "INSERT INTO guestbook (
                Personalnummer,
                Name,
                Vorname,
                Geburtsdatum,
                Telefon,
                Mobil,
                Email,
                Raum,
                Ist_Leiter,
                Abteilung_ID
            ) VALUES (
                '$name',
                '$firstname',
                '$birthday',
                '$phone',
                '$mobil',
                '$email',
                '$room',
                '$isLeader',
                '$departmentId',
                )";

        }

        $result = true;

        if ($conn->query($sql) === false) {
            $result = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

        return $result;

    }

    function DeleteEmployee($id) {
            $conn = $this->GetConnection();

            $query = "DELETE FROM Mitarbeiter WHERE id=$id";
            return $conn->query($query);
    }

    function GetEmployees($id = NULL) {
        $conn = $this->GetConnection();
 
        if ($id) {
            $query = "SELECT * FROM Mitarbeiter WHERE id=$id";
        } else {
            $query = "SELECT * FROM Mitarbeiter";
        }
        return $conn->query($query);
    }

    function GetDepartments() {
        $conn = $this->GetConnection();
 
        $query = "SELECT ID, Bezeichnung FROM Abteilung";
        return $conn->query($query);
    }

    function ParseInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
