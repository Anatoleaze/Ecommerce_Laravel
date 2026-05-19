import { createStore } from 'vuex';

export default createStore({
  state() {
    return {
      cart: [],
      cartCount: 0,
    };
  },

  getters: {
    cartItemCount(state) {
      return state.cartCount;
    },
  },

  mutations: {
    setCartCount(state, count) {
      state.cartCount = count;
    },
    setCart(state, cart) {
      state.cart = cart;
    },
  },

  actions: {
    fetchCartCount({ commit }) {
      // Fetch cart count from API
      return fetch('/api/cart/count')
        .then(response => response.json())
        .then(data => {
          commit('setCartCount', data.count || 0);
        })
        .catch(() => {
          commit('setCartCount', 0);
        });
    },

    fetchCart({ commit }) {
      // Fetch cart from API
      return fetch('/api/cart')
        .then(response => response.json())
        .then(data => {
          commit('setCart', data.items || []);
          commit('setCartCount', data.items?.length || 0);
        })
        .catch(() => {
          commit('setCart', []);
        });
    },
  },
});
