export class FilterFormManager {
  constructor(form, page, drawer) {
    this.form = document.querySelector(form);
    this.page = document.querySelector(page);
    this.drawer = document.querySelector(drawer);
    // this.toggler = document.querySelector(toggler);
    this.isMobile = window.innerWidth <= 1024;
    this.init();
  }
  init() {
    this.windowResizeListener();
    this.adjustLayout();
  }

  windowResizeListener() {
    window.addEventListener("resize", () => this.handleResize());
  }
  handleResize() {
    const wasMobile = this.isMobile;
    this.isMobile = window.innerWidth <= 1024;

    if (wasMobile !== this.isMobile) {
      this.adjustLayout();
    }
  }

  adjustLayout() {
    if (this.isMobile) {
      this.drawer.appendChild(this.form);
    } else {
      this.page.appendChild(this.form);
    }
  }
}
