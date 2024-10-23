const rhythm1 = document.getElementById("rhythm1");
const rhythm2 = document.getElementById("rhythm2");

const other_heart_rhythm_ecg_L = document.getElementById("other_heart_rhythm_ecg_L");
const other_heart_rhythm_ecg = document.getElementById("other_heart_rhythm_ecg");

function toggleElementVisibility() {
  if (rhythm1.checked) {
    other_heart_rhythm_ecg_L.style.display = "block";
    other_heart_rhythm_ecg.style.display = "block";
  } else {
    other_heart_rhythm_ecg_L.style.display = "none";
    other_heart_rhythm_ecg.style.display = "none";
  }
}

rhythm1.addEventListener("change", toggleElementVisibility);
rhythm2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
