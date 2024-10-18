const second_line1 = document.getElementById("second_line1");
const second_line2 = document.getElementById("second_line2");
const second_line3 = document.getElementById("second_line3");
const second_line4 = document.getElementById("second_line4");
const second_line5 = document.getElementById("second_line5");

const other_second_line = document.getElementById("other_second_line");

function toggleElementVisibility() {
  if (second_line5.checked) {
    other_second_line.style.display = "block";
    // other_second_line.setAttribute("required", "required");
  } else {
    // date_informed_consent.removeAttribute("required");
    other_second_line.style.display = "none";
  }
}

second_line1.addEventListener("change", toggleElementVisibility);
second_line2.addEventListener("change", toggleElementVisibility);
second_line3.addEventListener("change", toggleElementVisibility);
second_line4.addEventListener("change", toggleElementVisibility);
second_line5.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
