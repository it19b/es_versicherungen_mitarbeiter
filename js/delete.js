function deleteEntry(id, db) {
  var employee = document.getElementById("row-" + id);
  employee.remove();

  // löschen in DB
  $.ajax({
    url: "deleteEntry.php",
    type: "POST",
    data: { id: id, db: db },
  });
}
