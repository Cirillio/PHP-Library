const headerLinks = document.querySelectorAll(".header-link");
const url = new URL(window.location.href);
const currentPage = url.pathname.split("/").pop();

headerLinks.forEach((link) => {
  link.removeAttribute("disabled");
  link.classList.remove("text-primary");
  if (link.dataset.link === currentPage) {
    link.setAttribute("disabled", true);
    link.classList.add("text-primary");
  }
});
