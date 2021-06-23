<?php

include "SQL.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = $_POST;
  
    $sql = new SQL($data["db"]);
    $r = $sql->handleFormData($data);
    $a = 1;
}