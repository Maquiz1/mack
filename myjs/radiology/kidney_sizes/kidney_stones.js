const kidney_stones1 = document.getElementById("kidney_stones1");
const kidney_stones2 = document.getElementById("kidney_stones2");

const detail_kidneystones = document.getElementById("detail_kidneystones");


function toggleElementVisibility() {
    if (kidney_stones1.checked) {
        detail_kidneystones.style.display = "block";
    } else {
        detail_kidneystones.style.display = "none";
    }
}

kidney_stones1.addEventListener("change", toggleElementVisibility);
kidney_stones2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
