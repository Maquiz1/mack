const religion1 = document.getElementById("religion1");
const religion2 = document.getElementById("religion2");
const religion3 = document.getElementById("religion3");

const other_religion0 = document.getElementById("other_religion0");
const other_religion = document.getElementById("other_religion");

function toggleElementVisibility() {
  if (religion3.checked) {
    other_religion0.style.display = "block";
    other_religion.style.display = "block";
    other_religion.setAttribute("required", "required");
  } else {
    other_religion.removeAttribute("required");
    other_religion0.style.display = "none";
    other_religion.style.display = "none";
  }
}

religion1.addEventListener("change", toggleElementVisibility);
religion2.addEventListener("change", toggleElementVisibility);
religion3.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
