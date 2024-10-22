const covid191 = document.getElementById("covid191");
const covid192 = document.getElementById("covid192");

const vaccine_covid19 = document.getElementById("vaccine_covid19");

function toggleElementVisibility() {
  if (covid191.checked) {
    vaccine_covid19.style.display = "block";
  } else {
    vaccine_covid19.style.display = "none";
  }
}

covid191.addEventListener("change", toggleElementVisibility);
covid192.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
