const lv_sys_func1 = document.getElementById("lv_sys_func1");
const lv_sys_func2 = document.getElementById("lv_sys_func2");

const ef_echo = document.getElementById("ef_echo");
const fs_echo = document.getElementById("fs_echo");
const rv_sys_func = document.getElementById("rv_sys_func");
const tapse_echo = document.getElementById("tapse_echo");


function toggleElementVisibility() {
  if (lv_sys_func1.checked) {
    ef_echo.style.display = "block";
    fs_echo.style.display = "block";
    rv_sys_func.style.display = "block";
    tapse_echo.style.display = "block";
  } else {
    ef_echo.style.display = "none";
    fs_echo.style.display = "none";
    rv_sys_func.style.display = "none";
    tapse_echo.style.display = "none";
  }
}

lv_sys_func1.addEventListener("change", toggleElementVisibility);
lv_sys_func2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
