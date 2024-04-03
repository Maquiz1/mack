const occupation1 = document.getElementById("occupation1");
const occupation2 = document.getElementById("occupation2");
const occupation3 = document.getElementById("occupation3");
const occupation4 = document.getElementById("occupation4");
const occupation5 = document.getElementById("occupation5");

const unskilled1 = document.getElementById("unskilled1");
const unskilled = document.getElementById("unskilled");

const profesional_worker1 = document.getElementById("profesional_worker1");
const profesional_worker = document.getElementById("profesional_worker");

const other_occupation1 = document.getElementById("other_occupation1");
const other_occupation = document.getElementById("other_occupation");

function toggleElementVisibility() {
  if (occupation3.checked) {
    unskilled1.style.display = "block";
    unskilled.style.display = "block";
    profesional_worker1.style.display = "none";
    profesional_worker.style.display = "none";
    other_occupation1.style.display = "none";
    other_occupation.style.display = "none";
  } else if (occupation4.checked) {
    unskilled1.style.display = "none";
    unskilled.style.display = "none";
    profesional_worker1.style.display = "block";
    profesional_worker.style.display = "block";
    other_occupation1.style.display = "none";
    other_occupation.style.display = "none";
  } else if (occupation5.checked) {
    unskilled1.style.display = "none";
    unskilled.style.display = "none";
    profesional_worker1.style.display = "none";
    profesional_worker.style.display = "none";
    other_occupation1.style.display = "block";
    other_occupation.style.display = "block";
  } else {
    unskilled1.style.display = "none";
    unskilled.style.display = "none";
    profesional_worker1.style.display = "none";
    profesional_worker.style.display = "none";
    other_occupation1.style.display = "none";
    other_occupation.style.display = "none";
  }
}

occupation1.addEventListener("change", toggleElementVisibility);
occupation2.addEventListener("change", toggleElementVisibility);
occupation3.addEventListener("change", toggleElementVisibility);
occupation4.addEventListener("change", toggleElementVisibility);
occupation5.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
