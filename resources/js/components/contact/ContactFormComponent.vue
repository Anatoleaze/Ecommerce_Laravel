
<template>

    <form @submit.prevent="sendEmail">
        <h4 class="mtext-105 cl2 txt-center p-b-30">
            Envoyez-nous un message
        </h4>

        <div class="alert alert-success" style="width: 63%;margin: auto;margin-bottom: 20px;" v-if="successMessage">
            <p>{{ successMessage }}</p>
        </div>
        <div class="alert alert-danger" style="width: 63%;margin: auto;margin-bottom: 20px;" v-if="errorMessage">
            <p>{{ errorMessage }}</p>
        </div>
    

        <div class="bor8 m-b-20 how-pos4-parent">
            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="email" name="email" v-model="form.email" value="userEmail"  required>
            <img class="how-pos4 pointer-none" src="{{ asset('images/icons/icon-email.png')}}" alt="ICON">
        </div>

        <div class="bor8 m-b-30">
            <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" v-model="form.message" name="message" placeholder="Votre messeage"></textarea>
        </div>

        <button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer" type="submit">
            Envoyer
        </button>
    </form>

  </template>
  
  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        form: {
          email: '',
          message: '',
        },
        successMessage: '',
        errorMessage: ''
      };
    },
    computed: {
      userEmail() {
        console.log(window.Laravel.userEmail);
        return window.Laravel.userEmail || '';
      }
    },
    watch: {
    userEmail(newEmail) {
      this.form.email = newEmail;
    }
  },
    methods: {
      async sendEmail() {
        try {
          console.log("TRY SEND");
          console.log(this.form);
          const response = await axios.post('/sendMail', this.form);
          
          console.log(response);
          this.successMessage = 'Votre message a été envoyé avec succès!';
          this.errorMessage = '';
          this.resetForm();
        } catch (error) {
            console.log(error);
            this.errorMessage = 'Une erreur est survenue. Veuillez réessayer.';
            this.successMessage = '';
        }
      },
      resetForm() {
        this.form.email = '';
        this.form.message = '';
      }
    },
    mounted() {
    console.log('Mounted:', this.userEmail);  // Debug log
    this.form.email = this.userEmail;
  }
  };
  </script>
  