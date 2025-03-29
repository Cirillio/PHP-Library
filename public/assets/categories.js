const urlParams = new URLSearchParams(window.location.search);
const category = urlParams.get("category");
const categoryBtns = document.querySelectorAll(".category-btn");
categoryBtns.forEach((btn) => {
  btn.classList.add("btn-ghost");
  btn.removeAttribute("disabled");
  if (btn.dataset.genre == category) {
    btn.classList.remove("btn-ghost");
    btn.setAttribute("disabled", true);
  }
});
