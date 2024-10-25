const renal_ultrasound1 = document.getElementById("renal_ultrasound1");
const renal_ultrasound2 = document.getElementById("renal_ultrasound2");

const quality_renal = document.getElementById("quality_renal");


function toggleElementVisibility() {
    if (renal_ultrasound1.checked) {
        quality_renal.style.display = "block";
    } else {
        quality_renal.style.display = "none";
    }
}

renal_ultrasound1.addEventListener("change", toggleElementVisibility);
renal_ultrasound2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
