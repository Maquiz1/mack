const left_atrium1 = document.getElementById("left_atrium1");
const left_atrium2 = document.getElementById("left_atrium2");

const lf_atriu_parasternal = document.getElementById("lf_atriu_parasternal");
const lf_atrium_4chamb_long = document.getElementById("lf_atrium_4chamb_long");
const lf_atrium_4chamb_minor = document.getElementById("lf_atrium_4chamb_minor");

function toggleElementVisibility() {
  if (left_atrium1.checked) {
    lf_atriu_parasternal.style.display = "block";
    lf_atrium_4chamb_long.style.display = "block";
    lf_atrium_4chamb_minor.style.display = "block";
  } else {
    lf_atriu_parasternal.style.display = "none";
    lf_atrium_4chamb_long.style.display = "none";
    lf_atrium_4chamb_minor.style.display = "none";
  }
}

left_atrium1.addEventListener("change", toggleElementVisibility);
left_atrium2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
