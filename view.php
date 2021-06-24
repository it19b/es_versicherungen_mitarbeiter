<?php

include 'SQL.php';
$db = $_GET["db"];
$sql = new SQL($db);

include 'header.php';

$columnHeaders = $sql->GetTableHeaders();

$tableContent = $sql->GetTableRows();


$tableRows = "";
$onclickEditButton = "onclick='changeEditButton(this)'";

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
$hiddenFields = "";
foreach ($columnHeaders as $columnHeader) {



    $columnHeaderStriped = $columnHeader;

    if (strpos($columnHeader, '_ID')) {
        $columnHeaderStriped = str_replace("_ID", "", $columnHeader);
    }

    $check1 = $columnHeader != "ID";
    $check2 = empty($columnHeader) == false;

    if ($columnHeader != "ID" && empty($columnHeader) == false) {
        $formElements .= "<td><input data-field_id=0 onchange='changeInput(this)' name='$columnHeaderStriped' required></td>";
        $hiddenFields .= "<input id='$columnHeaderStriped-0' name='$columnHeader' hidden>";
    } else {
        $formElements .= "<td></td>";
    }

    $th .= "<th>$columnHeaderStriped</th>";
}

$formRow = "
            <tr>
                $formElements
                <td>
                    <button $onclickEditButton data-editing=0 data-id=0>
                    ✓
                    </button>
                </td>
            </tr>";

$hiddenForm = "<form id='form-0' hidden>
                    <input name='db' value='$db' hidden>
                    $hiddenFields
                </form>";

$tableBody = "<tbody>$formRow $tableRows</tbody>";

$th .= "<th></th>";

$tableHeader = "<thead>$th</thead>";
$table = "$hiddenForm <table id='content-table' data-db='$db'>$tableHeader $tableBody </table>";

echo $table;