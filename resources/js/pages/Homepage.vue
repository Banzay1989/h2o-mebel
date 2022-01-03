<template>
    <v-container class="main_container">
        <banner-top/>
        <products
            header="Наши продукты"
        />
    </v-container>
</template>

<script>
    import Products from "../components/Products";
    import BannerTop from "../components/BannerTop";
    export default {
        name: "Homepage",
        components: {
            Products,
            BannerTop,
        },
        mixins: [
        ],
        data() {
            return {

            }
        },
        computed: {

        },

        watch: {

        },

        methods: {

        },
    }
</script>
<style scoped>
    .main_container{
        margin: 0;
        min-width: 100%;
        padding: 0;
    }
</style>
