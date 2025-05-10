<template>
     <div v-show="isOpen" class="modal wrap-modal1 p-t-60 p-b-20 show-modal1" @click.self="closeModal">
      <div class="container" @click.stop>
        <div class="bg0 p-t-20 p-b-30 p-r-20 p-l-20 col-6" style="margin:auto;" @click.stop>
          <button @click.stop="closeModal" class="close">&times;</button>
          <h2 class="text-center m-t-20">Paiement</h2>
      
        <div class="col col m-b-20 m-t-20 text-center">
          <div v-if="alertMessage" :class="alertClass">{{ alertMessage }}</div>
        </div>
        <div class="row m-b-15">
          <p style="width:80%;font-size:14px;margin:auto;">Paiement réussi = ( Carte :4242 4242 4242 4242, Date: 11/36, CVC: 123)</p>
          <p style="width:80%;font-size:14px;margin:auto;">Paiement refusé = ( Carte :4000 0000 0000 0002, Date: 11/36, CVC: 123)</p>
          <p style="width:80%;font-size:14px;margin:auto;">Carte expirée = ( Carte :4000 0000 0000 0069, Date: 11/36, CVC: 123)</p>
        </div>
        <div class="col m-b-30">
          <form @submit.prevent="handlePayment">
            <label class="cart_form_label">Numéro de carte</label>
            <div id="card-number" class="stripe-input"></div>

            <label class="cart_form_label">Date d’expiration</label>
            <div id="card-expiry" class="stripe-input"></div>

            <label class="cart_form_label">Code CVC (les 3 chiffres à l'arrière de votre carte bancaire)</label>
            <div id="card-cvc" class="stripe-input"></div>

            <button type="submit" style="margin-top:30px;" :disabled="loading"
              class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer m-t-30">
              {{ loading ? "Traitement..." : "Payer" }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import axios from 'axios';

export default {
  props: {
    isOpen: {
      type : Boolean,
      require : true,
    },

    total: {
      type : Number,
      require : true,
    },
    
    userName: {
      type : String,
      require : true,
    },

    userEmail: {
      type : String,
      require:true,
    },

    userAdressLine: {
      type :String,
      require : true,
    },

    userCodePostal: {
      type :String,
      require : true,
    },
    
    userPays: {
      type :String,
      require : true,
    },

    userVille: {
      type :String,
      require : true,
    },

    
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
      clientSecret: null,
      payment_method: null,
    };
  },

  methods: {
    
    // Initialise Stripe ELements 
    async setupStripeElements() {

      await this.$nextTick();

      try {
        
        this.stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY);
        this.elements = this.stripe.elements();

        this.cardNumber = this.elements.create('cardNumber');
        this.cardExpiry = this.elements.create('cardExpiry');
        this.cardCvc = this.elements.create('cardCvc');

        this.cardNumber.mount('#card-number');
        this.cardExpiry.mount('#card-expiry');
        this.cardCvc.mount('#card-cvc');

      } catch (error) {
        console.error("Erreur lors de l'initialisation des éléments Stripe", error);
        this.alertMessage += "Erreur lors de l'initialisation de Stripe.";
        this.alertClass = "alert alert-danger";
      }
    },

    // Manage Payment

    async handlePayment(event) {
      event.preventDefault(); // Stop default behavior
      event.stopPropagation(); // Stop propagation
  

      this.loading = true;
      this.alertMessage = '';

      if (!this.stripe || !this.cardNumber) {
        this.alertMessage = "Les éléments de paiement ne sont pas correctement initialisés.";
        this.alertClass = "alert alert-danger";
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
          this.alertMessage = "Oups... Une erreur est survenue";
          console.error("Erreur : " + error.message);
          this.alertClass = "alert alert-danger";
          this.loading = false;
          return;
        }

        const response = await axios.post("/create-payment-intent", {
          payment_method_id: paymentMethod.id,
          amount: this.total,
          address: this.userAdressLine + " " + this.userCodePostal + " " + this.userVille + " " + this.userPays,  
        });

        if (!response.data.client_secret) {
            let mes = ""
            if (response.data.error ==='Your card was declined.'){
                mes = "Votre carte a été refusée."
            }else if(response.data.error ==='Your card has expired.'){
              mes ='Votre carte a expiré.'; 
            }else{
              mes ='Oups... Une erreur est survenue.';
            }
            this.alertMessage = mes;
            this.alertClass = "alert alert-danger";
            this.loading = false;
            return;
        }

        if (response.data.success){
          this.alertMessage = "Paiement validé !";
          this.alertClass = "alert alert-success";

          setTimeout(() => {
            this.$emit('payment-success');
            this.closeModal();
          }, 2000);


        }else{
          console.error("Échec du paiement : " + confirmError.message);
          this.alertMessage = "Oups... Une erreur est survenue";
          this.alertClass = "alert alert-danger";
        }

      } catch (err) {
        console.error("Erreur de paiement:", err);
        this.alertMessage = err.response?.data?.message || err.message || "Erreur inconnue lors du paiement";
        this.alertClass = "alert alert-danger";
      }

      this.loading = false;
    },

    // Fermer la modale
    closeModal(event) {
      if (event) event.preventDefault();
      this.$emit("update:isOpen", false); // Update parent
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



<style>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5) !important;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
}

.alert-success {
  color: green;
}

.alert-error {
  color: red;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}

.cart_form_label {
  font-size: 18px;
  color: black;
}

.stripe-input {
  border: 1px solid #ccc;
  padding: 12px;
  height: 45px;
  font-size: 16px;
  border-radius: 5px;
  margin-bottom: 12px;
}

.card-number,
.card-expiry,
.card-cvc {
  width: 60%;
  margin: auto;
}
</style>
