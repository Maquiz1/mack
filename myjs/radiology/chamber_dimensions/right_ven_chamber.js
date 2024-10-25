const right_ven_chamber1 = document.getElementById("right_ven_chamber1");
const right_ven_chamber2 = document.getElementById("right_ven_chamber2");

const rvot_plax_dia = document.getElementById("rvot_plax_dia");
const rvot_prox_dia = document.getElementById("rvot_prox_dia");
const rvot_distal_dia = document.getElementById("rvot_distal_dia");
const rv_wall_thickness = document.getElementById("rv_wall_thickness");


function toggleElementVisibility() {
  if (right_ven_chamber1.checked) {
    rvot_plax_dia.style.display = "block";
    rvot_prox_dia.style.display = "block";
    rvot_distal_dia.style.display = "block";
    rv_wall_thickness.style.display = "block";
  } else {
    rvot_plax_dia.style.display = "none";
    rvot_prox_dia.style.display = "none";
    rvot_distal_dia.style.display = "none";
    rv_wall_thickness.style.display = "none";
  }
}

right_ven_chamber1.addEventListener("change", toggleElementVisibility);
right_ven_chamber2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
