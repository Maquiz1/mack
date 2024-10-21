const smoke_stat1 = document.getElementById("smoke_stat1");
const smoke_stat0 = document.getElementById("smoke_stat0");
const smoke_stat2 = document.getElementById("smoke_stat2");

const smoking_yes = document.getElementById("smoking_yes");

function toggleElementVisibility() {
  if (smoke_stat1.checked) {
    smoking_yes.style.display = "block";
  } else {
    smoking_yes.style.display = "none";
  }
}

smoke_stat1.addEventListener("change", toggleElementVisibility);
smoke_stat0.addEventListener("change", toggleElementVisibility);
smoke_stat2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
