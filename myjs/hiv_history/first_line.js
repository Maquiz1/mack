const first_line1 = document.getElementById("first_line1");
const first_line2 = document.getElementById("first_line2");
const first_line3 = document.getElementById("first_line3");
const first_line4 = document.getElementById("first_line4");
const first_line5 = document.getElementById("first_line5");
const first_line6 = document.getElementById("first_line6");
const first_line7 = document.getElementById("first_line7");
const first_line8 = document.getElementById("first_line8");
const first_line9 = document.getElementById("first_line9");
const first_line10 = document.getElementById("first_line10");
const first_line11 = document.getElementById("first_line11");

const other_first_line = document.getElementById("other_first_line");

function toggleElementVisibility() {
  if (art_regimen1.checked) {
    other_first_line.style.display = "block";
  } else {
    other_first_line.style.display = "none";
  }
}

first_line1.addEventListener("change", toggleElementVisibility);
first_line2.addEventListener("change", toggleElementVisibility);
first_line3.addEventListener("change", toggleElementVisibility);
first_line4.addEventListener("change", toggleElementVisibility);
first_line5.addEventListener("change", toggleElementVisibility);
first_line6.addEventListener("change", toggleElementVisibility);
first_line7.addEventListener("change", toggleElementVisibility);
first_line8.addEventListener("change", toggleElementVisibility);
first_line9.addEventListener("change", toggleElementVisibility);
first_line10.addEventListener("change", toggleElementVisibility);
first_line11.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
