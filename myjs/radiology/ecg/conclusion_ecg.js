const conclusion_ecg1 = document.getElementById("conclusion_ecg1");
const conclusion_ecg2 = document.getElementById("conclusion_ecg2");
const conclusion_ecg3 = document.getElementById("conclusion_ecg3");

const abno_o_borderl_specify = document.getElementById(
  "abno_o_borderl_specify"
);

function toggleElementVisibility() {
  if (conclusion_ecg1.checked) {
    abno_o_borderl_specify.style.display = "block";
  } else {
    abno_o_borderl_specify.style.display = "none";
  }
}

conclusion_ecg1.addEventListener("change", toggleElementVisibility);
conclusion_ecg2.addEventListener("change", toggleElementVisibility);
conclusion_ecg3.addEventListener("change", toggleElementVisibility);


// Initial check
toggleElementVisibility();
