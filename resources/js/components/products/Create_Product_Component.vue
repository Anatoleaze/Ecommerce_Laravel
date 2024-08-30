<template>

    <div class="col-8 m-auto">
        <form :action=link method="POST" enctype="multipart/form-data">
            <input type="hidden" :value="csrfToken" name="_token">
            <div class="from-group m-b-25">
                <label for="name">Nom</label>
                <input type="text" class="form-control" name="name" id="name" />
            </div>
            <div class="from-group m-b-25">
                <label for="type">Catégorie</label>
                <select name="type" id="type" class="form-control">
                    <option value="femmes">Femmes</option>
                    <option value="hommes">Hommes</option>
                    <option value="montres">Montres</option>
                    <option value="sacs">Sacs</option>
                    <option value="chaussures">Chaussures</option>
                </select>
            </div>
            <div class="from-group m-b-25">
                <label for="description">Description</label>
                <textarea type="text" class="form-control" id="description" name="description" rows="6"></textarea>
            </div>
            <div class="from-group m-b-25">
                <label for="image_name">Image</label>
                <input type="file" class="form-control-file" id="image_name" name="image_name">
            </div>
            <div class="from-group m-b-25">
                <label for="prix">Prix</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="price"/>
            </div>
            <div class="from-group m-b-25">
                <label for="solde">Prix Soldé</label>
                <input type="number" step="0.01" class="form-control" id="solde" name="sale_price"/>
            </div>

            <div class="from-group col-6 m-auto m-b-25" >
                <input type="submit" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 p-lr-15 trans-04" style="cursor:pointer;" value="Créer ce produit" />
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
    
        csrfToken: {
            type: String,
            required: true
        }
    }
}
</script>