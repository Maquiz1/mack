const left_atrium1 = document.getElementById("left_atrium1");
const left_atrium2 = document.getElementById("left_atrium2");

const lf_atriu_parasternal3 = document.getElementById("lf_atriu_parasternal3");
const lf_atrium_4chamb_long3 = document.getElementById("lf_atrium_4chamb_long3");
const lf_atrium_4chamb_minor3 = document.getElementById("lf_atrium_4chamb_minor3");

function toggleElementVisibility() {
  if (left_atrium1.checked) {
    lf_atriu_parasternal3.style.display = "block";
    lf_atrium_4chamb_long3.style.display = "block";
    lf_atrium_4chamb_minor3.style.display = "block";
  } else {
    lf_atriu_parasternal3.style.display = "none";
    lf_atrium_4chamb_long3.style.display = "none";
    lf_atrium_4chamb_minor3.style.display = "none";
  }
}

left_atrium1.addEventListener("change", toggleElementVisibility);
left_atrium2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
