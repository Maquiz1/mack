const sick1 = document.getElementById("sick1");
const sick2 = document.getElementById("sick2");

const sick_specify = document.getElementById("sick_specify");

function toggleElementVisibility() {
  if (sick1.checked) {
    sick_specify.style.display = "block";
  } else {
    sick_specify.style.display = "none";
  }
}

sick1.addEventListener("change", toggleElementVisibility);
sick2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
