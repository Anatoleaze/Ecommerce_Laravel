<template>
    <div class="row contain">
        <form class="m-auto" @submit.prevent="updateUser">

            <div v-if="message" :class="['alert', messageType, 'message']" style="text-align: center; margin-bottom: 25px;">
                <p>{{ message }}</p>
            </div>

            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h3>{{ isProfileMode ? 'Modifier le profil' : 'Modifier le mot de passe' }}</h3>
                </div>
            </div>

            <template v-if="isProfileMode">
                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-12">
                        <label for="name">Nom</label>
                    </div>
                    <div class="col-12">
                        <input class="form-control input1 bg-none plh1 stext-107 cl7" type="text" v-model="user.name" name="name" id="name" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-12">
                        <label for="first_name">Prénom</label>
                    </div>
                    <div class="col-12">
                        <input class="form-control input1 bg-none plh1 stext-107 cl7" type="text" v-model="user.first_name" name="first_name" id="first_name" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-12">
                        <label for="email">Email</label>
                    </div>
                    <div class="col-12">
                        <input class="form-control input1 bg-none plh1 stext-107 cl7" type="email" v-model="user.email" name="email" id="email" />
                    </div>
                </div>

                <div class="row">
                    <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04" type="submit">Enregistrer les modifications</button>
                </div>
            </template>

            <template v-else>
                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-12">
                        <label for="password">Nouveau mot de passe</label>
                    </div>
                    <div class="col-12">
                        <input class="form-control input1 bg-none plh1 stext-107 cl7" type="password" v-model="form.password" name="password" id="password" autocomplete="new-password" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-12">
                        <label for="confirmPass">Confirmer le nouveau mot de passe</label>
                    </div>
                    <div class="col-12">
                        <input class="form-control input1 bg-none plh1 stext-107 cl7" type="password" v-model="form.confirmPass" name="confirmPass" id="confirmPass" autocomplete="new-password" />
                    </div>
                </div>

                <div class="row">
                    <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04" type="submit">Enregistrer le mot de passe</button>
                </div>
            </template>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    userData: {
      type: Object,
      required: true,
    },
    type_modify: {
      type: String,
      required: true,
    },
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
    };
  },
  computed: {
    isProfileMode() {
      return this.type_modify === 'profile';
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
      this.clearMessages();
      if (!this.isProfileMode) {
        this.form.password = '';
        this.form.confirmPass = '';
      }
    },
  },
  methods: {
    clearMessages() {
      this.message = '';
      this.messageType = 'alert-info';
    },
    async updateUser() {
      this.clearMessages();

      const payload = {};
      if (this.isProfileMode) {
        payload.name = this.user.name;
        payload.first_name = this.user.first_name;
        payload.email = this.user.email;
      } else {
        if (!this.form.password || !this.form.confirmPass) {
          this.message = 'Veuillez remplir les deux champs de mot de passe.';
          this.messageType = 'alert-danger';
          return;
        }

        if (this.form.password.length < 8) {
          this.message = 'Le mot de passe doit contenir au moins 8 caractères.';
          this.messageType = 'alert-danger';
          return;
        }

        if (this.form.password !== this.form.confirmPass) {
          this.message = 'Les mots de passe ne correspondent pas.';
          this.messageType = 'alert-danger';
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
          return;
        }

        if (this.isProfileMode) {
          const updatedUser = {
            ...this.$store.state.user,
            name: this.user.name,
            first_name: this.user.first_name,
            email: this.user.email,
          };
          this.$store.commit('SET_USER', updatedUser);
        }

        this.message = data.message || 'Mise à jour réussie.';
        this.messageType = 'alert-info';

        if (!this.isProfileMode) {
          this.form.password = '';
          this.form.confirmPass = '';
        }
      } catch (error) {
        if (error.response && error.response.data) {
          const responseData = error.response.data;
          if (responseData.errors) {
            this.message = Object.values(responseData.errors).flat().join(' ');
          } else if (responseData.message) {
            this.message = responseData.message;
          } else {
            this.message = 'Une erreur est survenue lors de la mise à jour.';
          }
        } else {
          this.message = 'Une erreur est survenue lors de la mise à jour.';
        }
        this.messageType = 'alert-danger';
      }
    },
  },
};
</script>

<style>
.contain {
    width: 80%;
    max-width: 900px;
    margin: auto;
    margin-bottom: 70px;
    margin-top: 70px;
}

button[type="submit"] {
    margin: auto;
    width: 60%;
}

@media(max-width: 992px) {
    .contain {
        width: 95%;
    }
    button[type="submit"] {
        width: 80%;
    }
}
</style>
