const structural_lesions1 = document.getElementById("structural_lesions1");
const structural_lesions2 = document.getElementById("structural_lesions2");

const state_struc_lession = document.getElementById("state_struc_lession");
const structural_lesions_hides = document.getElementById("structural_lesions_hides");



function toggleElementVisibility() {
  if (structural_lesions1.checked) {
    state_struc_lession.style.display = "block";
    structural_lesions_hides.style.display = "block";
  } else {
    state_struc_lession.style.display = "none";
    structural_lesions_hides.style.display = "block";
  }
}

structural_lesions1.addEventListener("change", toggleElementVisibility);
structural_lesions2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
