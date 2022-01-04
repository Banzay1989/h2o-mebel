<template>
    <v-container
        fluid
        class="thin_container"
    >
        <v-row>
            <v-col
                cols="12"
                md="5"
                class="col image_col"
            >
                <v-img
                    class="image"
                    :src="image_src"
                    :aspect-ratio="278/318"
                    height="520"
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
                                :aspect-ratio="278/318"
                                height="520"
                            />
                        </v-row>
                    </template>
                </v-img>
            </v-col>
            <v-col
                cols="12"
                md="7"
                class="col"
            >
                <h3>{{ product.name }}</h3>
                <ul>
                    <li>
<!--                        <strong>Бренд: </strong><a :href="brand_src">{{ product.brand.name }}</a>-->
                        <strong>Бренд: </strong><span>{{ product.brand.name }}</span>
                    </li>
                    <li>
                        <strong>Артикул: </strong> <span>{{ product.article }}</span>
                    </li>
                    <li>
                        <strong>Доступность: </strong> <span>{{ in_stock }}</span>
                    </li>
                </ul>
                <br>
                <strong>₽ {{ product.price }}</strong>
                <v-row class="buy">
                    <v-text-field
                        dark
                        class="page_selector"
                        v-model="quantity"
                        type="number"
                        min="1"
                    >
                        <template v-slot:prepend>
                            <span>Колич: </span>
                        </template>
                    </v-text-field>
                    <v-btn
                        dark
                        disabled
                        @click="buy()"
                    >
                        Купить
                    </v-btn>
                </v-row>
            </v-col>
        </v-row>
        <v-row class="description_specification">
            <v-col cols="4" class="col">
                <p
                    @click="block='description'"
                >
                    Описание
                </p>
                <p>-</p>
                <p
                    @click="block='parameters'"
                >
                    Параметры
                </p>
                <!--                <p>-</p>-->
                <!--                <p>Специальные</p>-->
            </v-col>
            <v-col cols="12">
                <v-sheet
                    dark
                    v-if="block==='description'"
                >
                    {{product.description}}
                </v-sheet>
                <v-sheet
                    dark
                    v-else-if="block==='parameters'"
                >
                    {{'Тут будут параметры'}}
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "Product",
        components: {},
        mixins: [],
        data() {
            return {
                product: this.clearProduct(),
                quantity: 1,
                is_aviable: true,
                active_img: 0,
                block:'description',
            }
        },
        computed: {
            image_src(){
              return this.product?.files?.[this.active_img];
            },

            in_stock() {
                return this.product?.deleted_at ? 'Не продаётся' : 'В продаже';
            },
        },

        async mounted() {
            await this.getProduct();
        },

        methods: {
            async getProduct() {
                await axios.get(`/api/products/${this.$route.params.id}`).then(response => {
                    this.product = response.data.product;
                    this.is_aviable = !this.product?.deleted_at;
                }).catch(errors => console.log(errors));
            },
            clearProduct() {
                return {
                    id: null,
                    name: '',
                    article: '',
                    brand_id: null,
                    category_id: null,
                    deleted_at: null,
                    description: '',
                    price: 0,
                    files: [],
                    brand: [],
                }
            },
            buy() {

            },
        },
    }
</script>
<style scoped>
    .image_col {
        padding-right: 32px;
    }

    h3 {
        color: #a9a9a9;
        border-bottom: 1px solid #37302e;
    }

    .page_selector {
        max-width: 96px;
    }

    .description_specification {
        justify-content: center;
    }

    .description_specification > .col {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    .description_specification p {
        margin: 0 auto;
    }

    .buy {
        align-items: baseline;
    }
</style>
