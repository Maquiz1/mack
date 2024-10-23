const medicines1 = document.getElementById("medicines1");
const medicines2 = document.getElementById("medicines2");

const medicines_specify = document.getElementById("medicines_specify");
const long_used = document.getElementById("long_used");

function toggleElementVisibility() {
  if (medicines1.checked) {
    medicines_specify.style.display = "block";
    long_used.style.display = "block";
  } else {
    medicines_specify.style.display = "none";
    long_used.style.display = "none";
  }
}

medicines1.addEventListener("change", toggleElementVisibility);
medicines2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
