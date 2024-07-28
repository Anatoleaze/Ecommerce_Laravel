<template>
    <div class="flex-w flex-sb-m p-b-52">
        <div class="flex-w flex-l-m filter-tope-group m-tb-10">
            <button @click="emitEvent('*')" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                Tous les produits
            </button>
            <button @click="emitEvent('.femme')" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".femme">
                Femme
            </button>
            <button @click="emitEvent('.homme')" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".homme">
                Homme
            </button>
            <button @click="emitEvent('.sacs')" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".sacs">
                Sacs
            </button>
            <button @click="emitEvent('.chaussures')" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".chaussures">
                Chaussures
            </button>
            <button @click="emitEvent('.montres')" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".montres">
                Montres
            </button>
        </div>
        <!-- Other parts of the template remain the same -->
    </div>
</template>

<script>
export default {
    methods: {
        emitEvent(filter) {
            console.log('filterEvent emit : '+ filter);
            this.$emit('filterEvent', filter);

            const event = new CustomEvent('filterEvent', { detail: filter });
            window.dispatchEvent(event);
        }
    },
    mounted() {
        console.log('Filter Component mounted');
    }
}
</script>
