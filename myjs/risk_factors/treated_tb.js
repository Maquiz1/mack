const treated_tb1 = document.getElementById("treated_tb1");
const treated_tb2 = document.getElementById("treated_tb2");

const date_treated_tb0 = document.getElementById("date_treated_tb0");

function toggleElementVisibility() {
  if (treated_tb1.checked) {
    date_treated_tb0.style.display = "block";
  } else {
    date_treated_tb0.style.display = "none";
  }
}

treated_tb1.addEventListener("change", toggleElementVisibility);
treated_tb2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
