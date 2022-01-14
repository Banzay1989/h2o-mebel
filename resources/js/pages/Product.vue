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
                <v-row>
                    <v-col cols="12">
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
                </v-row>
                <v-row
                    v-if="product.images.length"
                >
                    <v-col
                        cols="1"
                        class="arrow_carousel"
                    >
                        <span
                            class="prev_carousel"
                            @click="active_img === 0 ? 0 : active_img--"
                        >&lt;</span>
                    </v-col>
                    <v-col
                        cols="2"
                        v-for="(image,i) in product.images"
                        v-show="isShown(i)"
                        :key="image.id"
                    >
                        <v-img
                            :src="image_src"
                            :aspect-ratio="1"
                            :class="isSelected(image)"
                            @click="active_img = i"
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
                    </v-col>
                    <v-col
                        cols="1"
                        class="arrow_carousel"
                    >
                        <span
                            class="next_carousel"
                            @click="active_img === product.images.length-1 ? product.images.length-1 : active_img++"
                        >&gt;</span>
                    </v-col>
                </v-row>
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
                        @click="addToCart()"
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
                    {{ product.description }}
                </v-sheet>
                <v-sheet
                    dark
                    v-else-if="block==='parameters'"
                >
                    {{ 'Тут будут параметры' }}
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
                block: 'description',
            }
        },
        computed: {
            image_src() {
                return this.product?.images?.[this.active_img]?.url;
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
                    images: [],
                    brand: [],
                }
            },
            isSelected(image) {
                return this.product?.images?.[this.active_img]?.id === image.id ? 'selected' : '';
            },
            isShown(i) {
                const last_index = this.product.images.length - 1;
                const max_on_view = 4;
                let is_shown = false;
                if (i >= this.active_img && i <= this.active_img + max_on_view) {
                    is_shown = true;
                } else if (this.active_img + max_on_view > last_index) {
                    if (i <= ((this.active_img + max_on_view) - last_index)) {
                        is_shown = true;
                    }
                }
                return is_shown;
            },
            addToCart() {
                this.$store.dispatch('addToCart', {
                    product: this.product,
                    quantity: this.quantity,
                })
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

    .selected {
        box-shadow: 0px 0px 10px 10px white inset;
    }

    .prev_carousel, .next_carousel {
        cursor: pointer;
        font-size: 42px;
    }

    .arrow_carousel {
        display: flex;
        align-self: center;
        justify-content: center;
    }

    .buy {
        align-items: baseline;
    }
</style>
