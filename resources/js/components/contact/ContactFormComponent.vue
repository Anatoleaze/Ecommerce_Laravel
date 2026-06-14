<template>
  <form @submit.prevent="sendEmail">

    <!-- Alertes -->
    <transition name="fade">
      <div v-if="successMessage"
        style="background:#eafaf1; border:1px solid #a9dfbf; border-radius:10px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">✅</span>
        <p style="color:#27ae60; font-weight:600; margin:0; font-size:14px;">{{ successMessage }}</p>
      </div>
    </transition>

    <transition name="fade">
      <div v-if="errorMessage"
        style="background:#fef0f0; border:1px solid #f5c6c6; border-radius:10px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">❌</span>
        <p style="color:#e74c3c; font-weight:600; margin:0; font-size:14px;">{{ errorMessage }}</p>
      </div>
    </transition>

    <!-- Email -->
    <div style="margin-bottom:16px;">
      <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
        ✉️ Votre email
      </label>
      <input
        type="email"
        name="email"
        v-model="form.email"
        placeholder="votre@email.com"
        required
        style="width:100%; padding:12px 16px; border:2px solid #eee; border-radius:10px; font-size:14px; color:#333; outline:none; transition:border-color 0.2s; background:white;"
        onfocus="this.style.borderColor='#6c63ff'"
        onblur="this.style.borderColor='#eee'">
    </div>

    <!-- Message -->
    <div style="margin-bottom:24px;">
      <label style="display:block; font-size:13px; font-weight:700; color:#444; margin-bottom:8px;">
        💬 Votre message
      </label>
      <textarea
        name="message"
        v-model="form.message"
        placeholder="Décrivez votre demande..."
        rows="5"
        required
        style="width:100%; padding:12px 16px; border:2px solid #eee; border-radius:10px; font-size:14px; color:#333; outline:none; transition:border-color 0.2s; resize:vertical; background:white; font-family:inherit;"
        onfocus="this.style.borderColor='#6c63ff'"
        onblur="this.style.borderColor='#eee'">
      </textarea>
    </div>

    <!-- Bouton -->
    <button
      type="submit"
      :disabled="loading"
      style="width:100%; padding:14px; background:#1a1a2e; color:white; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:10px; transition:background 0.2s;"
      onmouseover="if(!this.disabled) this.style.background='#333'"
      onmouseout="if(!this.disabled) this.style.background='#1a1a2e'">
      <span v-if="loading" class="send-spinner"></span>
      {{ loading ? 'Envoi en cours...' : '📨 Envoyer le message' }}
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
      errorMessage: '',
      loading: false,
    };
  },

  computed: {
    userEmail() {
      return window.Laravel?.userEmail || '';
    }
  },

  watch: {
    userEmail(newEmail) {
      this.form.email = newEmail;
    }
  },

  methods: {
    async sendEmail() {
      this.loading = true;
      this.successMessage = '';
      this.errorMessage = '';

      try {
        await axios.post('/sendMail', this.form);
        this.successMessage = 'Votre message a été envoyé avec succès !';
        this.resetForm();
      } catch (error) {
        this.errorMessage = 'Une erreur est survenue. Veuillez réessayer.';
      } finally {
        this.loading = false;
      }
    },

    resetForm() {
      this.form.email = this.userEmail;
      this.form.message = '';
    }
  },

  mounted() {
    this.form.email = this.userEmail;
  }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.send-spinner {
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  display: inline-block;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>