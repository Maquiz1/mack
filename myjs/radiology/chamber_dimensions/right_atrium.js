const right_atrium1 = document.getElementById("right_atrium1");
const right_atrium2 = document.getElementById("right_atrium2");

const rt_4chamb_long = document.getElementById("rt_4chamb_long");
const rt_4chamb_transverse = document.getElementById("rt_4chamb_transverse");
const lf_atrium_4chamb_minor2 = document.getElementById("lf_atrium_4chamb_minor2");

function toggleElementVisibility() {
  if (right_atrium1.checked) {
    rt_4chamb_long.style.display = "block";
    rt_4chamb_transverse.style.display = "block";
    lf_atrium_4chamb_minor2.style.display = "block";
  } else {
    rt_4chamb_long.style.display = "none";
    rt_4chamb_transverse.style.display = "none";
    lf_atrium_4chamb_minor2.style.display = "none";
  }
}

right_atrium1.addEventListener("change", toggleElementVisibility);
right_atrium2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
