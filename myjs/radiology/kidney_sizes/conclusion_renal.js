const conclusion_renal1 = document.getElementById("conclusion_renal1");
const conclusion_renal2 = document.getElementById("conclusion_renal2");

const abnor_o_border_renal = document.getElementById("abnor_o_border_renal");


function toggleElementVisibility() {
    if (conclusion_renal1.checked) {
        abnor_o_border_renal.style.display = "block";
    } else {
        abnor_o_border_renal.style.display = "none";
    }
}

conclusion_renal1.addEventListener("change", toggleElementVisibility);
conclusion_renal2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
