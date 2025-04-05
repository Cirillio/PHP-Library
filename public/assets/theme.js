(function ThemeManager() {
  const html = document.documentElement;
  const savedTheme = localStorage.getItem("theme") || "light";

  html.dataset.theme = savedTheme;

  document.addEventListener("DOMContentLoaded", () => {
    const toggler = document.querySelector("#theme-controller");
    toggler.checked = html.dataset.theme === "dark";

    toggler.onclick = () => {
      html.dataset.theme = html.dataset.theme === "dark" ? "light" : "dark";
      toggler.checked = html.dataset.theme === "dark";
      localStorage.setItem("theme", html.dataset.theme);
    };
  });
})();
