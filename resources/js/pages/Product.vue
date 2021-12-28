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
                            <v-img src="/images/gold_logo.png"
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
                <h3>{{ title }}</h3>
                <ul>
                    <li><strong>Бренд: </strong><a :href="brand_src">{{ brand_name }}</a></li>
                    <li><strong>Артикул: </strong> Product 21</li>
                    <li><strong>Доступность: </strong> In Stock</li>
                </ul>
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
                product: null,
            }
        },
        computed: {
            image_src() {
                return this.product?.files?.[0]?.src;
            },
            title() {
                return this.product?.name;
            },
            brand_src(){
                return '/brand/'+this.product?.brand_id;
            },
            brand_name(){
                return this.product?.brand?.name;
            }
        },

        watch: {},

        async mounted() {
            await this.getProduct();
        },

        methods: {
            async getProduct() {
                await axios.get(`/api/products/${this.$route.params.id}`).then(response => {
                    this.product = response.data.product;
                }).catch(errors => console.log(errors));
            },

        },
    }
</script>
<style scoped>
    .image_col{
        padding-right: 32px;
    }
    h3{
        color: #a9a9a9;
    }
    h3{
        border-bottom: 1px solid #37302e;
    }
</style>
