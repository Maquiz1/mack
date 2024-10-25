const hydronephrosis1 = document.getElementById("hydronephrosis1");
const hydronephrosis2 = document.getElementById("hydronephrosis2");

const yes_hydronephrosis = document.getElementById("yes_hydronephrosis");


function toggleElementVisibility() {
    if (hydronephrosis1.checked) {
        yes_hydronephrosis.style.display = "block";
    } else {
        yes_hydronephrosis.style.display = "none";
    }
}

hydronephrosis1.addEventListener("change", toggleElementVisibility);
hydronephrosis2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
