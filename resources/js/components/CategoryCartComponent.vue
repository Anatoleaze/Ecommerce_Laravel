<template>

    <div class="block1 wrap-pic-w">
        <img :src=image alt="IMG-BANNER">

        <a :href="link" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
            <div class="block1-txt-child1 flex-col-l">
                <span class="block1-name ltext-102 trans-04 p-b-8">
                    {{ title }}
                </span>

                <span class="block1-info stext-102 trans-04">
                    {{subtitle}} {{currentYear}}
                </span>
            </div>

            <div class="block1-txt-child2 p-b-4 trans-05">
                <div class="block1-link stext-101 cl0 trans-09">
                    Achetez maintenant
                </div>
            </div>
        </a>
    </div>

</template>


<script>

export default {
    name : 'CategoryCartComponent',
    
    props : {
        
        image: {
            type : String,
            required : true
        },

        title: {
            type : String,
            required : true
        },

        subtitle: {
            type : String,
            required : true
        },

        link: {
            type: String,
            required: true
        }

    },

    data() {
        return {
        currentYear: new Date().getFullYear(),
        };
    },

    mounted() {
        console.log('Component mounted');
    }
    
}
</script>