const syst_vein_connect_echo1 = document.getElementById(
  "syst_vein_connect_echo1"
);
const syst_vein_connect_echo2 = document.getElementById(
  "syst_vein_connect_echo2"
);

const specify_ab_sysvein_con = document.getElementById(
  "specify_ab_sysvein_con"
);

function toggleElementVisibility() {
  if (syst_vein_connect_echo2.checked) {
    specify_ab_sysvein_con.style.display = "block";
  } else {
    specify_ab_sysvein_con.style.display = "none";
  }
}

syst_vein_connect_echo1.addEventListener("change", toggleElementVisibility);
syst_vein_connect_echo2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
