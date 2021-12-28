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
        <v-row v-if="header !== ''" class="subheader">
            <v-col cols="6">
                <p @click="getProducts({orderBy: 'created_at', orderDirection: 'desc', limit:product_cols, pagination: 0})">
                    Новые поступления
                </p>
                <p>-</p>
                <p>Самые продаваемые</p>
                <p>-</p>
                <p>Специальные</p>
            </v-col>
        </v-row>
        <v-row>
            <v-col
                cols="12"
                md="3"
                v-if="sidebar"
            >
                <sidebar/>
            </v-col>
            <v-col
                cols="12"
                :md="sidebar ? 9 : 12"
                class="col"
            >
                <v-row pa="0" ma="0" wrap class="products">
                    <v-col
                        cols="12"
                        :md="4"
                        v-for="(product, index) in products"
                        :key="product.id"
                        :class="'col product_col'+isLast(index)"
                    >
                        <a :href="'/product/'+product.id">
                            <v-img
                                class="image"
                                :src="product.file"
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
                        <p>{{ product.name }}</p>
                        <p>₽{{ product.price }}</p>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import Sidebar from "./Sidebar";
    export default {
        name: "Products",
        components: {
            Sidebar,
        },
        mixins: [],
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
                products: [],
            }
        },
        computed: {
            product_cols() {
                return this.sidebar ? 9 : 12;
            },
        },
        watch: {},
        mounted() {
            this.getProducts({
                orderBy: 'created_at',
                orderDirection: 'desc',
                limit: this.product_cols,
                pagination: 0
            });
        },

        methods: {
            async getProducts(params = {}) {
                await axios.get(`/api/products`, {
                    params: params
                }).then(response => {
                    this.products = response.data.products;
                }).catch(errors => console.log(errors));
            },

            /**
             *
             * @param index
             * @return {string}
             */
            isLast(index) {
                return ((index + 1) * 4 % this.product_cols) === 0 ? ' last_col' : '';
            }
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
        padding-right: 12px;
    }

    .last_col{
        padding-right: 0 !important;
    }

    .subheader p, .products p {
        margin: 0 auto;
    }
</style>
