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
                        <v-list-item-title>
                            <h3>
                                Аккаунт
                            </h3>
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content
                            dark
                            @click="active_block='login'"
                        >
                            <span>Авторизация</span>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        v-if="!isLogged()"
                    >
                        <v-list-item-content
                            dark
                            @click="active_block='register'"
                        >
                            <span>Регистрация</span>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        v-if="isAdmin()"
                    >
                        <v-list-item-content
                            dark
                            @click="active_block='orders'"
                        >
                            <span>Заказы</span>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-col>
            <v-col
                cols="12"
                md="9"
                class="col"
            >
                <login
                    v-if="active_block==='login'"
                />
                <register
                    v-else-if="active_block==='register'"
                    @registred="active_block='login'"
                />
                <orders
                    v-else-if="active_block==='orders'"
                />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import Login from "../components/Login";
    import Register from "../components/Register";
    import Orders from "../components/Orders"
    import isAdmin from "../mixins/isAdmin";
    import isLogged from "../mixins/isLogged";

    export default {
        name: "Account",
        components: {
            Login,
            Register,
            Orders,
        },
        mixins: [
            isAdmin,
            isLogged,
        ],
        data() {
            return {
                active_block: 'login'
            }
        },
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

    .v-list-item__content:hover {
        cursor: pointer;
    }


</style>
