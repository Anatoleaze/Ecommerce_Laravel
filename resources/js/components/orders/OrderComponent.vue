<template>

<div class="bg0 p-t-75 p-b-85">
    <div class="container">
        <div class="row">    
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Date</th>
                                <th class="column-1">Numéro de Suivie</th>
                                <th v-if="user.role != 'admin'" class="column-1">Montant</th>
                                <th class="column-1">Status</th>
                                <th class="column-1">Détail</th>
                            </tr>

                            <tr v-for="order in orders" class="table_row">
                                <td class="column-1">{{ formatDate(order.created_at) }}</td>
                                <td class="column-1">{{ order.numero_commande }}</td>
                                <td v-if="user.role != 'admin'" class="column-1">{{ order.total }} €</td>
                                <td class="column-1">{{ order.statut}}</td>
                                <td class="column-1">
                                    <a :href="`/commandes/details/${order.id}`" class="btn btn-info"> Voir </a>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</template>

<script>


export default {
    name : 'OrderComponent',

    props : {
        orders : {
            type : Array,
            required : true
        },

        user: {
            type: Object,
            required: true
        },
    },


    methods: {
        formatDate(date) {
            return new Intl.DateTimeFormat("fr-FR", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            }).format(new Date(date));
        },

  },

    mounted() {
        console.log('OrderComponent is mounted');
        
    },


}
</script>