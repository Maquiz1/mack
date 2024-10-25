const lt_2d_plax_view1 = document.getElementById("lt_2d_plax_view1");
const lt_2d_plax_view2 = document.getElementById("lt_2d_plax_view2");

const d_freewall_thick_plax = document.getElementById("d_freewall_thick_plax");
const d_septal_thick_plax = document.getElementById("d_septal_thick_plax");
const d_freewall_thick_plax2 = document.getElementById("d_freewall_thick_plax2");

function toggleElementVisibility() {
  if (lt_2d_plax_view1.checked) {
    d_freewall_thick_plax.style.display = "block";
    d_septal_thick_plax.style.display = "block";
    d_freewall_thick_plax2.style.display = "block";
  } else {
    d_freewall_thick_plax.style.display = "none";
    d_septal_thick_plax.style.display = "none";
    d_freewall_thick_plax2.style.display = "none";
  }
}

lt_2d_plax_view1.addEventListener("change", toggleElementVisibility);
lt_2d_plax_view2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
