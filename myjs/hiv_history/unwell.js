const unwell1 = document.getElementById("unwell1");
const unwell2 = document.getElementById("unwell2");

const what_health_problem0 = document.getElementById("what_health_problem0");
const what_health_problem = document.getElementById("what_health_problem");

function toggleElementVisibility() {
  if (unwell1.checked) {
    what_health_problem0.style.display = "block";
    what_health_problem.style.display = "block";
  } else {
    what_health_problem0.style.display = "none";
    what_health_problem.style.display = "none";
  }
}

unwell1.addEventListener("change", toggleElementVisibility);
unwell2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
