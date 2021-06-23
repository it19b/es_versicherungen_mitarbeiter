<?php

include 'SQL.php';
$db = $_GET["db"];
$sql = new SQL($db);

include 'header.php';

$columnHeaders = $sql->GetTableHeaders();

$tableContent = $sql->GetTableRows();


$tableRows = "";
while($row = $tableContent->fetch_assoc()) {
    $tableColumns = "";
    $rowId = reset($row);

    foreach ($columnHeaders as $columnHeader) {

        $rowContent = $row[$columnHeader];

        if (strpos($columnHeader, '_ID')) {

            $contentId = $row[$columnHeader];

            if ($contentId) {
                $tableName = str_replace("_ID", "", $columnHeader);

                $result = $sql->GetEntry($contentId, $tableName);

                if ($result) {
                    $entry = $result->fetch_assoc();

                    if (isset($entry["Bezeichnung"]))
                        $rowContent = $entry["Bezeichnung"];
                    else {
                        $rowContent = $contentId;
                    }
                 }
           }
            
        }

        $tableColumns .= "<td class='column-content' data-th='$columnHeader'>$rowContent</td>";
    }

    $onclickDelete = "onclick='deleteEntry($rowId, \"$db\")'";
    $onclickEditButton = "onclick='changeEditButton(this)'";

    $tableColumns .= "
                <td class='td-edit'>
                <button $onclickEditButton data-editing=-1 data-id=$rowId>
                  ✎
                </button>
                <button $onclickDelete>
                    🗑
                </button>
                </td>
                ";
  

    $tableRows .= "<tr id='row-$rowId'>$tableColumns</tr>";
}


$th = "";
$formElements= "";
foreach ($columnHeaders as $columnHeader) {

    if (strpos($columnHeader, '_ID')) {
        $columnHeader = str_replace("_ID", "", $columnHeader);
    }

    $check1 = $columnHeader != "ID";
    $check2 = empty($columnHeader) == false;

    if ($columnHeader != "ID" && empty($columnHeader) == false) {
        $formElements .= "<td><input name='$columnHeader'></td>";
    } else {
        $formElements .= "<td></td>";
    }

    $th .= "<th>$columnHeader</th>";
}

$formRow = "
            <tr>
                $formElements
                <td></td>
            </tr>";

$tableBody = "<tbody>$formRow $tableRows</tbody>";

$th .= "<th></th>";

$tableHeader = "<thead>$th</thead>";
$table = "<table id='content-table' data-db='$db'>$tableHeader $tableBody </table>";

echo $table;