import { Book } from "../book/Book.js";
import { Cart } from "./Cart.js";

export class CartController {
  constructor(cart) {
    this.cart = cart;
    this.books = [];
    this.init();
  }

  init() {
    Promise.all([this.InitTotalAsync(), this.InitBooksAsync()]).then(() => {
      this.InitCart();
    });
  }

  async InitTotalAsync() {
    await this.cart.GetTotalAsync();
  }

  async InitBooksAsync() {
    await this.cart.GetCartAsync();
  }

  InitCart() {
    this.cart.InitCart();
    this.cart.InitQuantity();
  }
}
