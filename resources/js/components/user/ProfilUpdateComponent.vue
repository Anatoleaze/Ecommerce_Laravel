<template>
    <div class="row contain">
        <form class="m-auto" @submit.prevent="updateUser">

            <div v-if="message === 'Informations mises à jour avec succès.'" class="alert alert-info message" style="text-align: center;margin-bottom: 25px;">
                <p>{{ message }}</p>
            </div>
            
            <div v-else-if="message" class="alert alert-danger message" style="text-align: center;margin-bottom: 25px;">
                <p>{{ message }}</p>
            </div>

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

            <div class="row" style="margin-bottom: 25px;">
                <div class="col-12">
                    <label for="password">Nouveau Mot de passe</label>
                </div>
                <div class="col-12">
                    <input class="form-control input1 bg-none plh1 stext-107 cl7" type="password" v-model="form.password" name="password" id="password" />
                </div>
            </div>

            <div class="row" style="margin-bottom: 25px;">
                <div class="col-12">
                    <label for="confirmPass">Confirmer votre nouveau mot de passe</label>
                </div>
                <div class="col-12">
                    <input class="form-control input1 bg-none plh1 stext-107 cl7" type="password" v-model="form.confirmPass" name="confirmPass" id="confirmPass" />
                </div>
            </div>

            <div class="row">
                <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04" type="submit">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    userData: {
      type: Object,
      required: true
    }
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
      message: ''
    };
  },
  methods: {
    async updateUser() {
      if (this.form.password && this.form.password !== this.form.confirmPass) {
        this.message = 'Les mots de passe ne correspondent pas.';
        return;
      }

      try {
        const response = await axios.post('/profilUpdated', {
          name: this.user.name,
          first_name: this.user.first_name,
          email: this.user.email,
          password: this.form.password,
          confirm: this.form.confirmPass
        });

        this.message = response.data.message;
      } catch (error) {
        this.message = 'Une erreur est survenue lors de la mise à jour.';
      }
    }
  }
};</script>

<style>
.contain {
    width: 60%;
    margin: auto;
    margin-bottom: 70px;
    margin-top: 70px;
}

button[type="submit"] {
    margin: auto;
    width: 60%;
}
</style>
