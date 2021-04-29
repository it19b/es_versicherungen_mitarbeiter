<?php

class SQL {
    
    function GetConnection() {
        $servername = "localhost";
        $username = "admin";
        $password = "admin";
        $database = "versicherungen";

        return new mysqli($servername, $username, $password, $database); 
    }


    function InsertEntry($postRequest) {

        $conn = $this->GetConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $this->ParseInput($postRequest["name"]);
        $email = $this->ParseInput($postRequest["email"]);
        $website = $this->ParseInput($postRequest["website"]);
        $comment = $this->ParseInput($postRequest["comment"]);
        $gender = $this->ParseInput($postRequest["gender"]);

        $sql = "INSERT INTO guestbook (name, email, website, comment, gender) VALUES ('$name', '$email', '$website', '$comment', '$gender')";

        $result = true;

        if ($conn->query($sql) === false) {
            $result = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

        return $result;

    }

    function GetEmployees() {
        $conn = $this->GetConnection();
 
        $query = "SELECT * FROM Mitarbeiter";
        return $conn->query($query);
    }

    function ParseInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
