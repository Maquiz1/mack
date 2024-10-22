const smoking_yes1 = document.getElementById("smoking_yes1");
const smoking_yes2 = document.getElementById("smoking_yes2");
const smoking_yes3 = document.getElementById("smoking_yes3");
const smoking_yes4 = document.getElementById("smoking_yes4");

const smokeless0 = document.getElementById("smokeless0");
const smokeless1 = document.getElementById("smokeless1");
const smokeless2 = document.getElementById("smokeless2");
const smokeless3 = document.getElementById("smokeless3");

const smoking0 = document.getElementById("smoking0");
const smoking1 = document.getElementById("smoking1");
const smoking2 = document.getElementById("smoking2");
const smoking3 = document.getElementById("smoking3");

const ecigarette0 = document.getElementById("ecigarette0");
const ecigarette1 = document.getElementById("ecigarette1");
const ecigarette2 = document.getElementById("ecigarette2");
const ecigarette3 = document.getElementById("ecigarette3");

const other_tobacco0 = document.getElementById("other_tobacco0");
const other_tobacco1 = document.getElementById("other_tobacco1");
const other_tobacco2 = document.getElementById("other_tobacco2");
const other_tobacco3 = document.getElementById("other_tobacco3");

smoking_yes1.addEventListener("change", function () {
  if (this.checked) {
    smokeless0.style.display = "block";
    smokeless1.style.display = "block";
    smokeless2.style.display = "block";
    smokeless3.style.display = "block";
  } else {
    smokeless0.style.display = "none";
    smokeless1.style.display = "none";
    smokeless2.style.display = "none";
    smokeless3.style.display = "none";
  }
});

smoking_yes2.addEventListener("change", function () {
  if (this.checked) {
    smoking0.style.display = "block";
    smoking1.style.display = "block";
    smoking2.style.display = "block";
    smoking3.style.display = "block";
  } else {
    smoking0.style.display = "none";
    smoking1.style.display = "none";
    smoking2.style.display = "none";
    smoking3.style.display = "none";
  }
});

smoking_yes3.addEventListener("change", function () {
  if (this.checked) {
    ecigarette0.style.display = "block";
    ecigarette1.style.display = "block";
    ecigarette2.style.display = "block";
    ecigarette3.style.display = "block";
  } else {
    ecigarette0.style.display = "none";
    ecigarette1.style.display = "none";
    ecigarette2.style.display = "none";
    ecigarette3.style.display = "none";
  }
});

smoking_yes4.addEventListener("change", function () {
  if (this.checked) {
    other_tobacco0.style.display = "block";
    other_tobacco1.style.display = "block";
    other_tobacco2.style.display = "block";
    other_tobacco3.style.display = "block";
  } else {
    other_tobacco0.style.display = "none";
    other_tobacco1.style.display = "none";
    other_tobacco2.style.display = "none";
    other_tobacco3.style.display = "none";
  }
});

// Initial check

if (smoking_yes1.checked) {
  smokeless0.style.display = "block";
  smokeless1.style.display = "block";
  smokeless2.style.display = "block";
  smokeless3.style.display = "block";
} else {
  smokeless0.style.display = "none";
  smokeless1.style.display = "none";
  smokeless2.style.display = "none";
  smokeless3.style.display = "none";
}

if (smoking_yes2.checked) {
  smoking0.style.display = "block";
  smoking1.style.display = "block";
  smoking2.style.display = "block";
  smoking3.style.display = "block";
} else {
  smoking0.style.display = "none";
  smoking1.style.display = "none";
  smoking2.style.display = "none";
  smoking3.style.display = "none";
}

if (smoking_yes3.checked) {
  ecigarette0.style.display = "block";
  ecigarette1.style.display = "block";
  ecigarette2.style.display = "block";
  ecigarette3.style.display = "block";
} else {
  ecigarette0.style.display = "none";
  ecigarette1.style.display = "none";
  ecigarette2.style.display = "none";
  ecigarette3.style.display = "none";
}

if (smoking_yes4.checked) {
  other_tobacco0.style.display = "block";
  other_tobacco1.style.display = "block";
  other_tobacco2.style.display = "block";
  other_tobacco3.style.display = "block";
} else {
  other_tobacco0.style.display = "none";
  other_tobacco1.style.display = "none";
  other_tobacco2.style.display = "none";
  other_tobacco3.style.display = "none";
}
