const esti_rv_sbp1 = document.getElementById("esti_rv_sbp1");
const esti_rv_sbp2 = document.getElementById("esti_rv_sbp2");

const estimate_rv_sbp = document.getElementById("estimate_rv_sbp");
const ivc_dimen_n_collapsi = document.getElementById("ivc_dimen_n_collapsi");
const inferior_venacava = document.getElementById("inferior_venacava");
const quali_asses_valvar_regurgi = document.getElementById("quali_asses_valvar_regurgi");


function toggleElementVisibility() {
    if (esti_rv_sbp1.checked) {
        estimate_rv_sbp.style.display = "block";
        ivc_dimen_n_collapsi.style.display = "block";
        inferior_venacava.style.display = "block";
        quali_asses_valvar_regurgi.style.display = "block";
    } else {
        estimate_rv_sbp.style.display = "none";
        ivc_dimen_n_collapsi.style.display = "none";
        inferior_venacava.style.display = "none";
        quali_asses_valvar_regurgi.style.display = "none";
    }
}

esti_rv_sbp1.addEventListener("change", toggleElementVisibility);
esti_rv_sbp2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
