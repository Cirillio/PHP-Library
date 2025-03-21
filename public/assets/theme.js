const loadTheme = () => {
  const toggler = document.querySelector("#theme-controller");
  let theme = localStorage.getItem("theme") || "light";
  setTheme(theme);
  theme === "light" ? (toggler.checked = false) : (toggler.checked = true);
};

function setTheme(theme) {
  document.querySelector("html").dataset.theme = theme;
}

function toggleTheme() {
  let theme = document.querySelector("html").dataset.theme;
  theme === "light" ? (theme = "dark") : (theme = "light");
  setTheme(theme);
  localStorage.setItem("theme", theme);
}

const setToggler = () => {
  const toggler = document.querySelector("#theme-controller");
  toggler.onclick = toggleTheme;
};

export { loadTheme, setToggler };
