<template>

    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1 text-center">Produits</th>
                                    <th class="column-2"></th>
                                    <th class="column-4 text-center">Quantité</th>
                                </tr>

                                <tr v-for="row in order" :key="row.id" class="table_row">
                                    <td class="column-1">
                                        <div>
                                            <img class="img-item" :src="'/' + row.product_image" alt="IMG" />
                                        </div>
                                    </td>
                                    <td class="column-2"> {{ row.product_name }} </td>
                                    <td class="column-4 text-center"> {{ row.quantity }} </td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Récapitulatif
                        </h4>


                        <div class="flex-w flex-t bor12 p-b-13 m-b-15">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Statue :
                                </span>
                            </div>

                            <div class="size-209">

                                <span class="alert alert-info">
                                    {{ orderLocal.statut }}
                                </span>
                            </div>


                        </div>
                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-228">
                                <span class="stext-110 cl2 m-r-5">
                                    Numéro de suivi :  
                                </span>
                                
                            </div>
                                <span class="stext-110 cl2">
                                    {{ order[0].num }}
                                </span>    
                        </div>


                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="w-full-ssm p-r-15">

                                <span class="stext-110 cl2">
                                    Livraison :
                                </span>

                                <div class="rs1-select2 rs2-select2 m-b-12 m-t-9">
                                    <p>{{ order[0].livraison }}</p>
                                </div>

                                
                            </div>
                        </div>


                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total :
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    {{ order[0].total }} €
                                </span>
                            </div>

                        </div>

                        <div v-if="user.role = 'admin' && orderLocal.statut === 'en attente'" class="size-228">
                                <span class="mtext-101 cl2">
                                    Changer le status :
                                </span>
                        </div>
                        <div v-if="user.role = 'admin' && orderLocal.statut === 'en attente'" @click="changeStatus(order[0].order_id)" class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                            En cours de Livraison
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

</template>

<script>
import axios from 'axios';
export default {
    name: "OrderDetailComponent",

    props: {
        order: {
            type: Array,
            required: true
        },

        user: {
            type: Object,
            required: true
        },
    },

    data() {
        return {
            orderLocal: { ...this.order[0] },
        };
    },


    methods: {
        formatDate(date) {
            return new Intl.DateTimeFormat("fr-FR", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            }).format(new Date(date));
        },

        async changeStatus(order_id){
            console.log("changeStatus");
            console.log("order_id", order_id);
            try {
                const response = await axios.patch(`/commande/${order_id}/status`, {
                statut: "encours de livraison",
                });

                if (response.data.success) {
                this.orderLocal.statut = "En cours de livraison"; 
                } else {
                    onsole.error("Erreur lors de la mise à jour du statut :", response.data.message);
                }
            } catch (error) {
                console.error("Erreur lors de la mise à jour du statut :", error);
            }

            /*axios.patch(`/commande/${order_id}/status`)
            .then(response => {
                if (response.data.success) {
                   order_statu = response.data.status;  
                 //this.$emit('order-status-updated', this.order.id, response.data.status);
                } else {
                    alert(response.data.message);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la mise à jour du statut :', error);
            });*/
        },
    },

    mounted() {
        console.log("OrderDetailComponent is mounted");
        console.log(this.order);
    }

}
</script>

<style scoped>
.img-item{
    width: 60px !important;
    position: relative !important;
    margin-right: 20px !important;
}
</style>