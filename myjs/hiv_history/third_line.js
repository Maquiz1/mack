const third_line1 = document.getElementById("third_line1");
const third_line2 = document.getElementById("third_line2");
const third_line3 = document.getElementById("third_line3");
const third_line4 = document.getElementById("third_line4");
const third_line5 = document.getElementById("third_line5");
const third_line6 = document.getElementById("third_line6");
const third_line7 = document.getElementById("third_line7");
const third_line8 = document.getElementById("third_line8");
const third_line9 = document.getElementById("third_line9");
const third_line10 = document.getElementById("third_line10");
const third_line11 = document.getElementById("third_line11");

const other_third_line = document.getElementById("other_third_line");

function toggleElementVisibility() {
  if (third_line11.checked) {
    other_third_line.style.display = "block";
  } else {
    other_third_line.style.display = "none";
  }
}

third_line1.addEventListener("change", toggleElementVisibility);
third_line2.addEventListener("change", toggleElementVisibility);
third_line3.addEventListener("change", toggleElementVisibility);
third_line4.addEventListener("change", toggleElementVisibility);
third_line5.addEventListener("change", toggleElementVisibility);
third_line6.addEventListener("change", toggleElementVisibility);
third_line7.addEventListener("change", toggleElementVisibility);
third_line8.addEventListener("change", toggleElementVisibility);
third_line9.addEventListener("change", toggleElementVisibility);
third_line10.addEventListener("change", toggleElementVisibility);
third_line11.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
