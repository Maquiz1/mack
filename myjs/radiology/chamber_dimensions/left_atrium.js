const structural_lesions1 = document.getElementById("structural_lesions1");
const structural_lesions2 = document.getElementById("structural_lesions2");

const state_struc_lession = document.getElementById("state_struc_lession");
const size = document.getElementById("size");
const site_struc_lesion = document.getElementById("site_struc_lesion");
const hemodynamics_stru_lesio = document.getElementById(
  "hemodynamics_stru_lesio"
);
const structural_lesions_H = document.getElementById("structural_lesions_H");

function toggleElementVisibility() {
  if (structural_lesions1.checked) {
    state_struc_lession.style.display = "block";
    size.style.display = "block";
    site_struc_lesion.style.display = "block";
    hemodynamics_stru_lesio.style.display = "block";
    structural_lesions_H.style.display = "block";
  } else {
    state_struc_lession.style.display = "none";
    size.style.display = "none";
    site_struc_lesion.style.display = "none";
    hemodynamics_stru_lesio.style.display = "none";
    structural_lesions_H.style.display = "none";
  }
}

structural_lesions1.addEventListener("change", toggleElementVisibility);
structural_lesions2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
