const pericardial_effusion1 = document.getElementById("pericardial_effusion1");
const pericardial_effusion2 = document.getElementById("pericardial_effusion2");

const measure_deep_pool = document.getElementById("measure_deep_pool");

function toggleElementVisibility() {
  if (pericardial_effusion1.checked) {
    measure_deep_pool.style.display = "block";
  } else {
    measure_deep_pool.style.display = "none";
  }
}

pericardial_effusion1.addEventListener("change", toggleElementVisibility);
pericardial_effusion2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
