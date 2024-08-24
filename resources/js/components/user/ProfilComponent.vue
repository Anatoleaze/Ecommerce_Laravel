<template>

    <div class="box">
        
        <div class="row">
            <p> Nom : {{ name }}</p>
        </div>

        <div class="row">
            <p> Prénom : {{  first_name }}</p>
        </div>
        
        <div  class="row m-b-25">
            <p> Email : {{ mail }} </p>
        </div>

        <div class="row">
            <a :href="link" class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04 m-auto"> Modifier mon profils</a>
        </div>

    </div>


</template>

<script>

export default {
    name: 'ProfilComponent',

    props:{
        name:{
            type: String,
            required: true,
        },

        first_name:{
            type: String,
            required: true,
        },

        mail:{
            type: String,
            required: true,
        },

        link:{
            type: String,
            required: true,
        }
    },

    mounted (){
        console.log(' Profil Component mounted');
       
    }

}
</script>

<style>

.box{
    width: 50%;
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

</style>