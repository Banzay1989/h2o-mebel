<template>
    <v-container
        fluid
        class="thin_container"
    >
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
            Products,
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
