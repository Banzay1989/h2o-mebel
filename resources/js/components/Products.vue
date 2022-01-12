<template>
    <v-container
        fluid
        class="thin_container"
    >
        <v-row v-if="header !== ''">
            <v-col
                cols="12"
                class="header_block"
            >
                <h2>{{ header }}</h2>
            </v-col>
        </v-row>
        <!--        <v-row v-if="header !== ''" class="subheader">-->
        <!--            <v-col cols="6">-->
        <!--                <p @click="">-->
        <!--                    Новые поступления-->
        <!--                </p>-->
        <!--                <p>-</p>-->
        <!--                <p>Самые продаваемые</p>-->
        <!--                <p>-</p>-->
        <!--                <p>Специальные</p>-->
        <!--            </v-col>-->
        <!--        </v-row>-->
        <v-row>
            <v-col
                cols="12"
                md="3"
                v-if="sidebar"
            >
                <sidebar />
            </v-col>
            <v-col
                cols="12"
                :md="sidebar ? 9 : 12"
                class="col"
            >
                <v-row
                    v-if="sidebar"
                >
                    <v-col
                        cols="12"
                        md="4"
                        class="col"
                    >
                        <!--                        тут будет сравнение и переключение вида товаров-->
                    </v-col>
                    <v-col
                        cols="12"
                        md="8"
                        class="col top_selectors"
                    >
                        <v-autocomplete
                            dark
                            class="order_selector"
                            v-model="selected_order"
                            :items="order_items"
                            item-text="name"
                            return-object
                        >
                            <template v-slot:prepend>
                                <span>Сортировка: </span>
                            </template>
                        </v-autocomplete>
                        <v-autocomplete
                            dark
                            class="number_selector"
                            v-model="number"
                            :items="number_items"
                        >
                            <template v-slot:prepend>
                                <span>Количество: </span>
                            </template>
                        </v-autocomplete>
                    </v-col>
                </v-row>
                <v-row pa="0" ma="0" wrap class="products">
                    <v-col
                        v-if="isAdmin()"
                        cols="12"
                        :md="sidebar ? 4 : 3"
                        class="col admin_placeholder first_col"
                    >
                        <admin-buttons
                            add
                        >
                            <template v-slot:add>
                                <product-editor/>
                            </template>
                        </admin-buttons>
                    </v-col>
                    <v-col
                        cols="12"
                        :md="sidebar ? 4 : 3"
                        v-for="(item, index) in products"
                        :key="item.id"
                        :class="'col product_col'+isLast(index)+isFirst(index)"
                    >
                        <a :href="'/product/'+item.id">
                            <v-img
                                class="image"
                                :src="getImage(item)"
                                :aspect-ratio="278/318"
                                height="318"
                            >
                                <template v-slot:placeholder>
                                    <v-row
                                        class="fill-height ma-0"
                                        align="center"
                                        justify="center"
                                    >
                                        <v-img src="/images/gold_logo.png"
                                               class="image"
                                               :aspect-ratio="278/318"
                                               height="318"
                                        />
                                    </v-row>
                                </template>
                            </v-img>
                        </a>
                        <p>{{ item.name }}</p>
                        <p>₽{{ item.price }}</p>
                        <p
                            v-if="isAdmin()"
                        >
                            <admin-buttons
                                edit
                                remove
                                @click_remove="$store.dispatch('deleteProduct', item)"
                            >
                                <template v-slot:edit>
                                    <product-editor
                                        :value="item"
                                    />
                                </template>
                            </admin-buttons>
                        </p>
                    </v-col>
                </v-row>
                <v-row
                    v-if="sidebar"
                >
                    <v-col>
<!--                        Тут будут кнопки пагинации-->
                    </v-col>
                    <v-col
                        class="right"
                    >
                        <v-text-field
                            dark
                            class="page_selector"
                            v-model="page"
                            type="number"
                            min="1"
                            :max="pages"
                        >
                            <template v-slot:prepend>
                                <span>Страница: </span>
                            </template>
                        </v-text-field>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import Sidebar from "./Sidebar";
    import AdminButtons from "./AdminButtons";
    import ProductEditor from "./ProductEditor";
    import isAdmin from "../mixins/isAdmin";

    export default {
        name: "Products",
        components: {
            AdminButtons,
            Sidebar,
            ProductEditor,
        },
        mixins: [
            isAdmin,
        ],
        props: {
            header: {
                type: String,
                default: '',
            },
            sidebar: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                order_items: [
                    {name: 'Сперва новые', type: 'created_at', direction: 'desc'},
                    {name: 'Сперва старые', type: 'created_at', direction: 'asc'},
                    {name: 'По имени (А-Я)', type: 'name', direction: 'asc'},
                    {name: 'По имени (Я-А)', type: 'name', direction: 'desc'},
                    {name: 'По цене (Сперва дешевые)', type: 'price', direction: 'asc'},
                    {name: 'По цене (Сперва дорогие)', type: 'price', direction: 'desc'},
                ],
                selected_order: null,
                number_items: [9, 25, 50, 150, 300],
                number: null,
                page: 1,
            }
        },
        computed: {
            product_cols() {
                return this.sidebar ? 9 : 12;
            },
            product_objects() {
                return this.$store.getters.getAllProducts;
            },
            products() {
                return this.product_objects?.items ?? [];
            },
            products_count() {
                return this.product_objects?.count ?? 0;
            },
            slug() {
                return this.$route?.params?.slug ?? null;
            },
            params() {
                return {
                    orderBy: this.selected_order?.type ?? null,
                    orderDirection: this.selected_order?.direction ?? null,
                    limit: this.number,
                    pagination: this.page - 1,
                    slug: this.slug
                };
            },
            pages() {
                return Math.ceil(this.products_count/this.number);
            }
        },
        watch: {
            params: {
                handler(value) {
                    this.$store.dispatch('getProducts', value);
                },
                deep: true,
            },
        },
        async mounted() {
            this.selected_order = this.order_items[0];
            this.number = this.product_cols;
        },

        methods: {

            /**
             *
             * @param index
             * @return {string}
             */
            isLast(index) {
                // return ((index + 1) * 3 % this.product_cols) === 0 ? ' last_col' : '';
                return ((index + 2) * 3 % this.product_cols) === 0 ? ' last_col' : '';
            },

            /**
             *
             * @param index
             * @return {string}
             */
            isFirst(index) {
                // return ((index+3) * 3 % this.product_cols) === 0 ? ' first_col' : '';
                return ((index + 4) * 3 % this.product_cols) === 0 ? ' first_col' : '';
            },

            getImage(item){
                return item?.images?.[0]?.url ?? null;
            },
        },
    }
</script>
<style scoped>
    .header_block {
        justify-content: center;
    }

    h2 {
        font-family: 'Denistina';
        font-size: 3em;
    }

    .subheader, .products {
        justify-content: center;
    }

    .subheader > .col, .products > .col {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    .products > .col {
        flex-direction: column;
        justify-content: center;
        padding-left: 4px;
        padding-right: 4px;
    }

    .products > .col > .col {
        display: flex;
        justify-content: center;
    }

    .last_col {
        padding-right: 0 !important;
        padding-left: 8px !important;
    }

    .first_col {
        padding-right: 8px !important;
        padding-left: 0 !important;
    }

    .page_selector {
        max-width: 124px;
    }

    .number_selector {
        max-width: 174px;
    }

    .order_selector {
        max-width: 372px;
    }

    .subheader p, .products p {
        margin: 0 auto;
    }

    .admin_placeholder {
        align-self: center;
        justify-content: center;
    }

    .top_selectors{
        display: flex;
        justify-content: space-between;
    }
</style>
