function deleteEmployee(id) {
  var employee = document.getElementById("employee-" + id);
  employee.remove();

  // löschen in DB
  $.ajax({
    url: "deleteEmployee.php",
    type: "POST",
    data: { id: id },
  });
}
