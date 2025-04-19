import { Cart } from "../cart/Cart.js";

export class Order {
  constructor(form, cart) {
    this.form = document.querySelector(form);
    this.open_form = document.querySelector(".order-form-open");
    this.close_form = "order-form-close";
    this.cart = cart || null;
    this.total_books = 0;
    this.total_items = 0;
    this.delivery_cost = 500.0;
    this.total_sum = 0;
    this.delivery_method = null;
    this.shop = null;
    this.address = null;
    this.pay_method = null;
    this.check = null;
    this.init();
  }

  init() {
    this.open_form.addEventListener("click", () => this.OpenForm());
    this.form.addEventListener("click", (e) => this.CloseForm(e));
  }

  // this.cart.GetCartResult()

  SetCartTotal() {
    const _cart = this.cart.GetCartResult();
    _cart.count = _cart.books.length;
    console.log(_cart);
  }

  OpenForm() {
    this.SetCartTotal();
    this.form.classList.remove("hidden");
    requestAnimationFrame(() => {
      this.form.classList.remove("opacity-0");
    });
  }

  CloseForm(e) {
    if (e.target.classList.contains(this.close_form)) {
      this.form.classList.add("opacity-0");
      setTimeout(() => {
        this.form.classList.add("hidden");
      }, 150);
    }
  }
}
