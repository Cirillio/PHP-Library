export class Book {
  constructor(element, cart, page) {
    this.page = page;
    this.element = element;
    this.cart = cart;
    this.id = element.dataset.id;
    this.price = Number(element.dataset.price);
    this.book_content = element.querySelector(".book-content") || element;
    this.cart_button = element.querySelector(".add-to-cart");
    this.cart_button_text_add = page === "cart" ? "Вернуть" : "В корзину";
    this.cart_button_text_remove = page === "cart" ? "Убрать" : "В корзине";
    this.in_cart = false;
    this.stock = Number(element.dataset.stock);
    this.init();
  }

  init() {
    this.cart_button.onclick = () => this.HandleCartAsync();
  }

  async HandleCartAsync() {
    this.in_cart ? await this.RemoveFromCart() : await this.AddToCart();
  }

  async AddToCart() {
    const state = await this.cart.AddAsync({
      id: this.id,
      price: this.price,
    });
    this.InCartState(state);
  }

  async RemoveFromCart() {
    const state = await this.cart.RemoveAsync({
      id: this.id,
      price: this.price,
    });
    this.InCartState(state);
  }

  InCartState(state) {
    this.in_cart = state;
    this.element.dataset.inCart = state;

    // Изменение внешнего вида кнопки
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
      }
    } else {
      this.cart_button.classList.remove("btn-secondary");
      this.cart_button.classList.add("btn-primary");
      this.cart_button.textContent = this.cart_button_text_add;
      this.cart_button.disabled = this.stock == 0 ? true : false;
      if (this.page === "cart") {
        this.book_content.classList.remove("opacity-100");
        this.book_content.classList.add("opacity-50");
      }
    }
  }

  UpdateState(books_in_cart) {
    // Проверяем наличие текущей книги в корзине
    const is_in_cart = books_in_cart.some((item) => item.book_id == this.id);
    this.InCartState(is_in_cart);
  }
}
