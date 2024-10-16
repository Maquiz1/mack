const ever_smoked1 = document.getElementById("ever_smoked1");
const ever_smoked2 = document.getElementById("ever_smoked2");

const start_smoking = document.getElementById("start_smoking");
const currently_smoking = document.getElementById("currently_smoking");
const ever_smoked = document.getElementById("ever_smoked");

function toggleElementVisibility() {
  if (ever_smoked1.checked) {
    start_smoking.style.display = "block";
    currently_smoking.style.display = "block";
    ever_smoked.style.display = "block";
  } else {
    start_smoking.style.display = "none";
    currently_smoking.style.display = "none";
    ever_smoked.style.display = "none";
  }
}

ever_smoked1.addEventListener("change", toggleElementVisibility);
ever_smoked2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();




function toggleRequired(radio) {

  // if (radio.checked) {
  //   radio.checked = false;
  // } else {
  //   radio.checked = true;
  // }


  var start_smoking1 = document.getElementById("start_smoking1");
  var currently_smokingRequired = currently_smoking.querySelector(
    'input[name="currently_smoking"]'
  );


  if (radio.value === "1") {
    start_smoking1.setAttribute("required", "required");

    document
      .getElementById("packs_cigarette_day")
      .setAttribute("required", "required");

    currently_smokingRequired.setAttribute("required", "required");

    document
      .getElementById("ever_smoked")
      .querySelector('input[name="type_smoked"]')
      .setAttribute("required", "required");
  } else {
    currently_smokingRequired.removeAttribute("required");

    document
      .getElementById("packs_cigarette_day")
      .removeAttribute("required", "required");

    document
      .getElementById("ever_smoked")
      .querySelector('input[name="type_smoked"]')
      .removeAttribute("required", "required");

    start_smoking1.removeAttribute("required");
    // if (start_smoking1.value !== "") {
    //   start_smoking1.value = "";
    // }
  }
}
