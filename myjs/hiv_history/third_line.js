const third_line1 = document.getElementById("third_line1");
const third_line2 = document.getElementById("third_line2");
const third_line3 = document.getElementById("third_line3");
const third_line4 = document.getElementById("third_line4");
const third_line5 = document.getElementById("third_line5");

const other_third_line = document.getElementById("other_third_line");

function toggleElementVisibility() {
  if (third_line5.checked) {
    // other_third_line.style.display = "block";
    other_third_line.setAttribute("required", "required");
  } else {
    other_third_line.removeAttribute("required");
    // other_third_line.style.display = "none";
  }
}

third_line1.addEventListener("change", toggleElementVisibility);
third_line2.addEventListener("change", toggleElementVisibility);
third_line3.addEventListener("change", toggleElementVisibility);
third_line4.addEventListener("change", toggleElementVisibility);
third_line5.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
