const cardiac_function1 = document.getElementById("cardiac_function1");
const cardiac_function2 = document.getElementById("cardiac_function2");

const abnorm_cardia_func = document.getElementById("abnorm_cardia_func");


function toggleElementVisibility() {
    if (cardiac_function1.checked) {
        abnorm_cardia_func.style.display = "block";
    } else {
        abnorm_cardia_func.style.display = "none";
    }
}

cardiac_function1.addEventListener("change", toggleElementVisibility);
cardiac_function2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
