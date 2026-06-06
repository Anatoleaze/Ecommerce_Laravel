<template>
    <div class="box">
        <template v-if="!activeForm">
            <div class="row">
                <p class="m-auto"> <span class="font-weight-bold">Nom :</span> {{ displayUser.name }}</p>
            </div>

            <div class="row">
                <p class="m-auto"> <span class="font-weight-bold">Prénom :</span> {{ displayUser.first_name }}</p>
            </div>

            <div class="row m-b-25">
                <p class="m-auto"> <span class="font-weight-bold">Email :</span> {{ displayUser.email }}</p>
            </div>

            <div class="row justify-content-center mb-4">
                <button type="button" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04 me-3" @click="openForm('profile')">
                    Modifier le profil
                </button>
                <button type="button" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04" @click="openForm('password')">
                    Modifier le mot de passe
                </button>
            </div>
        </template>

        <div v-else class="form-box">
            <profil-update-component :user-data="userData" :type_modify="activeForm" />
        </div>
    </div>
</template>

<script>
import ProfilUpdateComponent from './ProfilUpdateComponent.vue';

export default {
    name: 'ProfilComponent',
    components: {
        ProfilUpdateComponent,
    },
    props: {
        name: {
            type: String,
            required: true,
        },
        first_name: {
            type: String,
            required: true,
        },
        mail: {
            type: String,
            required: true,
        },
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
    mounted() {
        console.log('Profil Component mounted');
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