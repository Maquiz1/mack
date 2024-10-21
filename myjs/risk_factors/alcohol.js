const alcohol1 = document.getElementById("alcohol1");
const alcohol2 = document.getElementById("alcohol2");

const drink_cont_alcoh0 = document.getElementById("drink_cont_alcoh0");
const drink_cont_alcoh = document.getElementById("drink_cont_alcoh");

const cant_stop_drink0 = document.getElementById("cant_stop_drink0");
const cant_stop_drink = document.getElementById("cant_stop_drink");

const cant_remember0 = document.getElementById("cant_remember0");
const cant_remember = document.getElementById("cant_remember");

function toggleElementVisibility() {
  if (alcohol1.checked) {
    drink_cont_alcoh0.style.display = "block";
    drink_cont_alcoh.style.display = "block";
    cant_stop_drink0.style.display = "block";
    cant_stop_drink.style.display = "block";
    cant_remember0.style.display = "block";
    cant_remember.style.display = "block";
  } else {
    drink_cont_alcoh0.style.display = "none";
    drink_cont_alcoh.style.display = "none";
    cant_stop_drink0.style.display = "none";
    cant_stop_drink.style.display = "none";
    cant_remember0.style.display = "none";
    cant_remember.style.display = "none";
  }
}

alcohol1.addEventListener("change", toggleElementVisibility);
alcohol2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
