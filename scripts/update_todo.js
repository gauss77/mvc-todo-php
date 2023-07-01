// Updating Variables
let update_btn = document.querySelectorAll("button[data-action='update']"),
  modal_textArea = document.querySelector("textarea"),
  input_id = document.getElementById("todo_form_id"),
  form_update = document.getElementById("form_update"),
  alert_box = document.getElementById("alert"),
  modal = document.getElementById("staticBackdrop");

update_btn.forEach((element) => {
  element.addEventListener("click", function (e) {
    let todo_id = this.getAttribute("data-todo-id");
    let todo_content = this.parentElement.parentElement.firstElementChild.innerText;

    modal_textArea.value = todo_content;
    input_id = todo_id;
  });
});

form_update.addEventListener("submit", function (e) {
  e.preventDefault();

  let new_todo = modal_textArea.value;
  let backdrop = document.getElementsByClassName("modal-backdrop")[0];

  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.status == 200 && this.readyState == 4) {
      update_response = this.responseText;

      if (update_response == "GOOD") {
        alert_box.classList.remove("d-none");
        modal.classList.remove("show");
        modal.style.display = "none";
        backdrop.remove();

        // TODO: Use Ajax To Reload The Table Only
        window.location.replace("index.php?action=afficher");
      }
    }
  };

  xhr.open("POST", "index.php?action=update");
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(`todo=${new_todo}&todo_id=${input_id}`);
});
