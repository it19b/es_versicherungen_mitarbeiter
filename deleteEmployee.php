<?php


 if (isset($_POST['id'])) {

    include 'SQL.php';

    $sql = new SQL;
    $id = $_POST['id'];
    $sql->DeleteEmployee($id);

}