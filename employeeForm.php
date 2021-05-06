<?php

include 'SQL.php';

$result = null;
$sql = new SQL();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $result = $sql->InsertEntry($_POST);
}

function GetDepartmentOptions() {
  
  $options = "";
  $sql = new SQL();
  $result = $sql->GetDepartments();

  while($row = $result->fetch_assoc()) {
    $id = $row['ID'];
    $label = $row["Bezeichnung"];
    $options .= "<option value='$id'>$label</option>";
  }

  return $options;
}

$id = $_GET["id"];

if ($id) {
  $result = $sql->GetEmployees($id);
  $row = $result->fetch_assoc();

  $name = $row["Name"];
  $firstname = $row["Vorname"];
  $birthday = $row["Geburtsdatum"];
  $phone = $row["Telefon"];
  $mobil = $row["Mobil"];
  $email = $row["Email"];
  $room = $row["Raum"];
  $isLeader = $row["Ist_Leiter"];
  $departmentId = $row["Abteilung_ID"];
} else {
  $name = $firstname = $birthday =  $phone = $mobil = $email = $room = $isLeader = $departmentId = "";
}

$departmentOptions = GetDepartmentOptions();


?>
<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>


<h2>Mitarbeiter bearbeiten</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <?php
  $formBody = "
  <input type='text' name='name' placeholder='Name' value='$name'>
  <br><br>
  <input type='text' name='firstname' placeholder='Vorname' value='$firstname'>
  <br><br>
  <input type='date' placeholder='Geburtstag' name='birthday' value='$birthday'>
  <br><br>
  <input type='tel' placeholder='Telefon' name='phone' value='$phone'>
  <br><br>
  <input type='tel' placeholder='Mobil' name='mobile' value='$mobil'>
  <br><br>
  <input type='email' placeholder='E-Mail' name='email' value='$email'>
  <br><br>
  <input type='number' placeholder='Raumnummer' name='room' value='$room'>
  <br><br>
  <input type='checkbox' name='is_leader' value='$isLeader'>
  <label for='is_leader'>Leitung</label>
  <br><br>
  <label for='department'>Abteilung:</label>
  <select name='department'>
    $departmentOptions
  </select> 
  <br><br>
  <br><br>
  <input type='submit' name='submit' value='Speichern'>
  ";

  echo $formBody;
  ?>
</form>

<h5><small>Felder mit einem *, sind Pflichtfelder</small></h5>

<?php

if ($result === true) {
  // redirect to all posts
  header('Location: ' . "/es_php_guestbook/posts.php");
  die();
} elseif (is_string($result)) {
  ?> <h3> <?php $result ?> </h3> <?php
} 

?>

</body>
</html>
