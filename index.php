<?php

include 'SQL.php';

$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = new SQL();
  $result = $sql->InsertEntry($_POST);
}

?>
<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>


<h2>Schreibe ins Gästebuch</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <input type="text" name="name" placeholder="Dein Name">
  <br><br>
  <input type="email" placeholder="Email Adresse" name="email">
  <br><br>
  <input placeholder="Webseite" type="url" name="website">
  <br><br>
  Kommentar <span style="color: red">*</span><br>
  <textarea name="comment" maxlength="600" rows="5" cols="40" required></textarea>
  <br><br>
  <input type="radio" name="gender" value="female">Female</input>
  <input type="radio" name="gender" value="male">Male</input>
  <input type="radio" name="gender" value="other">Other</input>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
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
