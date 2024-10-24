const echocardiogram1 = document.getElementById("echocardiogram1");
const echocardiogram2 = document.getElementById("echocardiogram2");

// const ecg_date = document.getElementById("ecg_date");
const quality_of_image_echo = document.getElementById("quality_of_image_echo");
const hide_echo = document.getElementById("hide_echo");

function toggleElementVisibility() {
  if (echocardiogram1.checked) {
    // ecg_date.style.display = "block";
    quality_of_image_echo.style.display = "block";
    hide_echo.style.display = "block";
  } else {
    // ecg_date.style.display = "none";
    quality_of_image_echo.style.display = "none";
    hide_echo.style.display = "none";
  }
}

echocardiogram1.addEventListener("change", toggleElementVisibility);
echocardiogram2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
