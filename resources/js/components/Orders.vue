<template>
    <v-data-table
        dark
        dense
        @dblclick:row="(e, item) => item.expand(!item.isExpanded)"
        :items="orders"
        hide-default-footer
        :headers="table_headers"
    >
        <template v-slot:item.created_at="{item}">
            <span>{{ normalDate(item.created_at) }}</span>
        </template>
        <template v-slot:expanded-item="{headers, item}">
            <td :colspan="headers.length">
                <v-card flat>
                    <v-data-table
                        dark
                        dense
                        hide-default-footer
                        :headers="expand_table_headers"
                        :items="item.order_products"
                    >
                        <template v-slot:item="{item, index}">
                            <tr>
                                <td style="width:50px;">
                                    <v-img
                                        v-if="item.product.images.length"
                                        :src="item.product.images[0].url"
                                        :aspect-ratio="1"
                                        height="50"
                                        width="50"
                                    >
                                        <template v-slot:placeholder>
                                            <v-row
                                                class="fill-height ma-0"
                                                align="center"
                                                justify="center"
                                            >
                                                <v-img
                                                    src="/images/gold_logo.png"
                                                    class="image"
                                                    :aspect-ratio="1"
                                                />
                                            </v-row>
                                        </template>
                                    </v-img>
                                </td>
                                <td style="width:80%;">
                                    {{ item.product.name }}
                                </td>
                                <td>
                                    {{item.quantity}}
                                </td>
                                <td>
                                    {{ item.quantity * item.price }} ₽
                                </td>
                            </tr>
                        </template>
                    </v-data-table>
                </v-card>
            </td>
        </template>
    </v-data-table>
</template>

<script>

    /**
     * Компонент - "Просмотр заказов для админов"
     */
    import normalDate from "../mixins/normalDate";

    export default {
        name: 'Orders',
        mixins: [
            normalDate,
        ],
        data() {
            return {
                table_headers: [ //Заголовки таблицы
                    {text: 'Дата создания', value: 'created_at', align: 'center'},
                    {text: 'Имя', value: 'name', align: 'center'},
                    {text: 'Телефон', value: 'phone', align: 'center'},
                    {text: 'E-mail', value: 'email', align: 'center'},
                    {text: 'Комментарий', value: 'comment', align: 'center'},
                    {text: 'Статус', value: 'status', align: 'center'},
                    {text: 'Управление', value: 'actions', align: 'center', sortable: false},
                ],
                expand_table_headers: [ //Заголовки таблицы
                    {text: 'Фото', value: 'photo', align: 'center'},
                    {text: 'Название', value: 'name', align: 'center'},
                    {text: 'Количество', value: 'phone', align: 'center'},
                    {text: 'Стоимость', value: 'email', align: 'center'}
                ],
                // orders: [],
            }
        },
        computed: {
            orders() {
                return this.$store.getters.getAllOrders
            },

            statuses() {
                return this.$store.getters.getAllOrderConst
            }
        },

        mounted() {
            this.$store.dispatch('getOrders');
            this.$store.dispatch('getOrderConst');
        }

    };
</script>
<style scoped>
    h1 {
        display: inline-block;
    }
</style>
