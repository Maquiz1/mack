const ncd_screening1 = document.getElementById("ncd_screening1");
const ncd_screening2 = document.getElementById("ncd_screening2");

const chronic_illness_type = document.getElementById("chronic_illness_type");
const start_date_chronic = document.getElementById("start_date_chronic");

function toggleElementVisibility() {
  if (ncd_screening1.checked) {
    chronic_illness_type.style.display = "block";
    start_date_chronic.style.display = "block";
  } else {
    chronic_illness_type.style.display = "none";
    start_date_chronic.style.display = "none";
  }
}

ncd_screening1.addEventListener("change", toggleElementVisibility);
ncd_screening2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
