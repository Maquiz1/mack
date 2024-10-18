const second_line1 = document.getElementById("second_line1");
const second_line2 = document.getElementById("second_line2");
const second_line3 = document.getElementById("second_line3");
const second_line4 = document.getElementById("second_line4");
const second_line5 = document.getElementById("second_line5");
const second_line6 = document.getElementById("second_line6");
const second_line7 = document.getElementById("second_line7");
const second_line8 = document.getElementById("second_line8");
const second_line9 = document.getElementById("second_line9");
const second_line10 = document.getElementById("second_line10");
const second_line11 = document.getElementById("second_line11");

const other_second_line = document.getElementById("other_second_line");

function toggleElementVisibility() {
  if (second_line11.checked) {
    other_second_line.style.display = "block";
  } else {
    other_second_line.style.display = "none";
  }
}

second_line1.addEventListener("change", toggleElementVisibility);
second_line2.addEventListener("change", toggleElementVisibility);
second_line3.addEventListener("change", toggleElementVisibility);
second_line4.addEventListener("change", toggleElementVisibility);
second_line5.addEventListener("change", toggleElementVisibility);
second_line6.addEventListener("change", toggleElementVisibility);
second_line7.addEventListener("change", toggleElementVisibility);
second_line8.addEventListener("change", toggleElementVisibility);
second_line9.addEventListener("change", toggleElementVisibility);
second_line10.addEventListener("change", toggleElementVisibility);
second_line11.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
