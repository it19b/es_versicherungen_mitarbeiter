<?php
include 'SQL.php';
$sql = new SQL();
$result = $sql->GetEmployees();
?>

<htlm>
<body>
<h2>Mitarbeiter</h2>
<?php 

if ($result->num_rows > 0) {
  $formPath = "employeeForm.php";
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $name = $row["Name"];
    $vorname = $row["Vorname"];
    $geburtsdatum = $row["Geburtsdatum"];
    $telefon = $row["Telefon"];
    $mobil = $row["Mobil"];
    $email = $row["Email"];
    $raum = $row["Raum"];
    $ist_Leiter = $row["Ist_Leiter"];
    $abteilung_ID = $row["Abteilung_ID"];


    $html = "
        <h3>$name, $vorname
            <a href='$formPath?id={$row['ID']}'>
                <button>Bearbeiten</button>
            </a>
            <a href='$formPath?id={$row['ID']}'>
                <button>Löschen</button>
            </a>
        </h3>
        <h5>Geburtstag: $geburtsdatum</h5>
        <h5>Telefon: $telefon</h5>
        <h5>Mobil: $mobil</h5>
        <h5>Email: $email</h5>
        <h5>Raum: $raum</h5>
        <h5>Leitung: $ist_Leiter</h5>
        <h5>Abteilung: $abteilung_ID</h5>

        
        <hr>
    ";
    echo $html;
    
  }
} else {
  echo "0 posts";
}

?>
</body>
</html>