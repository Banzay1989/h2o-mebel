<template>
    <v-container fluid>
        <products
            sidebar
        />
    </v-container>
</template>

<script>
    import Products from "../components/Products";

    export default {
        name: "Category",
        components: {
            Products

        },
        mixins: [],
        data() {
            return {}
        },
        computed: {},

        watch: {},

        methods: {},
    }
</script>
<style scoped>

</style>
