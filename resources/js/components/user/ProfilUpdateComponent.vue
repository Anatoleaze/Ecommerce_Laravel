<template>
  <div>

    <!-- Alerte -->
    <transition name="fade">
      <div v-if="message" :class="['update-alert', messageType]">
        <span>{{ messageType === 'alert-success' ? '✅' : messageType === 'alert-danger' ? '❌' : 'ℹ️' }}</span>
        {{ message }}
      </div>
    </transition>

    <form @submit.prevent="updateUser">

      <!-- Mode profil -->
      <template v-if="isProfileMode">

        <div class="field-group">
          <label class="field-label">👤 Nom</label>
          <input
            type="text"
            v-model="user.name"
            name="name"
            placeholder="Votre nom"
            class="field-input"
            onfocus="this.style.borderColor='#6c63ff'"
            onblur="this.style.borderColor='#eee'">
        </div>

        <div class="field-group">
          <label class="field-label">✏️ Prénom</label>
          <input
            type="text"
            v-model="user.first_name"
            name="first_name"
            placeholder="Votre prénom"
            class="field-input"
            onfocus="this.style.borderColor='#6c63ff'"
            onblur="this.style.borderColor='#eee'">
        </div>

        <div class="field-group">
          <label class="field-label">✉️ Email</label>
          <input
            type="email"
            v-model="user.email"
            name="email"
            placeholder="votre@email.com"
            class="field-input"
            onfocus="this.style.borderColor='#6c63ff'"
            onblur="this.style.borderColor='#eee'">
        </div>

      </template>

      <!-- Mode mot de passe -->
      <template v-else>

        <div class="field-group">
          <label class="field-label">🔒 Nouveau mot de passe</label>
          <div class="password-wrapper">
    <input
        :type="showPassword ? 'text' : 'password'"
        v-model="form.password"
        name="password"
        placeholder="Minimum 8 caractères"
        class="field-input"
        autocomplete="new-password"
        onfocus="this.style.borderColor='#6c63ff'"
        onblur="this.style.borderColor='#eee'">
    <button type="button" class="password-toggle" @click="showPassword = !showPassword">
        {{ showPassword ? '🙈' : '👁️' }}
    </button>
</div>
          <div v-if="form.password" class="password-strength">
            <div class="strength-bar">
              <div :class="['strength-fill', strengthClass]" :style="{ width: strengthWidth }"></div>
            </div>
            <span :class="['strength-label', strengthClass]">{{ strengthLabel }}</span>
          </div>
        </div>

        <div class="field-group">
          <label class="field-label">🔒 Confirmer le mot de passe</label>
          <input
            :type="showPassword ? 'text' : 'password'"
            v-model="form.confirmPass"
            name="confirmPass"
            placeholder="Répétez le mot de passe"
            class="field-input"
            autocomplete="new-password"
            onfocus="this.style.borderColor='#6c63ff'"
            onblur="this.style.borderColor='#eee'">
          <p v-if="form.confirmPass && form.password !== form.confirmPass"
            style="color:#e74c3c; font-size:12px; margin-top:6px;">
            ❌ Les mots de passe ne correspondent pas
          </p>
          <p v-if="form.confirmPass && form.password === form.confirmPass && form.password.length >= 8"
            style="color:#27ae60; font-size:12px; margin-top:6px;">
            ✅ Les mots de passe correspondent
          </p>
        </div>

      </template>

      <!-- Bouton submit -->
      <button type="submit" :disabled="loading" class="submit-btn">
        <span v-if="loading" class="btn-spinner"></span>
        {{ loading ? 'Enregistrement...' : (isProfileMode ? '💾 Enregistrer le profil' : '🔒 Enregistrer le mot de passe') }}
      </button>

    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    userData: { type: Object, required: true },
    type_modify: { type: String, required: true },
  },

  data() {
    return {
      user: {
        name: this.userData.name || '',
        first_name: this.userData.first_name || '',
        email: this.userData.email || '',
      },
      form: {
        password: '',
        confirmPass: '',
      },
      message: '',
      messageType: 'alert-info',
      loading: false,
      showPassword: false,
    };
  },

  computed: {
    isProfileMode() {
      return this.type_modify === 'profile';
    },

    passwordStrength() {
      const p = this.form.password;
      if (!p) return 0;
      let score = 0;
      if (p.length >= 8) score++;
      if (p.length >= 12) score++;
      if (/[A-Z]/.test(p)) score++;
      if (/[0-9]/.test(p)) score++;
      if (/[^A-Za-z0-9]/.test(p)) score++;
      return score;
    },

    strengthClass() {
      const s = this.passwordStrength;
      if (s <= 1) return 'weak';
      if (s <= 3) return 'medium';
      return 'strong';
    },

    strengthWidth() {
      return `${(this.passwordStrength / 5) * 100}%`;
    },

    strengthLabel() {
      const s = this.passwordStrength;
      if (s <= 1) return 'Faible';
      if (s <= 3) return 'Moyen';
      return 'Fort';
    },
  },

  watch: {
    userData: {
      deep: true,
      handler(newValue) {
        this.user.name = newValue.name || '';
        this.user.first_name = newValue.first_name || '';
        this.user.email = newValue.email || '';
      },
    },
    type_modify() {
      this.message = '';
      this.messageType = 'alert-info';
      if (!this.isProfileMode) {
        this.form.password = '';
        this.form.confirmPass = '';
      }
    },
  },

  methods: {
    async updateUser() {
      this.message = '';
      this.loading = true;

      const payload = {};

      if (this.isProfileMode) {
        payload.name = this.user.name;
        payload.first_name = this.user.first_name;
        payload.email = this.user.email;
      } else {
        if (!this.form.password || !this.form.confirmPass) {
          this.message = 'Veuillez remplir les deux champs.';
          this.messageType = 'alert-danger';
          this.loading = false;
          return;
        }
        if (this.form.password.length < 8) {
          this.message = 'Le mot de passe doit contenir au moins 8 caractères.';
          this.messageType = 'alert-danger';
          this.loading = false;
          return;
        }
        if (this.form.password !== this.form.confirmPass) {
          this.message = 'Les mots de passe ne correspondent pas.';
          this.messageType = 'alert-danger';
          this.loading = false;
          return;
        }
        payload.password = this.form.password;
        payload.password_confirmation = this.form.confirmPass;
      }

      try {
        const response = await axios.post('/profilUpdated', payload);
        const data = response.data;

        if (data.errors) {
          this.message = Object.values(data.errors).flat().join(' ');
          this.messageType = 'alert-danger';
          this.loading = false;
          return;
        }

        if (this.isProfileMode) {
          this.$store.commit('SET_USER', {
            ...this.$store.state.user,
            name: this.user.name,
            first_name: this.user.first_name,
            email: this.user.email,
          });
        }

        this.message = data.message || 'Mise à jour réussie !';
        this.messageType = 'alert-success';

        if (!this.isProfileMode) {
          this.form.password = '';
          this.form.confirmPass = '';
        }

      } catch (error) {
        const responseData = error.response?.data;
        if (responseData?.errors) {
          this.message = Object.values(responseData.errors).flat().join(' ');
        } else {
          this.message = responseData?.message || 'Une erreur est survenue.';
        }
        this.messageType = 'alert-danger';
      }

      this.loading = false;
    },
  },
};
</script>

<style scoped>
/* Alerte */
.update-alert {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 20px;
}

.alert-success {
  background: #eafaf1;
  color: #27ae60;
  border: 1px solid #a9dfbf;
}

.alert-danger {
  background: #fef0f0;
  color: #e74c3c;
  border: 1px solid #f5c6c6;
}

.alert-info {
  background: #f0f7ff;
  color: #2980b9;
  border: 1px solid #aed6f1;
}

/* Champs */
.field-group {
  margin-bottom: 20px;
}

.field-label {
  display: block;
  font-size: 13px;
  font-weight: 700;
  color: #444;
  margin-bottom: 8px;
}

.field-input {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #eee;
  border-radius: 10px;
  font-size: 14px;
  color: #333;
  outline: none;
  transition: border-color 0.2s;
  background: white;
  font-family: inherit;
}

/* Mot de passe */
.password-wrapper {
  position: relative;
}

.password-wrapper .field-input {
  padding-right: 48px;
}

.password-toggle {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  cursor: pointer;
  font-size: 16px;
  padding: 0;
}

/* Force mot de passe */
.password-strength {
  margin-top: 8px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.strength-bar {
  flex: 1;
  height: 4px;
  background: #eee;
  border-radius: 2px;
  overflow: hidden;
}

.strength-fill {
  height: 100%;
  border-radius: 2px;
  transition: width 0.3s, background 0.3s;
}

.strength-fill.weak { background: #e74c3c; }
.strength-fill.medium { background: #f39c12; }
.strength-fill.strong { background: #27ae60; }

.strength-label {
  font-size: 12px;
  font-weight: 700;
  min-width: 40px;
}

.strength-label.weak { color: #e74c3c; }
.strength-label.medium { color: #f39c12; }
.strength-label.strong { color: #27ae60; }

/* Bouton */
.submit-btn {
  width: 100%;
  padding: 14px;
  background: #1a1a2e;
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 15px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-top: 8px;
}

.submit-btn:hover:not(:disabled) {
  background: #333;
}

.submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Spinner */
.btn-spinner {
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

/* Transition */
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>