<template>
  <div v-show="isOpen" class="payment-overlay" @click.self="closeModal">
    <div class="payment-modal" @click.stop>

      <!-- Header -->
      <div class="payment-header">
        <div class="payment-header-left">
          <div class="payment-icon">🔒</div>
          <div>
            <h2 class="payment-title">Paiement sécurisé</h2>
            <p class="payment-subtitle">Vos données sont protégées</p>
          </div>
        </div>
        <button @click.stop="closeModal" class="payment-close-btn">&times;</button>
      </div>

      <!-- Total -->
      <div class="payment-total-bar">
        <span>Total à payer</span>
        <span class="payment-total-amount">{{ total }} €</span>
      </div>

      <!-- Alerte -->
      <div v-if="alertMessage" :class="['payment-alert', alertClass]">
        {{ alertMessage }}
      </div>

      <!-- Cartes de test -->
      <details class="test-cards">
        <summary>🧪 Cartes de test Stripe</summary>
        <div class="test-cards-grid">
          <div class="test-card success">
            <span class="test-card-label">✅ Paiement réussi</span>
            <code>4242 4242 4242 4242</code>
          </div>
          <div class="test-card error">
            <span class="test-card-label">❌ Carte refusée</span>
            <code>4000 0000 0000 0002</code>
          </div>
          <div class="test-card warning">
            <span class="test-card-label">⏰ Carte expirée</span>
            <code>4000 0000 0000 0069</code>
          </div>
        </div>
        <p class="test-cards-info">Date : 11/36 · CVC : 123</p>
      </details>

      <!-- Formulaire -->
      <form @submit.prevent="handlePayment" class="payment-form">

        <!-- Infos client -->
        <div class="payment-customer-info">
          <div class="customer-info-item">
            <i class="zmdi zmdi-account"></i>
            <span>{{ userName }}</span>
          </div>
          <div class="customer-info-item">
            <i class="zmdi zmdi-email"></i>
            <span>{{ userEmail }}</span>
          </div>
          <div class="customer-info-item">
            <i class="zmdi zmdi-pin"></i>
            <span>{{ userAdressLine }}, {{ userCodePostal }} {{ userVille }}, {{ userPays }}</span>
          </div>
        </div>

        <!-- Champs Stripe -->
        <div class="stripe-fields">

          <div class="stripe-field-group">
            <label class="stripe-label">
              <i class="zmdi zmdi-card"></i> Numéro de carte
            </label>
            <div id="card-number" class="stripe-element"></div>
          </div>

          <div class="stripe-field-row">
            <div class="stripe-field-group">
              <label class="stripe-label">
                <i class="zmdi zmdi-calendar"></i> Date d'expiration
              </label>
              <div id="card-expiry" class="stripe-element"></div>
            </div>

            <div class="stripe-field-group">
              <label class="stripe-label">
                <i class="zmdi zmdi-lock"></i> Code CVC
              </label>
              <div id="card-cvc" class="stripe-element"></div>
            </div>
          </div>

        </div>

        <!-- Bouton payer -->
        <button type="submit" :disabled="loading" class="payment-submit-btn">
          <span v-if="loading" class="loading-spinner"></span>
          {{ loading ? 'Traitement en cours...' : '🔒 Payer ' + total + ' €' }}
        </button>

        <p class="payment-secure-note">
          🛡️ Paiement sécurisé par Stripe · Vos données ne sont jamais stockées
        </p>

      </form>

    </div>
  </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import axios from 'axios';

export default {
  props: {
    isOpen: { type: Boolean, required: true },
    total: { type: Number, required: true },
    userName: { type: String, required: true },
    userEmail: { type: String, required: true },
    userAdressLine: { type: String, required: true },
    userCodePostal: {
      type: [String, Number],
      required: true
    },
    userPays: { type: String, required: true },
    userVille: { type: String, required: true },
  },

  data() {
    return {
      stripe: null,
      elements: null,
      cardNumber: null,
      cardExpiry: null,
      cardCvc: null,
      loading: false,
      alertMessage: '',
      alertClass: '',
      stripeInitialized: false,
    };
  },

  methods: {
    async setupStripeElements() {

      await this.$nextTick();

      if (this.stripeInitialized) {
        return;
      }


      try {
        this.stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY);
        this.elements = this.stripe.elements();

        const style = {
          base: {
            fontSize: '15px',
            color: '#333',
            fontFamily: 'system-ui, sans-serif',
            '::placeholder': { color: '#aaa' },
          },
          invalid: { color: '#e74c3c' },
        };

        this.cardNumber = this.elements.create('cardNumber', { style });
        this.cardExpiry = this.elements.create('cardExpiry', { style });
        this.cardCvc = this.elements.create('cardCvc', { style });

        this.cardNumber.mount('#card-number');
        this.cardExpiry.mount('#card-expiry');
        this.cardCvc.mount('#card-cvc');

      } catch (error) {
        this.alertMessage = "Erreur lors de l'initialisation de Stripe.";
        this.alertClass = 'alert-error';
      }
    },

    async handlePayment(event) {
      event.preventDefault();
      event.stopPropagation();

      this.loading = true;
      this.alertMessage = '';

      if (!this.stripe || !this.cardNumber) {
        this.alertMessage = "Les éléments de paiement ne sont pas correctement initialisés.";
        this.alertClass = 'alert-error';
        this.loading = false;
        return;
      }

      try {
        const { paymentMethod, error } = await this.stripe.createPaymentMethod({
          type: 'card',
          card: this.cardNumber,
          billing_details: {
            name: this.userName,
            email: this.userEmail,
            address: {
              line1: this.userAdressLine,
              city: this.userVille,
              postal_code: this.userCodePostal,
              country: this.userPays.slice(0, 2).toLowerCase(),
            },
          },
        });

        if (error) {
          this.alertMessage = "Oups... Une erreur est survenue.";
          this.alertClass = 'alert-error';
          this.loading = false;
          return;
        }


        const response = await axios.post("/create-payment-intent", {
          payment_method_id: paymentMethod.id,
          amount: this.total,
          address: `${this.userAdressLine} ${this.userCodePostal} ${this.userVille} ${this.userPays}`,
        });

        if (!response.data.client_secret) {
          const errors = {
            'Your card was declined.': 'Votre carte a été refusée.',
            'Your card has expired.': 'Votre carte a expiré.',
          };
          this.alertMessage = errors[response.data.error] || 'Oups... Une erreur est survenue.';
          this.alertClass = 'alert-error';
          this.loading = false;
          return;
        }

        if (response.data.success) {
          // Le paiement est fait ET le serveur a déjà créé la commande en BDD !
          this.alertMessage = "✅ Paiement validé avec succès !";
          this.alertClass = 'alert-success';

          // On lance directement le compte à rebours pour la redirection
          let countdown = 5;
          this.alertMessage = `✅ Paiement validé et commande enregistrée ! Redirection dans ${countdown}s...`;

          const timer = setInterval(() => {
            countdown--;
            if (countdown > 0) {
              this.alertMessage = `✅ Paiement validé et commande enregistrée ! Redirection dans ${countdown}s...`;
            } else {
              clearInterval(timer);

              // Actions de fin de processus
              this.$emit('payment-success');
              this.closeModal();

              // Redirection vers l'historique des commandes
              window.location.href = '/order';
            }
          }, 1000);

        } else {
          this.alertMessage = "Oups... Une erreur est survenue.";
          this.alertClass = 'alert-error';
        }

      } catch (err) {
        this.alertMessage =
          err.response?.data?.error ||
          "Une erreur est survenue lors du paiement.";

        this.alertClass = 'alert-error';
      }

      this.loading = false;
    },

    closeModal(event) {

      if (event) {
        event.preventDefault();
      }

      this.cardNumber?.destroy();
      this.cardExpiry?.destroy();
      this.cardCvc?.destroy();

      this.cardNumber = null;
      this.cardExpiry = null;
      this.cardCvc = null;

      this.$emit('update:isOpen', false);
    },
  },

  watch: {
    async isOpen(newValue) {

      if (newValue) {
        await this.setupStripeElements();
      }

    },
  },
};
</script>

<style scoped>
/* ===== OVERLAY ===== */
.payment-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.65);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 3000;
  padding: 20px;
  backdrop-filter: blur(4px);
}

/* ===== MODALE ===== */
.payment-modal {
  background: white;
  border-radius: 20px;
  width: 100%;
  max-width: 520px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

/* ===== HEADER ===== */
.payment-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 24px 28px;
  border-bottom: 1px solid #f0f0f0;
}

.payment-header-left {
  display: flex;
  align-items: center;
  gap: 14px;
}

.payment-icon {
  font-size: 28px;
  width: 50px;
  height: 50px;
  background: #f0f7ff;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.payment-title {
  font-size: 18px;
  font-weight: 800;
  color: #333;
  margin: 0;
}

.payment-subtitle {
  font-size: 12px;
  color: #aaa;
  margin: 2px 0 0;
}

.payment-close-btn {
  background: #f5f5f5;
  border: none;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #666;
  transition: background 0.2s;
}

.payment-close-btn:hover {
  background: #eee;
}

/* ===== TOTAL ===== */
.payment-total-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(135deg, #1a1a2e, #333);
  padding: 16px 28px;
  color: white;
  font-size: 14px;
}

.payment-total-amount {
  font-size: 22px;
  font-weight: 800;
  color: #f1c40f;
}

/* ===== ALERTES ===== */
.payment-alert {
  margin: 16px 28px 0;
  padding: 12px 16px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  text-align: center;
}

.alert-success {
  background: #eafaf1;
  color: #27ae60;
  border: 1px solid #a9dfbf;
}

.alert-error {
  background: #fef0f0;
  color: #e74c3c;
  border: 1px solid #f5c6c6;
}

/* ===== CARTES DE TEST ===== */
.test-cards {
  margin: 16px 28px 0;
  background: #fffbf0;
  border: 1px solid #fde68a;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 13px;
}

.test-cards summary {
  cursor: pointer;
  font-weight: 600;
  color: #b45309;
}

.test-cards-grid {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 10px;
}

.test-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 8px 12px;
  border-radius: 8px;
  font-size: 12px;
}

.test-card.success {
  background: #eafaf1;
}

.test-card.error {
  background: #fef0f0;
}

.test-card.warning {
  background: #fff8e1;
}

.test-card-label {
  font-weight: 600;
  color: #555;
}

.test-card code {
  font-family: monospace;
  font-weight: 700;
  color: #333;
  background: rgba(0, 0, 0, 0.06);
  padding: 2px 8px;
  border-radius: 4px;
}

.test-cards-info {
  color: #aaa;
  font-size: 12px;
  margin: 8px 0 0;
}

/* ===== FORMULAIRE ===== */
.payment-form {
  padding: 20px 28px 28px;
}

/* Infos client */
.payment-customer-info {
  background: #f8f9fa;
  border-radius: 10px;
  padding: 14px 16px;
  margin-bottom: 20px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.customer-info-item {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 13px;
  color: #555;
}

.customer-info-item i {
  color: #aaa;
  font-size: 14px;
  width: 16px;
}

/* Stripe fields */
.stripe-fields {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 24px;
}

.stripe-field-row {
  display: flex;
  gap: 16px;
}

.stripe-field-row .stripe-field-group {
  flex: 1;
}

.stripe-field-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.stripe-label {
  font-size: 13px;
  font-weight: 600;
  color: #444;
  display: flex;
  align-items: center;
  gap: 6px;
}

.stripe-label i {
  color: #aaa;
  font-size: 14px;
}

.stripe-element {
  border: 2px solid #eee;
  border-radius: 10px;
  padding: 12px 14px;
  transition: border-color 0.2s;
  background: white;
}

.stripe-element:focus-within {
  border-color: #6c63ff;
}

/* Bouton payer */
.payment-submit-btn {
  width: 100%;
  padding: 16px;
  background: linear-gradient(135deg, #1a1a2e, #333);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-bottom: 14px;
}

.payment-submit-btn:hover:not(:disabled) {
  background: linear-gradient(135deg, #333, #555);
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.payment-submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Spinner */
.loading-spinner {
  width: 18px;
  height: 18px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.payment-secure-note {
  text-align: center;
  font-size: 12px;
  color: #aaa;
  margin: 0;
}
</style>