<template>
    <v-container
        fluid
        class="thin_container"
    >

        <v-row>
            <v-col
                cols="12"
                md="3"
            >
                <v-list>
                    <v-list-item>
                        <v-list-item-title>Аккаунт</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content dark>Авторизация</v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-col>
            <v-col
                cols="12"
                md="9"
                class="col"
            >
                <login/>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import Login from "../components/Login";
    export default {
        name: "Account",
        components: {
            Login,
        },
        mixins: [],
        // data() {
            // return {
            //     product: this.clearProduct(),
            //     quantity: 1,
            //     is_aviable: true,
            //     active_img: 0,
            //     block: 'description',
            // }
        // },
        computed: {
            // image_src() {
            //     return this.product?.images?.[this.active_img]?.url;
            // },
            //
            // in_stock() {
            //     return this.product?.deleted_at ? 'Не продаётся' : 'В продаже';
            // },
        },

        async mounted() {
            // await this.getProduct();
        },

        methods: {
            // async getProduct() {
            //     await axios.get(`/api/products/${this.$route.params.id}`).then(response => {
            //         this.product = response.data.product;
            //         this.is_aviable = !this.product?.deleted_at;
            //     }).catch(errors => console.log(errors));
            // },
            // clearProduct() {
            //     return {
            //         id: null,
            //         name: '',
            //         article: '',
            //         brand_id: null,
            //         category_id: null,
            //         deleted_at: null,
            //         description: '',
            //         price: 0,
            //         images: [],
            //         brand: [],
            //     }
            // },
            // isSelected(image) {
            //     return this.product?.images?.[this.active_img]?.id === image.id ? 'selected' : '';
            // },
            // isShown(i) {
            //     const last_index = this.product.images.length - 1;
            //     const max_on_view = 4;
            //     let is_shown = false;
            //     if (i >= this.active_img && i <= this.active_img + max_on_view) {
            //         is_shown = true;
            //     } else if (this.active_img + max_on_view > last_index) {
            //         if (i <= ((this.active_img + max_on_view) - last_index)) {
            //             is_shown = true;
            //         }
            //     }
            //     return is_shown;
            // },
            // buy() {
            //
            // },
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
