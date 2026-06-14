<template>
    <div class="col-8 m-auto">

        <div v-if="message" :class="['alert', messageType]" style="text-align: center; margin-bottom: 25px;white-space: pre-line;">
            <p>{{ message }}</p>
        </div>

        <form @submit.prevent="submitForm" enctype="multipart/form-data">

            <input type="hidden" :value="csrfToken" name="_token">

            <!-- NAME -->
            <div class="form-group m-b-25">
                <label>Nom</label>
                <input v-model="form.name" type="text" class="form-control" required />
            </div>

            <!-- TYPE -->
            <div class="form-group m-b-25">
                <label>Catégorie</label>
                <select v-model="form.type" class="form-control" required>
                    <option value="femmes">Femmes</option>
                    <option value="hommes">Hommes</option>
                    <option value="montres">Montres</option>
                    <option value="sacs">Sacs</option>
                    <option value="chaussures">Chaussures</option>
                </select>
            </div>

            <!-- DESCRIPTION -->
            <div class="form-group m-b-25">
                <label>Description</label>
                <textarea v-model="form.description" class="form-control" rows="6 required"></textarea>
            </div>

            <!-- IMAGE -->
            <div class="form-group m-b-25">
                <label>Image</label>
                <input type="file" @change="handleImageChange" class="form-control-file" />
            </div>

            <!-- PRICE -->
            <div class="form-group m-b-25">
                <label>Prix</label>
                <input v-model="form.price" type="number" step="0.01" class="form-control" required />
            </div>

            <!-- SALE PRICE -->
            <div class="form-group m-b-25">
                <label>Prix soldé</label>
                <input v-model="form.sale_price" type="number" step="0.01" class="form-control" />
            </div>

            <!-- SUBMIT -->
            <div class="form-group col-6 m-auto m-b-25">
                <input type="submit"
                       class="flex-c-m stext-101 cl0 size-103 bg1 bor1 p-lr-15 trans-04"
                       style="cursor:pointer;"
                       value="Valider" />
            </div>

        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "CreateProductComponent",

    props: {
        link: { type: String, required: true },
        product: { type: Object, required: false },
        csrfToken: { type: String, required: true }
    },

    data() {
        return {
            form: {
                name: "",
                description: "",
                price: "",
                sale_price: "",
                type: ""
            },
            image: null,
            message: "",
            messageType: "alert-info"
        };
    },

    mounted() {
        // Si mode EDITION → on hydrate le form
        if (this.product) {
            this.form = {
                name: this.product.name || "",
                description: this.product.description || "",
                price: this.product.price || "",
                sale_price: this.product.sale_price || "",
                type: this.product.type || ""
            };
        }
    },

    methods: {

        handleImageChange(event) {
            this.image = event.target.files[0];
        },

        async submitForm() {
            this.message = "";

            const formData = new FormData();

            formData.append("name", this.form.name);
            formData.append("description", this.form.description);
            formData.append("price", this.form.price);
            formData.append("sale_price", this.form.sale_price);
            formData.append("type", this.form.type);

            if (this.image) {
                formData.append("image_name", this.image);
            }

            try {
                const response = await axios({
                    method: this.product ? "PUT" : "POST",
                    url: this.link,
                    data: formData,
                    headers: {
                        "Content-Type": "multipart/form-data",
                        "X-CSRF-TOKEN": this.csrfToken
                    }
                });

                this.message = response.data.message || "Produit enregistré avec succès.";
                this.messageType = "alert-success";

                // reset image
                this.image = null;

            } catch (error) {
                console.error(error);
                
                if (error.response?.data?.errors) {
                    this.message = Object.values(error.response.data.errors).flat().join("\n");
                } else {
                    this.message = "Erreur lors de l'enregistrement.";
                }

                this.messageType = "alert-danger";
            }
        }
    }
};
</script>