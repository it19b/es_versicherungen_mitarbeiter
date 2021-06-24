<head>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/delete.js"></script>
  <script src="js/editor.js"></script>
    
  <style>
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
  }

  .td-edit {
    text-align: center;
    min-width: 150px;
  }

  button {
    min-width: 50px;
    padding: 5px;
    font-size: 16px;
  }

  .active {
    background: #111;
  }

  li {
    float: left;
  }

  li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  li a:hover {
    background-color: #111;
  }

  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }

  </style>

</head>
<?php



$dbTables = $sql->GetTableNames();

$li_list = "";
$hrefBase = "/es_versicherungen_mitarbeiter/view.php?db=";

foreach ($dbTables as $tableName) {
    $href = $hrefBase . $tableName;

    $classname = "";
    if ($db == $tableName) {
      $classname = "active";
    }

    $li_list .= "<li><a class='$classname' href='$href'>$tableName</a></li>";
}

$header = " <ul>
                $li_list
            </ul>";


echo $header;