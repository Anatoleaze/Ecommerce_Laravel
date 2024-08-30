<template>

    <div class="wrap-slick1">
        <div class="slick1">
            <div class="item-slick1" style="background-image: url(images/slide-01.jpg);">
                <div class="container h-full">
                    <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                        <div class="layer-slick1 animated" data-appear="fadeInDown" data-delay="0">
                            <span class="ltext-101 cl2 respon2">
                                Collection Femmes {{  currentYear }}
                            </span>
                        </div>
                            
                        <div class="layer-slick1 animated" data-appear="fadeInUp" data-delay="800">
                            <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                Nouvelle saison
                            </h2>
                        </div>
                            
                        <div class="layer-slick1 animated" data-appear="zoomIn" data-delay="1600">
                            <a :href="link" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                Achetez maintenant
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
export default{
    name : 'SliderComponent',

    props: {
                
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
            console.log('Slider Component mounted.');
    },
}
</script>