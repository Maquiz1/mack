const alcohol1 = document.getElementById("alcohol1");
const alcohol2 = document.getElementById("alcohol2");

const drink_cont_alcoh1 = document.getElementById("drink_cont_alcoh1");
const drink_cont_alcoh2 = document.getElementById("drink_cont_alcoh2");
const drink_cont_alcoh3 = document.getElementById("drink_cont_alcoh3");
const drink_cont_alcoh4 = document.getElementById("drink_cont_alcoh4");
const drink_cont_alcoh5 = document.getElementById("drink_cont_alcoh5");

const total_1only = document.getElementById("total_1only");
const howmany_drinks = document.getElementById("howmany_drinks");
const drink_often = document.getElementById("drink_often");

const drink_often1 = document.getElementById("drink_often1");
const drink_often2 = document.getElementById("drink_often2");
const drink_often3 = document.getElementById("drink_often3");
const drink_often4 = document.getElementById("drink_often4");
const drink_often5 = document.getElementById("drink_often5");

const drink_cont_alcoh_H = document.getElementById("drink_cont_alcoh_H");
const drink_cont_alcoh = document.getElementById("drink_cont_alcoh");

const cant_stop_drink_H = document.getElementById("cant_stop_drink_H");
const cant_stop_drink = document.getElementById("cant_stop_drink");

const cant_remember_H = document.getElementById("cant_remember_H");
const cant_remember = document.getElementById("cant_remember");

function toggleElementVisibility() {
  if (alcohol1.checked) {
    drink_cont_alcoh_H.style.display = "block";
    drink_cont_alcoh.style.display = "block";
    if (
      drink_cont_alcoh2.checked ||
      drink_cont_alcoh3.checked ||
      drink_cont_alcoh4.checked ||
      drink_cont_alcoh5.checked
    ) {
      total_1only.style.display = "block";
      howmany_drinks.style.display = "block";
      drink_often.style.display = "block";

      cant_remember_H.style.display = "block";
      cant_remember.style.display = "block";
      if (
        drink_often2.checked ||
        drink_often3.checked ||
        drink_often4.checked ||
        drink_often5.checked
      ) {
        cant_stop_drink_H.style.display = "block";
        cant_stop_drink.style.display = "block";
      } else {
        cant_stop_drink_H.style.display = "none";
        cant_stop_drink.style.display = "none";
      }
    } else {
      total_1only.style.display = "none";
      howmany_drinks.style.display = "none";
      drink_often.style.display = "none";

      cant_stop_drink_H.style.display = "none";
      cant_stop_drink.style.display = "none";
      cant_remember_H.style.display = "none";
      cant_remember.style.display = "none";
    }
  } else {
    total_1only.style.display = "none";
    howmany_drinks.style.display = "none";
    drink_often.style.display = "none";

    drink_cont_alcoh_H.style.display = "none";
    drink_cont_alcoh.style.display = "none";
    cant_stop_drink_H.style.display = "none";
    cant_stop_drink.style.display = "none";
    cant_remember_H.style.display = "none";
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

drink_often1.addEventListener("change", toggleElementVisibility);
drink_often2.addEventListener("change", toggleElementVisibility);
drink_often3.addEventListener("change", toggleElementVisibility);
drink_often4.addEventListener("change", toggleElementVisibility);
drink_often5.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
