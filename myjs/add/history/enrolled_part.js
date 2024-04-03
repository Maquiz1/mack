const enrolled_part1 = document.getElementById("enrolled_part1");
const enrolled_part2 = document.getElementById("enrolled_part2");

const participant_id = document.getElementById("participant_id");
const screen_failure = document.getElementById("screen_failure");

function toggleElementVisibility() {
  if (enrolled_part1.checked) {
    participant_id.style.display = "block";
    screen_failure.style.display = "none";
  } else if (enrolled_part2.checked) {
    participant_id.style.display = "none";
    screen_failure.style.display = "block";
  } else {
    participant_id.style.display = "none";
    screen_failure.style.display = "none";
  }
}

enrolled_part1.addEventListener("change", toggleElementVisibility);
enrolled_part2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
