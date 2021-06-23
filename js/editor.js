function changeEditButton(elem) {
  if (elem.dataset.editing > 0) {
    elem.innerText = "✎";
    form = document.getElementById("form-" + elem.dataset.id);
    sendFormData(form);
    form.remove();
  } else {
    elem.innerText = "✓";
  }
  elem.dataset.editing *= -1;
  changeFields(elem, elem.dataset.editing);
}

function changeFields(elem, editing) {
  elemId = elem.dataset.id;

  row = document.getElementById("row-" + elemId);

  list = row.querySelectorAll(".column-content");

  if (editing > 0) {
    db = document.getElementById("content-table").dataset.db;
    var form = document.createElement("form");
    form.setAttribute("id", "form-" + elemId);
    row.appendChild(form);

    var dbField = document.createElement("input");
    setAttributes(dbField, { name: "db", value: db, hidden: true });
    form.appendChild(dbField);

    var idField = document.createElement("input");
    setAttributes(idField, { name: "id", value: elemId, hidden: true });
    form.appendChild(idField);
  }

  // skip first element, because it is the primary key

  for (var i = 1; i < list.length; i++) {
    element = list[i];

    if (editing > 0) {
      text = element.innerText;
      fieldType = getFieldType(text);
      fieldName = element.dataset.th;

      if (fieldName.includes("_ID")) {
        continue;
      }

      hiddenInputField = document.createElement("input");
      form.appendChild(hiddenInputField);
      setAttributes(hiddenInputField, {
        name: fieldName,
        value: text,
        hidden: true,
        id: `${fieldName}-${elemId}`,
      });

      inputField = `<input type="${fieldType}" data-field_id="${elemId}" name="${fieldName}" value=${text} onchange='changeInput(this)'>`;
      element.innerHTML = inputField;
    } else {
      element.innerHTML = element.querySelector("input").value;
    }
  }
}

function changeInput(e) {
  hiddenField = document.getElementById(`${e.name}-${e.dataset.field_id}`);
  hiddenField.value = e.value;
  console.log(hiddenField.value);
}

function setAttributes(el, attrs) {
  for (var key in attrs) {
    el.setAttribute(key, attrs[key]);
  }
}

function sendFormData(form) {
  var request = new XMLHttpRequest();
  request.open("POST", "submitForm.php");
  request.send(new FormData(form));
}

function getFieldType(text) {
  //switch case do not work here, wtf?!
  t = "text";
  if (isDate(text)) {
    t = "date";
  } else if (isNumeric(text)) {
    t = "number";
  }
  return t;
}

function isNumeric(str) {
  if (typeof str != "string") return false;
  return !isNaN(str) && !isNaN(parseFloat(str));
}

function isDate(date) {
  var parsedDate = Date.parse(date);
  is_date = isNaN(date) && !isNaN(parsedDate);
  return is_date;
}
