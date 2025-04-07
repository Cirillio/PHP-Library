import cart_request from "./cart_request.js";

export class Cart {
  constructor() {
    this.total_element = document.querySelectorAll(".cart-total");
    this.quantity_element = document.querySelectorAll(".cart-quantity");
    this.total = 0;
    this.quantity = 0;
    this.cart = [];
  }

  async SendRequest(action, data = null) {
    return axios(action, { method: data ? "post" : "get", data });
  }

  async GetTotalAsync() {
    this.total_element
      ? await this.SendRequest(cart_request.total)
          .then(({ data: { total, quantity } }) => {
            this.setTotals({ total, quantity });
          })
          .catch((error) => {
            console.error(error);
          })
      : null;
  }

  setTotals({ total, quantity }) {
    this.total = Number(total);
    this.quantity = quantity;
    this.total_element.forEach(
      (el) => (el.textContent = Number(total).toFixed(2))
    );
    this.quantity_element.forEach((el) => (el.textContent = quantity));
  }

  ReCalcTotal(action, price) {
    const totals = action
      ? {
          total: this.total + Number(price),
          quantity: this.quantity + 1,
        }
      : {
          total:
            this.total - Number(price) < 0 ? 0 : this.total - Number(price),
          quantity: this.quantity - 1 < 0 ? 0 : this.quantity - 1,
        };

    this.setTotals(totals);
  }
  async GetCartAsync() {
    let response = null;
    await this.SendRequest(cart_request.get)
      .then(({ data: cart }) => {
        if (Array.isArray(cart)) {
          // console.log(cart);
          this.cart = cart;
          response = cart;
        }
      })
      .catch((error) => {
        console.error(error);
      });
    return response;
  }

  async AddAsync(book) {
    let response = false;
    await this.SendRequest(cart_request.add, { book_id: book.id })
      .then(() => {
        this.ReCalcTotal(true, book.price);
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
        this.ReCalcTotal(false, book.price);
        response = false;
      })
      .catch((error) => {
        console.error(error);
      });
    return response;
  }
}
