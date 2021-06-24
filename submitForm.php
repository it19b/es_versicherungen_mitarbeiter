<?php

include "SQL.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $data = $_POST;
  
    $sql = new SQL($data["db"]);
    $id = $sql->handleFormData($data);


    echo json_encode(array(
      "id"=>$id
    ));
}