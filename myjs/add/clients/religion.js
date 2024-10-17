const religion1 = document.getElementById("religion1");
const religion2 = document.getElementById("religion2");
const religion3 = document.getElementById("religion3");

const other_religion1 = document.getElementById("other_religion1");
const other_religion = document.getElementById("other_religion");

function toggleElementVisibility() {
  if (religion3.checked) {
    other_religion1.style.display = "block";
    other_religion.style.display = "block";
    other_religion.setAttribute("required", "required");
  } else {
    other_religion1.removeAttribute("required");
    other_religion.style.display = "none";
    other_religion.style.display = "none";
  }
}

religion1.addEventListener("change", toggleElementVisibility);
religion2.addEventListener("change", toggleElementVisibility);
religion3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
