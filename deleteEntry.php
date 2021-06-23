<?php


 if (isset($_POST['id'])) {

    include 'SQL.php';

    $sql = new SQL($_POST['db']);
    $id = $_POST['id'];
    $sql->DeleteEntry($id);

}