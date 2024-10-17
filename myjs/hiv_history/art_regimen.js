const art_regimen1 = document.getElementById("art_regimen1");
const art_regimen2 = document.getElementById("art_regimen2");
const art_regimen3 = document.getElementById("art_regimen3");
const art_regimen4 = document.getElementById("art_regimen4");
const art_regimen5 = document.getElementById("art_regimen5");

const first_line = document.getElementById("first_line");
const second_line = document.getElementById("second_line");
const third_line = document.getElementById("third_line");
const art_regimen_other = document.getElementById("art_regimen_other");

function toggleElementVisibility() {
  if (art_regimen1.checked) {
    first_line.style.display = "block";
    second_line.style.display = "none";
    third_line.style.display = "none";
    art_regimen_other.style.display = "none";
  } else if (art_regimen2.checked) {
    first_line.style.display = "none";
    second_line.style.display = "block";
    third_line.style.display = "none";
    art_regimen_other.style.display = "none";
  } else if (art_regimen3.checked) {
    first_line.style.display = "none";
    second_line.style.display = "none";
    third_line.style.display = "block";
    art_regimen_other.style.display = "none";
  } else if (art_regimen5.checked) {
    first_line.style.display = "none";
    second_line.style.display = "none";
    third_line.style.display = "none";
    art_regimen_other.style.display = "block";
  } else {
    first_line.style.display = "none";
    second_line.style.display = "none";
    third_line.style.display = "none";
    art_regimen_other.style.display = "none";
  }
}

art_regimen1.addEventListener("change", toggleElementVisibility);
art_regimen2.addEventListener("change", toggleElementVisibility);
art_regimen3.addEventListener("change", toggleElementVisibility);
art_regimen4.addEventListener("change", toggleElementVisibility);
art_regimen5.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
