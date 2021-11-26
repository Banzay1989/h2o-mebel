<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <h1>Orders</h1>
                <button-with-dialog
                    title="Добавить заказ"
                    header_text="Новый заказ"
                    mdi_icon="mdi-plus"
                >
                    <h1>dsdsd</h1>
                </button-with-dialog>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    :items="orders"
                >

                </v-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import ButtonWithDialog from "../components/ButtonWithDialog";

    export default {
        name: "Homepage",
        components: {
            ButtonWithDialog,
        },
        data() {
            return {
                orders: []
            }
        },
        mounted() {
            axios.get('/api/orders')
                .then(response => {
                    this.orders = response.data.data;
                });
        },

    }
</script>
<style scoped>
    h1{
        display: inline-block;
    }
</style>
