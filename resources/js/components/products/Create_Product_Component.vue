<template>

    <div class="col-8 m-auto">
        <form :action=link method="POST" enctype="multipart/form-data">
            
            <input type="hidden" :value="csrfToken" name="_token">
            <input v-if='product' type="hidden" name="_method" value="PUT">

            <div class="from-group m-b-25">
                <label for="name">Nom</label>     
                <input v-if='product' type="text" v-model="product.name" class="form-control" name="name" id="name" required/>
                <input v-else type="text" class="form-control" name="name" id="name" required/>
            </div>
            
            <div class="from-group m-b-25">
                <label for="type">Catégorie</label>

                <select v-if='product' v-model="product.type" name="type" id="type" class="form-control" required>
                    <option value="femmes">Femmes</option>
                    <option value="hommes">Hommes</option>
                    <option value="montres">Montres</option>
                    <option value="sacs">Sacs</option>
                    <option value="chaussures">Chaussures</option>
                </select>

                <select v-else name="type" id="type" class="form-control" required>
                    <option value="femmes">Femmes</option>
                    <option value="hommes">Hommes</option>
                    <option value="montres">Montres</option>
                    <option value="sacs">Sacs</option>
                    <option value="chaussures">Chaussures</option>
                </select>
            </div>

            <div class="from-group m-b-25">
                <label for="description">Description</label>
                <textarea v-if="product" v-model="product.description"  class="form-control" id="description" name="description" rows="6"></textarea>
                <textarea v-else class="form-control" id="description" name="description" rows="6"></textarea>
            </div>
            <div class="from-group m-b-25">
                <label for="image_name">Image</label>

                <input type="file" v-if="product" class="form-control-file" id="image_name" name="image_name">

                <input type="file" v-else class="form-control-file" id="image_name" name="image_name">
                
            </div>
            <div class="from-group m-b-25">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" v-if='product' v-model="product.price" class="form-control" id="prix" name="price"/>

                <input type="number" step="0.01" v-else class="form-control" id="prix" name="price"/>
            </div>
            <div class="from-group m-b-25">
                <label for="solde">Prix Soldé (optionnel)</label>
                <input type="number" step="0.01" v-if='product' v-model="product.sale_price" class="form-control" id="solde" name="sale_price"/>

                <input type="number" step="0.01" v-else class="form-control" id="solde" name="sale_price"/>
            </div>

            <div class="from-group col-6 m-auto m-b-25" >
                <input type="submit" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 p-lr-15 trans-04" style="cursor:pointer;" value="Valider" />
            </div>
        </form>
    </div>
</template>

<script>

export default {
    name: "CreateProductComponent",
    props:{
    
        link:{
            type: String,
            required: true,
        },
    
        product: {
            type: Object,
            required: false,
        },

        csrfToken: {
            type: String,
            required: true
        }
    },

    methods: {
        /*handleImageChange(event) {
            this.image = event.target.files[0];
        },
 
        async submitForm() {
            const formData = new FormData();

            if (this.product) {
                formData.append('name', this.product.name || '');
                formData.append('description', this.product.description || '');
                formData.append('price', this.product.price || '');
                formData.append('sale_price', this.product.sale_price || '');
                formData.append('type', this.product.type || '');
            }

            if (this.image) {
                formData.append('image_name', this.image);
            }

            try {
                await axios.post(this.link, formData, {
                    headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-Requested-With': 'XMLHttpRequest',
                    },
                });
            
                this.message = 'Produit mis à jour avec succès.';
                // Optionnel : redirection ou autre action après succès
            } catch (error) {
                console.error('Erreur lors de la mise à jour du produit:', error);
            }
        },*/
    },

}
</script>