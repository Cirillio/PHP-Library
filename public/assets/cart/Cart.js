import cart_request from "./cart_request.js";
import { Book } from "../book/Book.js";

export class Cart {
  constructor(page) {
    this.page = page;
    this.cart = [];
    this.cart_ids = [];
    this.total_element = document.querySelectorAll(".cart-total");
    this.quantity_element = document.querySelectorAll(".cart-quantity");
    this.cart_books_element = document.querySelector(".cart-books");
    this.send_order_element = document.querySelector(".order-send-btn") || null;
    this.cart_books = 0;
    this.total = 0;
    this.quantity = 0;
    // this.initListeners();
  }

  initListeners() {
    if (this.send_order_element)
      this.send_order_element.onclick = () => {
        const order_items = this.cart.map((book) => {
          return {
            book_id: book.id,
            quantity: book.quantity,
          };
        });
        console.log(order_items, Number(this.total.toFixed(2)), this.quantity);
      };
  }

  async SendRequest(action, data = null) {
    return axios(action, { method: data ? "post" : "get", data });
  }

  GetCartResult() {
    return {
      quantity: this.quantity,
      total: Number(this.total.toFixed(2)),
      books: this.cart.map((book) => {
        return {
          book_id: book.id,
          quantity: book.quantity,
        };
      }),
    };
  }

  InitCart() {
    const books = document.querySelectorAll(".book");
    this.cart = Array.from(books).map((book) => {
      const _book = new Book(book, this, this.page);
      _book.InCartState(
        this.cart_ids.some((book) => Number(book.book_id) === Number(_book.id))
      );
      return _book;
    });
  }

  GetCartAsync = async () =>
    await this.SendRequest(cart_request.get)
      .then(({ data: cart }) => {
        if (Array.isArray(cart)) this.cart_ids = cart;
      })
      .catch((error) => {
        console.error(error);
      });

  InitQuantity() {
    let _q = 0;
    let _t = 0;

    this.cart.forEach((book) => {
      if (
        this.cart_ids.some((item) => Number(item.book_id) === Number(book.id))
      ) {
        const q = sessionStorage.getItem(`book_${book.id}`) || 1;
        _q += Number(q);
        const t = Number(q) * book.price;
        _t += t;
      }
    });
    this.setTotals({ quantity: _q, total: _t });
  }

  async GetTotalAsync() {
    this.total_element
      ? await this.SendRequest(cart_request.total)
          .then(({ data: { total, quantity } }) => {
            this.setTotals({ total, items: quantity });
          })
          .catch((error) => {
            console.error(error);
          })
      : null;
  }

  setTotals({ total = undefined, quantity = undefined, items = undefined }) {
    if (typeof total === "number" && total >= 0) {
      this.total = total;
      this.total_element.forEach(
        (el) => (el.textContent = Number(total).toFixed(2))
      );
    }

    if (typeof quantity === "number" && quantity >= 0) {
      this.quantity = quantity;
      this.quantity_element.forEach((el) => (el.textContent = quantity));
    }

    if (typeof items === "number" && items >= 0) {
      this.cart_books = items;
      if (items === 0) {
        this.cart_books_element.hidden = true;
      } else {
        this.cart_books_element.hidden = false;
        this.cart_books_element.textContent = items;
      }
    }
  }

  ReCalcTotal(action, price, quantity = 1, books = this.cart_books) {
    const totals = action
      ? {
          total: this.total + Number(price * quantity),
          quantity: this.quantity + Number(quantity),
        }
      : {
          total:
            this.total - Number(price * quantity) < 0
              ? 0
              : this.total - Number(price * quantity),
          quantity:
            this.quantity - Number(quantity) < 0
              ? 0
              : this.quantity - Number(quantity),
        };

    totals.items = books;
    this.setTotals(totals);
  }

  async AddAsync(book) {
    let response = false;
    await this.SendRequest(cart_request.add, { book_id: book.id })
      .then(() => {
        this.ReCalcTotal(true, book.price, book.quantity, this.cart_books + 1);
        response = true;
      })
      .catch((error) => {
        console.error(error);
      });
    return response;
  }

  async RemoveAsync(book) {
    let response = true;
    await this.SendRequest(cart_request.remove, { book_id: book.id })
      .then(() => {
        this.ReCalcTotal(false, book.price, book.quantity, this.cart_books - 1);
        response = false;
      })
      .catch((error) => {
        console.error(error);
      });
    return response;
  }
}
