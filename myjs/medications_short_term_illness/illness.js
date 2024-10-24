const illness1 = document.getElementById("illness1");
const illness2 = document.getElementById("illness2");

const illness_specify = document.getElementById("illness_specify");
const sick = document.getElementById("sick");

function toggleElementVisibility() {
  if (illness1.checked) {
    illness_specify.style.display = "block";
    sick.style.display = "block";
  } else {
    illness_specify.style.display = "none";
    sick.style.display = "none";
  }
}

illness1.addEventListener("change", toggleElementVisibility);
illness2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
