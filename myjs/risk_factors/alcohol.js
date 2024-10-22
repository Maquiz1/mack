const alcohol1 = document.getElementById("alcohol1");
const alcohol2 = document.getElementById("alcohol2");

const drink_cont_alcoh1 = document.getElementById("drink_cont_alcoh1");
const drink_cont_alcoh2 = document.getElementById("drink_cont_alcoh2");
const drink_cont_alcoh3 = document.getElementById("drink_cont_alcoh3");
const drink_cont_alcoh4 = document.getElementById("drink_cont_alcoh4");
const drink_cont_alcoh5 = document.getElementById("drink_cont_alcoh5");

const total_1only0 = document.getElementById("total_1only0");
const howmany_drinks0 = document.getElementById("howmany_drinks0");
const drink_often = document.getElementById("drink_often");

const drink_often0 = document.getElementById("drink_often0");
const drink_often1 = document.getElementById("drink_often1");
const drink_often2 = document.getElementById("drink_often2");
const drink_often3 = document.getElementById("drink_often3");
const drink_often4 = document.getElementById("drink_often4");

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
    if (
      drink_cont_alcoh2.checked ||
      drink_cont_alcoh3.checked ||
      drink_cont_alcoh4.checked ||
      drink_cont_alcoh5.checked
    ) {
      total_1only0.style.display = "block";
      howmany_drinks0.style.display = "block";
      drink_often.style.display = "block";

      cant_stop_drink0.style.display = "block";
      cant_stop_drink.style.display = "block";
      cant_remember0.style.display = "block";
      cant_remember.style.display = "block";
    } else {
      total_1only0.style.display = "none";
      howmany_drinks0.style.display = "none";
      drink_often.style.display = "none";

      cant_stop_drink0.style.display = "none";
      cant_stop_drink.style.display = "none";
      cant_remember0.style.display = "none";
      cant_remember.style.display = "none";
    }
  } else {
    total_1only0.style.display = "none";
    howmany_drinks0.style.display = "none";
    drink_often.style.display = "none";

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

drink_cont_alcoh1.addEventListener("change", toggleElementVisibility);
drink_cont_alcoh2.addEventListener("change", toggleElementVisibility);
drink_cont_alcoh3.addEventListener("change", toggleElementVisibility);
drink_cont_alcoh4.addEventListener("change", toggleElementVisibility);
drink_cont_alcoh5.addEventListener("change", toggleElementVisibility);

drink_often0.addEventListener("change", toggleElementVisibility);
drink_often1.addEventListener("change", toggleElementVisibility);
drink_often2.addEventListener("change", toggleElementVisibility);
drink_often3.addEventListener("change", toggleElementVisibility);
drink_often4.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
