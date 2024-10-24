const quality_of_image_echo1 = document.getElementById(
  "quality_of_image_echo1"
);
const quality_of_image_echo2 = document.getElementById(
  "quality_of_image_echo2"
);

const brief_exp_subopt_echo = document.getElementById("brief_exp_subopt_echo");

function toggleElementVisibility() {
  if (quality_of_image_echo2.checked) {
    brief_exp_subopt_echo.style.display = "block";
  } else {
    brief_exp_subopt_echo.style.display = "none";
  }
}

quality_of_image_echo1.addEventListener("change", toggleElementVisibility);
quality_of_image_echo2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
