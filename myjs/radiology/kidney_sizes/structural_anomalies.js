const structural_anomalies1 = document.getElementById("structural_anomalies1");
const structural_anomalies2 = document.getElementById("structural_anomalies2");

const details_structural_anomali = document.getElementById("details_structural_anomali");


function toggleElementVisibility() {
    if (structural_anomalies1.checked) {
        details_structural_anomali.style.display = "block";
    } else {
        details_structural_anomali.style.display = "none";
    }
}

structural_anomalies1.addEventListener("change", toggleElementVisibility);
structural_anomalies2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
