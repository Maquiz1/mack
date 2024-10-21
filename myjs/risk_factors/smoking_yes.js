const smoking_yes1 = document.getElementById("smoking_yes1");
const smoking_yes2 = document.getElementById("smoking_yes2");
const smoking_yes3 = document.getElementById("smoking_yes3");
const smoking_yes4 = document.getElementById("smoking_yes4");


const smokeless0 = document.getElementById("smokeless0");
const smokeless1 = document.getElementById("smokeless1");
const smokeless2 = document.getElementById("smokeless2");

smoking_yes1.addEventListener("change", function () {
  if (this.checked) {
    smokeless0.style.display = "block";
    smokeless1.style.display = "block";
    smokeless2.style.display = "block";
  } else {
    smokeless0.style.display = "none";
    smokeless1.style.display = "none";
    smokeless2.style.display = "none";
  }
});


smoking_yes2.addEventListener("change", function () {
  if (this.checked) {
    smokeless0.style.display = "block";
    smokeless1.style.display = "block";
    smokeless2.style.display = "block";
  } else {
    smokeless0.style.display = "none";
    smokeless1.style.display = "none";
    smokeless2.style.display = "none";
  }
});


smoking_yes3.addEventListener("change", function () {
  if (this.checked) {
    smokeless0.style.display = "block";
    smokeless1.style.display = "block";
    smokeless2.style.display = "block";
  } else {
    smokeless0.style.display = "none";
    smokeless1.style.display = "none";
    smokeless2.style.display = "none";
  }
});


smoking_yes4.addEventListener("change", function () {
  if (this.checked) {
    smokeless0.style.display = "block";
    smokeless1.style.display = "block";
    smokeless2.style.display = "block";
  } else {
    smokeless0.style.display = "none";
    smokeless1.style.display = "none";
    smokeless2.style.display = "none";
  }
});

// Initial check

if (smoking_yes1.checked) {
  smokeless0.style.display = "block";
  smokeless1.style.display = "block";
  smokeless2.style.display = "block";
} else {
  smokeless0.style.display = "none";
  smokeless1.style.display = "none";
  smokeless2.style.display = "none";
}


if (smoking_yes2.checked) {
  smokeless0.style.display = "block";
  smokeless1.style.display = "block";
  smokeless2.style.display = "block";
} else {
  smokeless0.style.display = "none";
  smokeless1.style.display = "none";
  smokeless2.style.display = "none";
}


if (smoking_yes3.checked) {
  smokeless0.style.display = "block";
  smokeless1.style.display = "block";
  smokeless2.style.display = "block";
} else {
  smokeless0.style.display = "none";
  smokeless1.style.display = "none";
  smokeless2.style.display = "none";
}


if (smoking_yes4.checked) {
  smokeless0.style.display = "block";
  smokeless1.style.display = "block";
  smokeless2.style.display = "block";
} else {
  smokeless0.style.display = "none";
  smokeless1.style.display = "none";
  smokeless2.style.display = "none";
}
