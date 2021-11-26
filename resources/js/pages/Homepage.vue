<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">

            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    :headers="table_headers"
                    :footer-props="footer_props"
                    :items="orders.items"
                    item-key="id"
                    :options.sync="options"
                    :server-items-length="orders.count"
                    :loading="loading"
                    :search="search"
                >
                    <template v-slot:top>
                        <v-row>
                            <v-col cols="6">
                                <h1>Orders</h1>
                                <button-with-dialog
                                    title="Добавить заказ"
                                    header_text="Новый заказ"
                                    mdi_icon="mdi-plus"
                                    button_color="green"
                                >
                                    <h1>dsdsd</h1>
                                </button-with-dialog>
                            </v-col>
                            <v-col cols="6">
                                <v-spacer />
                                <v-text-field
                                    v-model="search"
                                    label="Поиск по таблице"
                                />
                            </v-col>
                        </v-row>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-row>
                            <v-col cols="6">
                                <button-with-dialog
                                    title="Редактировать заказ"
                                    header_text="Редактировать заказ"
                                    mdi_icon="mdi-pencil"
                                    button_color="warning"
                                >
                                    <h1>dsdsd</h1>
                                </button-with-dialog>
                            </v-col>
                            <v-col cols="6">
                                <v-btn
                                    color="error"
                                    small
                                    fab
                                    title="Удалить Заявку"
                                >
                                    <v-icon>
                                        mdi-delete
                                    </v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </template>
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
                search: '',
                table_headers: [
                    {text: 'Название', value: 'name', align: 'center'},
                    {text: 'Дата создания', value: 'created_at', align: 'center'},
                    {text: 'Дата завершения', value: 'completion_date', align: 'center'},
                    {text: 'Статус', value: 'status', align: 'center'},
                    {text: 'Управление', value: 'actions', align: 'center', sortable: false},
                ],
                footer_props: {
                    'items-per-page-options': [10, 20, 50, 100],
                    'items-per-page-text': 'Заказов на странице',
                },
                options: {},
                loading: false,
            }
        },
        computed: {
            orders() {
                return this.$store.getters.getAllOrders;
            },
        },

        watch:{
            options: {
                handler (value) {
                    this.$store.dispatch('getOrders', {
                        limit: value.itemsPerPage,
                        pagination: value.itemsPerPage*(value.page-1),
                        orderBy: value.sortBy[0],
                        orderDirection: value.sortDesc[0] ? 'desc' : 'asc',
                    });
                },
                deep: true,
            },
        },
    }
</script>
<style scoped>
    h1 {
        display: inline-block;
    }
</style>
