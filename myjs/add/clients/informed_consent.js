const informed_consent1 = document.getElementById("informed_consent1");
const informed_consent2 = document.getElementById("informed_consent2");

const date_informed_consent1 = document.getElementById(
  "date_informed_consent1"
);
const date_informed_consent = document.getElementById("date_informed_consent");

function toggleElementVisibility() {
  if (informed_consent1.checked) {
    date_informed_consent1.style.display = "block";
    date_informed_consent.setAttribute("required", "required");
  } else if (informed_consent2.checked) {
    date_informed_consent.removeAttribute("required");
    date_informed_consent1.style.display = "none";
  } else {
    date_informed_consent.removeAttribute("required");
    date_informed_consent1.style.display = "none";
  }
}

informed_consent1.addEventListener("change", toggleElementVisibility);
informed_consent2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
