const hiv_infection1 = document.getElementById("hiv_infection1");
const hiv_infection2 = document.getElementById("hiv_infection2");

const art_treatment1 = document.getElementById("art_treatment1");
const art_treatment2 = document.getElementById("art_treatment2");

const participant_age1 = document.getElementById("participant_age1");
const participant_age2 = document.getElementById("participant_age2");

const understand_icf1 = document.getElementById("understand_icf1");
const understand_icf2 = document.getElementById("understand_icf2");

const another_study1 = document.getElementById("another_study1");
const another_study2 = document.getElementById("another_study2");

const newly_diagnosed1 = document.getElementById("newly_diagnosed1");
const newly_diagnosed2 = document.getElementById("newly_diagnosed2");

const medical_condtn1 = document.getElementById("medical_condtn1");
const medical_condtn2 = document.getElementById("medical_condtn2");

const participant_id = document.getElementById("participant_id");
const screen_failure = document.getElementById("screen_failure");

function toggleElementVisibility() {
  if (
    hiv_infection1.checked &&
    art_treatment1.checked &&
    participant_age1.checked &&
    understand_icf1.checked &&
    another_study2.checked &&
    newly_diagnosed2.checked &&
    medical_condtn2.checked
  ) {
    participant_id.style.display = "block";
    screen_failure.style.display = "none";
  } else {
    participant_id.style.display = "none";
    screen_failure.style.display = "block";
  }
}

hiv_infection1.addEventListener("change", toggleElementVisibility);
hiv_infection2.addEventListener("change", toggleElementVisibility);

art_treatment1.addEventListener("change", toggleElementVisibility);
art_treatment2.addEventListener("change", toggleElementVisibility);

participant_age1.addEventListener("change", toggleElementVisibility);
participant_age2.addEventListener("change", toggleElementVisibility);

understand_icf1.addEventListener("change", toggleElementVisibility);
understand_icf2.addEventListener("change", toggleElementVisibility);

another_study1.addEventListener("change", toggleElementVisibility);
another_study2.addEventListener("change", toggleElementVisibility);

newly_diagnosed1.addEventListener("change", toggleElementVisibility);
newly_diagnosed2.addEventListener("change", toggleElementVisibility);

medical_condtn1.addEventListener("change", toggleElementVisibility);
medical_condtn2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
