const left_ventrical_mmode1 = document.getElementById("left_ventrical_mmode1");
const left_ventrical_mmode2 = document.getElementById("left_ventrical_mmode2");

const free_wall_thickness = document.getElementById("free_wall_thickness");
const septal_thickness = document.getElementById("septal_thickness");
const free_wall_thickness_2 = document.getElementById("free_wall_thickness_2");

function toggleElementVisibility() {
  if (left_ventrical_mmode1.checked) {
    free_wall_thickness.style.display = "block";
    septal_thickness.style.display = "block";
    free_wall_thickness_2.style.display = "block";
  } else {
    free_wall_thickness.style.display = "none";
    septal_thickness.style.display = "none";
    free_wall_thickness_2.style.display = "none";
  }
}

left_ventrical_mmode1.addEventListener("change", toggleElementVisibility);
left_ventrical_mmode2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
