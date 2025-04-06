export function SetHeaderLinks() {
  const headerLinks = document.querySelectorAll(".header-link");
  const url = new URL(window.location.href);
  const currentPage = url.pathname.split("/").pop();

  // console.log("Поисковые параметры: " + url.searchParams);

  headerLinks.forEach((link) => {
    link.classList.remove("underline");
    link.classList.remove("text-primary");
    if (link.dataset.link === currentPage) {
      link.classList.add("underline");
      link.classList.add("text-primary");
    }
  });
}
