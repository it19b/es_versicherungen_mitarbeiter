<?php
include 'SQL.php';
$sql = new SQL();
$result = $sql->GetEmployees();
$formPath = "employeeForm.php";
?>

<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/delete.js"></script>
</head>
<body>
<h2>Mitarbeiter <button onclick='location.href ="<?php echo ("$formPath"); ?>";' >
                  Erstellen
                </button></h2>
<?php 

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $id = $row['ID'];
    $employeeNumber = $row['Personalnummer'];
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
      <div id='employee-$id'>
        <h3>$name, $vorname
                <button onclick='location.href = \"$formPath?id={$id}\";' >
                  Bearbeiten
                </button>
            <button onclick='deleteEmployee($id)'>Löschen</button>
        </h3>
        <h5>Personalnummer: $employeeNumber</h5>
        <h5>Geburtstag: $geburtsdatum</h5>
        <h5>Telefon: $telefon</h5>
        <h5>Mobil: $mobil</h5>
        <h5>Email: $email</h5>
        <h5>Raum: $raum</h5>
        <h5>Leitung: $ist_Leiter</h5>
        <h5>Abteilung: $abteilung_ID</h5>

        
        <hr>
      </div>
    ";
    echo $html;
    
  }
} else {
  echo "0 posts";
}

?>
</body>
</html>