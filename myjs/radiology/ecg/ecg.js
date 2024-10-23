const ecg1 = document.getElementById("ecg1");
const ecg2 = document.getElementById("ecg2");

const ecg_date = document.getElementById("ecg_date");
const quality_ecg = document.getElementById("quality_ecg");
const ecg_hide = document.getElementById("ecg_hide");

function toggleElementVisibility() {
  if (ecg1.checked) {
    ecg_date.style.display = "block";
    quality_ecg.style.display = "block";
    ecg_hide.style.display = "block";
  } else {
    quality_ecg.style.display = "none";
    ecg_date.style.display = "none";
    ecg_hide.style.display = "none";
  }
}

ecg1.addEventListener("change", toggleElementVisibility);
ecg2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
