const cardiac_anatomy1 = document.getElementById("cardiac_anatomy1");
const cardiac_anatomy2 = document.getElementById("cardiac_anatomy2");

const abnorm_cardiac_anatom = document.getElementById("abnorm_cardiac_anatom");


function toggleElementVisibility() {
    if (cardiac_anatomy1.checked) {
        abnorm_cardiac_anatom.style.display = "block";
    } else {
        abnorm_cardiac_anatom.style.display = "none";
    }
}

cardiac_anatomy1.addEventListener("change", toggleElementVisibility);
cardiac_anatomy2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
