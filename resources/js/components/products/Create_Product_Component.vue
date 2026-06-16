<template>
  <div style="min-height:100vh; background:#f6f7fb; padding:60px 0;">

    <div style="max-width:700px; margin:0 auto;">

      <!-- CARD -->
      <div style="
        background:white;
        border-radius:18px;
        padding:30px;
        box-shadow:0 15px 40px rgba(0,0,0,0.06);
      ">

        <!-- MESSAGE -->
        <div v-if="message"
             :class="['alert', messageType]"
             style="
               margin-bottom:20px;
               padding:12px;
               border-radius:10px;
               font-size:13px;
               text-align:center;
               white-space:pre-line;
               font-weight:600;
             ">
          {{ message }}
        </div>

        <!-- Info -->
        <p style="
          color:#999;
          font-size:13px;
          margin-bottom:25px;
          text-align:right;
        ">
          <span style="color:#dc3545; font-weight:700;">*</span>
          Champs obligatoires
        </p>

        <form @submit.prevent="submitForm" enctype="multipart/form-data">

          <input type="hidden" :value="csrfToken" name="_token">

          <!-- GRID -->
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

            <!-- NAME -->
            <div style="grid-column: span 2;">
              <label style="font-size:12px; font-weight:800; color:#555; text-transform:uppercase; letter-spacing:1px;">
                Nom du produit
                <span style="color:#dc3545;">*</span>
              </label>

              <input v-model="form.name"
                     type="text"
                     required
                     style="
                       width:100%;
                       margin-top:6px;
                       padding:12px 14px;
                       border:2px solid #eee;
                       border-radius:10px;
                       font-size:14px;
                       outline:none;
                       transition:0.2s;
                     "
                     onfocus="this.style.borderColor='#1a1a2e'"
                     onblur="this.style.borderColor='#eee'">
            </div>

            <!-- CATEGORY -->
            <div>
              <label style="font-size:12px; font-weight:800; color:#555;">
                Catégorie
                <span style="color:#dc3545;">*</span>
              </label>

              <select v-model="form.type"
                      required
                      style="
                        width:100%;
                        margin-top:6px;
                        padding:12px 14px;
                        border:2px solid #eee;
                        border-radius:10px;
                        font-size:14px;
                        background:white;
                        outline:none;
                      "
                      onfocus="this.style.borderColor='#1a1a2e'"
                      onblur="this.style.borderColor='#eee'">

                <option value="">Sélectionnez une catégorie</option>
                <option value="femmes">Femmes</option>
                <option value="hommes">Hommes</option>
                <option value="montres">Montres</option>
                <option value="sacs">Sacs</option>
                <option value="chaussures">Chaussures</option>
              </select>
            </div>

            <!-- PRICE -->
            <div>
              <label style="font-size:12px; font-weight:800; color:#555;">
                Prix
                <span style="color:#dc3545;">*</span>
              </label>

              <input v-model="form.price"
                     type="number"
                     step="0.01"
                     required
                     style="
                       width:100%;
                       margin-top:6px;
                       padding:12px 14px;
                       border:2px solid #eee;
                       border-radius:10px;
                       font-size:14px;
                       outline:none;
                     "
                     onfocus="this.style.borderColor='#1a1a2e'"
                     onblur="this.style.borderColor='#eee'">
            </div>

            <!-- SALE PRICE -->
            <div>
              <label style="font-size:12px; font-weight:800; color:#555;">
                Prix soldé
              </label>

              <input v-model="form.sale_price"
                     type="number"
                     step="0.01"
                     placeholder="Optionnel"
                     style="
                       width:100%;
                       margin-top:6px;
                       padding:12px 14px;
                       border:2px solid #eee;
                       border-radius:10px;
                       font-size:14px;
                       outline:none;
                     "
                     onfocus="this.style.borderColor='#1a1a2e'"
                     onblur="this.style.borderColor='#eee'">
            </div>

            <!-- DESCRIPTION -->
            <div style="grid-column: span 2;">
              <label style="font-size:12px; font-weight:800; color:#555;">
                Description
                <span style="color:#dc3545;">*</span>
              </label>

              <textarea v-model="form.description"
                        rows="5"
                        required
                        style="
                          width:100%;
                          margin-top:6px;
                          padding:12px 14px;
                          border:2px solid #eee;
                          border-radius:10px;
                          font-size:14px;
                          outline:none;
                          resize:none;
                        "
                        onfocus="this.style.borderColor='#1a1a2e'"
                        onblur="this.style.borderColor='#eee'"></textarea>
            </div>

            <!-- IMAGE -->
            <div style="grid-column: span 2;">
              <label style="font-size:12px; font-weight:800; color:#555;">
                Image du produit
                <span style="color:#dc3545;">*</span>
              </label>

              <input type="file"
                     @change="handleImageChange"
                     style="
                       width:100%;
                       margin-top:6px;
                       padding:10px;
                       border:2px dashed #ddd;
                       border-radius:10px;
                       background:#fafafa;
                     ">

              <p style="
                margin-top:8px;
                color:#999;
                font-size:12px;
              ">
                Formats recommandés : JPG, PNG ou WEBP.
              </p>
            </div>

          </div>

          <!-- SUBMIT -->
          <button type="submit"
                  style="
                    width:100%;
                    margin-top:20px;
                    padding:14px;
                    background:linear-gradient(135deg,#1a1a2e,#333);
                    color:white;
                    border:none;
                    border-radius:12px;
                    font-size:14px;
                    font-weight:800;
                    cursor:pointer;
                    transition:0.2s;
                  "
                  onmouseover="this.style.transform='translateY(-1px)'"
                  onmouseout="this.style.transform='translateY(0)'">

            💾 Valider
          </button>

        </form>

      </div>
    </div>

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
        this.image = null;

      } catch (error) {

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