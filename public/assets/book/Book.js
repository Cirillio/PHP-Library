export class Book {
  constructor(element, cart) {
    this.element = element;
    this.cart = cart;
    this.id = element.dataset.id;
    this.price = Number(element.dataset.price);
    this.cart_button = element.querySelector(".add-to-cart");
    this.in_cart = false;
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
    console.log(state);
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
    // Сохраняем в data-атрибуте
    // console.log(state);

    // Изменение внешнего вида кнопки
    if (state) {
      this.cart_button.classList.add("btn-secondary");
      this.cart_button.classList.remove("btn-primary");
      this.cart_button.textContent = "В корзине";
    } else {
      this.cart_button.classList.remove("btn-secondary");
      this.cart_button.classList.add("btn-primary");
      this.cart_button.textContent = "В корзину";
    }
  }

  UpdateState(books_in_cart) {
    // Проверяем наличие текущей книги в корзине
    const is_in_cart = books_in_cart.some((item) => item.book_id == this.id);
    this.InCartState(is_in_cart);
  }
}
