export function SetHeaderLinks() {
  const headerLinks = document.querySelectorAll(".header-link");
  const url = new URL(window.location.href);
  const currentPage = url.pathname.split("/").pop();

  // console.log("Поисковые параметры: " + url.searchParams);
  headerLinks.forEach((link) => {
    link.classList.remove("btn-active");
    link.classList.remove("border-primary");
    link.children[0].classList.remove("text-primary");
    if (link.dataset.link === currentPage) {
      link.classList.add("border-primary");
      link.classList.add("btn-active");
      link.children[0].classList.add("text-primary");
    }
  });
}
