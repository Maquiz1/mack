const heart_rythm_ecg1 = document.getElementById("heart_rythm_ecg1");
const heart_rythm_ecg2 = document.getElementById("heart_rythm_ecg2");

const other_heart_rhythm_ecg_L = document.getElementById("other_heart_rhythm_ecg_L");
const other_heart_rhythm_ecg = document.getElementById("other_heart_rhythm_ecg");

function toggleElementVisibility() {
  if (heart_rythm_ecg2.checked) {
    other_heart_rhythm_ecg_L.style.display = "block";
    other_heart_rhythm_ecg.style.display = "block";
  } else {
    other_heart_rhythm_ecg_L.style.display = "none";
    other_heart_rhythm_ecg.style.display = "none";
  }
}

heart_rythm_ecg1.addEventListener("change", toggleElementVisibility);
heart_rythm_ecg2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
