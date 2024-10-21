const physically_active1 = document.getElementById("physically_active1");
const physically_active2 = document.getElementById("physically_active2");

const activity_grade = document.getElementById("activity_grade");

function toggleElementVisibility() {
  if (physically_active1.checked) {
    activity_grade.style.display = "block";
  } else {
    activity_grade.style.display = "none";
  }
}

physically_active1.addEventListener("change", toggleElementVisibility);
physically_active2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
