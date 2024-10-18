const same_regimen1 = document.getElementById("same_regimen1");
const same_regimen2 = document.getElementById("same_regimen2");

const name_regimen0 = document.getElementById("name_regimen0");
const name_regimen = document.getElementById("name_regimen");

function toggleElementVisibility() {
  if (same_regimen2.checked) {
    name_regimen0.style.display = "block";
    name_regimen.style.display = "block";
  } else {
    name_regimen0.style.display = "none";
    name_regimen.style.display = "none";
  }
}

same_regimen1.addEventListener("change", toggleElementVisibility);
same_regimen2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
