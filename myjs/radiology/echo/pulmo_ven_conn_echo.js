const pulmo_ven_conn_echo1 = document.getElementById("pulmo_ven_conn_echo1");
const pulmo_ven_conn_echo2 = document.getElementById("pulmo_ven_conn_echo2");

const specfy_ab_pulven_con = document.getElementById("specfy_ab_pulven_con");

function toggleElementVisibility() {
  if (pulmo_ven_conn_echo2.checked) {
    specfy_ab_pulven_con.style.display = "block";
  } else {
    specfy_ab_pulven_con.style.display = "none";
  }
}

pulmo_ven_conn_echo1.addEventListener("change", toggleElementVisibility);
pulmo_ven_conn_echo2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
