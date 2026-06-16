import { createStore } from "vuex";
import axios from "axios";

export default createStore({
  state: {
    cart: [],
    cartCount: 0,
    isCartOpen: false,
    user: null,
  },
  mutations: {
    SET_CART(state, cart) {
      state.cart = cart;
      state.cartCount = cart.reduce(
        (total, item) => total + (item.quantity || 0),
        0,
      );
    },
    SET_USER(state, user) {
      state.user = user;
    },

    SET_CART_COUNT(state, count) {
      state.cartCount = count;
    },

    ADD_TO_CART(state, item) {
      let existingItem = state.cart.find((product) => product.id === item.id);
      if (existingItem) {
        existingItem.quantity += item.quantity;
      } else {
        //state.cart.push(item);
        state.cart.push({
          id: item.product_id,
          quantity: item.quantity,
          price: item.price,
        });
      }
      state.cartCount += item.quantity;
    },

    REMOVE_FROM_CART(state, itemId) {
      let item = state.cart.find((product) => product.id === itemId);
      if (item) {
        state.cartCount -= item.quantity;
      }
      state.cart = state.cart.filter((item) => item.id !== itemId);
    },

    TOGGLE_CART(state, value) {
      state.isCartOpen = value;
    },

    UPDATE_CART_ITEM(state, { product_id, quantity, price }) {
      const item = state.cart.find((p) => p.product_id === product_id);

      if (item) {
        if (quantity === 0) {
          state.cart = state.cart.filter((p) => p.product_id !== product_id);
        } else {
          item.quantity = quantity;
          item.totalPrice = (quantity * price).toFixed(2);
          state.cart = [...state.cart]; // 🔥 Force la réactivité
        }
      }
      state.cartTotal = state.cart.reduce((sum, item) => sum + item.qty, 0);
    },
  },
  actions: {
    async fetchCart({ commit }) {
      try {
        const response = await fetch("/cart");
        const data = await response.json();

        // Formate data
        const formattedCart = data.map((item) => ({
          product_id: item.product.id,
          name: item.product.name,
          price: parseFloat(item.product.price), // Convertir en float
          quantity: item.qty,
          img: item.product.image_name,
          totalPrice: (item.qty * parseFloat(item.product.price)).toFixed(2), // Total around
        }));

        commit("SET_CART", formattedCart);
      } catch (error) {
        console.error("❌ Error fetching cart:", error);
      }
    },

    async addToCart({ commit, dispatch }, data) {
      try {
        const response = await axios.post("/cart/store", data);

        if (response.status === 200) {
          commit("ADD_TO_CART", response.data);
          dispatch("fetchCartCount"); // 🔹 Update le macaron
          dispatch("fetchCart");
        }

        return response;
      } catch (error) {
        console.error("Erreur API:", error);
        return error.response || { status: 500, message: "Erreur interne" };
      }
    },

    async removeFromCart({ commit, dispatch }, itemId) {
      try {
        await axios.delete(`/cart/remove/${itemId}`);
        commit("REMOVE_FROM_CART", itemId);
        $;
        dispatch("fetchCart");
      } catch (error) {
        console.error("Erreur lors de la suppression :", error);
      }
    },

    async fetchCartCount({ commit }) {
      try {
        const response = await axios.get("/cart/count");
        commit("SET_CART_COUNT", response.data.count);
      } catch (error) {
        console.error("Erreur lors de la récupération du panier :", error);
      }
    },

    toggleCart({ commit }, value) {
      // Update State of modal cart
      commit("TOGGLE_CART", value);
    },

    async updateCartItem(
      { commit, dispatch },
      { product_id, quantity, price },
    ) {
      try {
        // 🔥 Envoie la mise à jour au backend
        const response = await fetch(`/cart/update`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
              .content, // 🔥 Ajoute le token CSRF si nécessaire
          },
          body: JSON.stringify({ product_id, quantity, price }),
        });

        const data = await response.json();

        if (response.ok) {
          commit("UPDATE_CART_ITEM", { product_id, quantity, price });
          dispatch("fetchCart");
        } else {
          console.error("❌ Failed to update cart:", data);
        }
      } catch (error) {
        console.error("❌ Error updating cart:", error);
      }
    },

    async fetchCart({ commit }) {
      try {
        const response = await fetch("/cart");
        const cart = await response.json();
        commit("SET_CART", cart);
      } catch (error) {
        console.error("❌ Error fetching cart:", error);
      }
    },
  },
  getters: {
    cartItemCount(state) {
      return state.cart.reduce((sum, item) => sum + item.qty, 0);
    },
    cartTotal: (state) =>
      state.cart.reduce((total, item) => total + item.price * item.quantity, 0),
    isCartOpen: (state) => state.isCartOpen, // Getter to state of modal cart
    cart: (state) => state.cart,
    totalCartPrice: (state) =>
      state.cart
        .reduce((total, item) => {
          const price =
            item.product.sale_price && parseFloat(item.product.sale_price) > 0
              ? parseFloat(item.product.sale_price)
              : parseFloat(item.product.price);

          return total + item.qty * price;
        }, 0)
        .toFixed(2),
  },
});
