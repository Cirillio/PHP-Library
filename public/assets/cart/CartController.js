import { Book } from "../book/Book.js";
import { Cart } from "./Cart.js";

export class CartController {
  constructor() {
    this.cart = new Cart();
    this.books = [];
  }

  async InitCartAsync() {
    await this.cart.GetTotalAsync();
  }

  async InitBooksAsync() {
    const book_elements = document.querySelectorAll(".book");
    const books_in_cart = await this.cart.GetCartAsync();
    // console.log(books_in_cart);
    if (!books_in_cart) {
      return;
    }

    this.books = Array.from(book_elements).map((book) => {
      const _book = new Book(book, this.cart);
      _book.UpdateState(books_in_cart);
      return _book;
    });
  }
}
