<template>
    <v-data-table
        dark
        dense
        :items="orders"
        hide-default-footer
    ></v-data-table>
</template>

<script>

    /**
     * Компонент - "Просмотр заказов для админов"
     */
    export default {
        name: 'Orders',
        data(){
            return{
                orders: [],
            }
        },

    };
</script>
<style scoped>
    h1 {
        display: inline-block;
    }
</style>
