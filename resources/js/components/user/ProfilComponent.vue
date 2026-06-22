<template>
  <div style="width:100%;">

    <!-- Hero dynamique -->
    <section :style="`position:relative; background-image:url('${bgImage}'); background-size:cover; background-position:center; padding:80px 20px; text-align:center;`">
      <div style="position:absolute; inset:0; background:rgba(0,0,0,0.55);"></div>
      <div style="position:relative; z-index:1;">
        <div style="width:80px; height:80px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:36px; backdrop-filter:blur(4px); border:2px solid rgba(255,255,255,0.3);">
          👤
        </div>
        <h1 style="color:white; font-size:36px; font-weight:800; margin:0 0 8px;">
          {{ displayUser.first_name }} {{ displayUser.name }}
        </h1>
        <p style="color:rgba(255,255,255,0.7); font-size:14px; margin:0;">
          {{ displayUser.email }}
        </p>
      </div>
    </section>

    <!-- Contenu -->
    <div style="padding:60px 0;">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div style="background:white; border-radius:16px; padding:32px; box-shadow:0 4px 15px rgba(0,0,0,0.06);">

              <template v-if="!activeForm">

                <!-- Infos affichées -->
                <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:28px;">

                  <div style="display:flex; align-items:center; gap:14px; padding:14px; background:#f8f9fa; border-radius:10px;">
                    <div style="width:40px; height:40px; background:#f0f0ff; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">👤</div>
                    <div>
                      <p style="font-size:11px; color:#aaa; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin:0 0 2px;">Nom</p>
                      <p style="font-size:15px; font-weight:600; color:#333; margin:0;">{{ displayUser.name }}</p>
                    </div>
                  </div>

                  <div style="display:flex; align-items:center; gap:14px; padding:14px; background:#f8f9fa; border-radius:10px;">
                    <div style="width:40px; height:40px; background:#f0fff4; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">✏️</div>
                    <div>
                      <p style="font-size:11px; color:#aaa; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin:0 0 2px;">Prénom</p>
                      <p style="font-size:15px; font-weight:600; color:#333; margin:0;">{{ displayUser.first_name }}</p>
                    </div>
                  </div>

                  <div style="display:flex; align-items:center; gap:14px; padding:14px; background:#f8f9fa; border-radius:10px;">
                    <div style="width:40px; height:40px; background:#fff8f0; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">✉️</div>
                    <div>
                      <p style="font-size:11px; color:#aaa; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin:0 0 2px;">Email</p>
                      <p style="font-size:15px; font-weight:600; color:#333; margin:0; word-break:break-all;">{{ displayUser.email }}</p>
                    </div>
                  </div>

                </div>

                <!-- Boutons -->
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                  <button @click="openForm('profile')"
                    style="flex:1; min-width:160px; padding:12px 20px; background:#1a1a2e; color:white; border:none; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;"
                    onmouseover="this.style.background='#333'"
                    onmouseout="this.style.background='#1a1a2e'">
                    ✏️ Modifier le profil
                  </button>
                  <button @click="openForm('password')"
                    style="flex:1; min-width:160px; padding:12px 20px; background:white; color:#333; border:2px solid #eee; border-radius:10px; font-size:14px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;"
                    onmouseover="this.style.borderColor='#333'"
                    onmouseout="this.style.borderColor='#eee'">
                    🔒 Modifier le mot de passe
                  </button>
                </div>

              </template>

              <!-- Formulaire -->
              <div v-else>
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                  <h3 style="font-size:24px; font-weight:800; color:#1a1a2e; margin:0; text-align:center; width:100%;">
                    {{ activeForm === 'profile' ? '✏️ Modifier le profil' : '🔒 Modifier le mot de passe' }}
                  </h3>
                  <button @click="activeForm = ''"
                    style="background:#f5f5f5; border:none; width:32px; height:32px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; color:#666; flex-shrink:0;"
                    onmouseover="this.style.background='#eee'"
                    onmouseout="this.style.background='#f5f5f5'">
                    ×
                  </button>
                </div>
                <profil-update-component :user-data="userData" :type_modify="activeForm" />
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import ProfilUpdateComponent from './ProfilUpdateComponent.vue';

export default {
  name: 'ProfilComponent',
  components: { ProfilUpdateComponent },

  props: {
    name: { type: String, required: true },
    first_name: { type: String, required: true },
    mail: { type: String, required: true },
    bgImage: { type: String, default: '' },
  },

  data() {
    return {
      activeForm: '',
    };
  },

  computed: {
    displayUser() {
      const userFromStore = this.$store.state.user;
      if (userFromStore && Object.keys(userFromStore).length) {
        return {
          name: userFromStore.name || this.name,
          first_name: userFromStore.first_name || this.first_name,
          email: userFromStore.email || this.mail,
        };
      }
      return {
        name: this.name,
        first_name: this.first_name,
        email: this.mail,
      };
    },
    userData() {
      return {
        name: this.displayUser.name,
        first_name: this.displayUser.first_name,
        email: this.displayUser.email,
      };
    },
  },

  methods: {
    openForm(type) {
      this.activeForm = this.activeForm === type ? '' : type;
    },
  },
};
</script>

<style>

.box{
    width: 80%;
    max-width: 900px;
    margin: auto;
    padding:25px;
    border: 1px solid black;
    border-radius: 10px;
}

.link{
    width: 40%;
    margin: auto;
    margin-top: 25px;
}

p{
    font-size: 18px;
}

.form-box {
    width: 80%;
    max-width: 900px;
    margin: 30px auto 0 auto;
    padding-top: 20px;
}

@media(max-width: 992px) {
    .box,
    .form-box {
        width: 95%;
        padding: 20px;
    }
}

</style>