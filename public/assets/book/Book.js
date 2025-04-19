export class Book {
  constructor(element, cart, page) {
    this.page = page;
    this.element = element;
    this.cart = cart;
    this.id = Number(element.dataset.id.replace(/\s+/g, ""));
    this.price = Number(element.dataset.price.replace(/\s+/g, ""));
    this.book_content = element.querySelector(".book-content") || element;
    this.cart_button = element.querySelector(".add-to-cart");
    this.cart_button_text_add = page === "cart" ? "Вернуть" : "В корзину";
    this.cart_button_text_remove = page === "cart" ? "Убрать" : "В корзине";
    this.in_cart = false;
    this.stock = Number(element.dataset.stock);
    this.btn_dec = element.querySelector(".book-cart-dec") || null;
    this.btn_inc = element.querySelector(".book-cart-inc") || null;
    this.quantity =
      Number(sessionStorage.getItem(`book_${element.dataset.id}`)) || 1;
    this.q_input = element.querySelector(".book-cart-quantity") || null;
    this.init();
  }

  init() {
    this.cart_button.onclick = () => this.HandleCartAsync();
    if (this.q_input) {
      this.ChangeQuantity(this.quantity);
      this.btn_inc.onclick = () => this.IncQuantity();
      this.btn_dec.onclick = () => this.DecQuantity();
      this.PressInterval(this.btn_inc, () => this.IncQuantity(), 200);
      this.PressInterval(this.btn_dec, () => this.DecQuantity(), 200);
    }
  }

  PressInterval(elem, func, timeout) {
    let interval;

    const startInterval = () => {
      interval = setInterval(() => func(), timeout);
    };

    const stopInterval = () => {
      clearInterval(interval);
    };

    elem.onmousedown = startInterval;
    elem.onmouseup = stopInterval;
    elem.onmouseleave = stopInterval;
  }

  async HandleCartAsync() {
    this.in_cart ? await this.RemoveFromCart() : await this.AddToCart();
  }

  ChangeQuantity(_quantity) {
    this.q_input.value = _quantity;
    sessionStorage.setItem(`book_${this.id}`, _quantity);
  }
  IncQuantity() {
    let _q = this.quantity;
    _q += 1;
    this.cart.ReCalcTotal(true, this.price);
    if (_q >= this.stock) {
      console.log("Больше нет");
      this.btn_inc.disabled = true;
    } else {
      this.btn_dec.disabled = false;
    }
    this.quantity = _q;
    this.ChangeQuantity(_q);
  }

  DecQuantity() {
    let _q = this.quantity;
    _q -= 1;
    this.cart.ReCalcTotal(false, this.price);

    if (_q <= 1) {
      console.log("Хотя бы одну книгу");
      this.btn_dec.disabled = true;
    } else {
      this.btn_inc.disabled = false;
    }
    this.quantity = _q;
    this.ChangeQuantity(_q);
  }

  async AddToCart() {
    const state = await this.cart.AddAsync({
      id: this.id,
      price: this.price,
      quantity: this.quantity,
    });
    this.InCartState(state);
    sessionStorage.setItem(`book_${this.id}`, this.quantity);
  }

  async RemoveFromCart() {
    const state = await this.cart.RemoveAsync({
      id: this.id,
      price: this.price,
      quantity: this.quantity,
    });
    this.InCartState(state);
    sessionStorage.removeItem(`book_${this.id}`);
  }

  InCartState(state) {
    this.in_cart = state;
    this.element.dataset.inCart = state;

    // Изменение внешнего вида блока книги
    if (state) {
      this.cart_button.classList.add(
        this.stock == 0 ? "btn-error" : "btn-secondary"
      );
      this.cart_button.classList.remove("btn-primary");
      this.cart_button.textContent =
        this.stock == 0 ? "Убрать" : this.cart_button_text_remove;
      this.cart_button.disabled = false;
      if (this.page === "cart") {
        this.book_content.classList.remove("opacity-50");
        this.book_content.classList.add("opacity-100");
        this.btn_dec.disabled = this.quantity <= 1 ? true : false;
        this.btn_inc.disabled = this.quantity >= this.stock ? true : false;
        this.q_input.classList.remove("opacity-50");
      }
    } else {
      this.cart_button.classList.remove("btn-secondary");
      this.cart_button.classList.add("btn-primary");
      this.cart_button.textContent = this.cart_button_text_add;
      this.cart_button.disabled = this.stock == 0 ? true : false;
      if (this.page === "cart") {
        this.book_content.classList.remove("opacity-100");
        this.book_content.classList.add("opacity-50");
        this.btn_dec.disabled = true;
        this.btn_inc.disabled = true;
        this.q_input.classList.add("opacity-50");
      }
    }
  }
}
