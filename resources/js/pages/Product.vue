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
                <v-file-input
                    v-model="new_files"
                    dark
                    counter
                    multiple
                    show-size
                    small-chips
                />
            </v-col>
            <v-col
                cols="12"
                md="7"
                class="col"
            >
                <v-form
                    ref="product_form"
                    v-model="product_valid"
                    lazy-validation
                >
                    <h3>{{ title }}</h3>
                    <v-text-field
                        dark
                        label="Наименование"
                        v-model="product.name"
                    />
                    <ul>
                        <li>
                            <strong>Бренд: </strong><a :href="brand_src">{{ brand_name }}</a>
                            <v-autocomplete
                                dark
                                label="Бренд"
                                :items="brands"
                                v-model="product.brand_id"
                                item-text="name"
                                item-value="id"
                            />
                            <v-autocomplete
                                dark
                                label="Категория"
                                :items="categories"
                                v-model="product.category_id"
                                item-text="name"
                                item-value="id"
                            />
                        </li>
                        <li>
                            <strong>Артикул: </strong> <span>{{ article }}</span>
                            <v-text-field
                                dark
                                label="Артикул"
                                v-model="product.article"
                            />
                        </li>
                        <li>
                            <strong>Доступность: </strong> <span>{{ in_stock }}</span>
                            <v-checkbox
                                dark
                                label="В продаже"
                                v-model="is_aviable"
                            />
                        </li>
                    </ul>
                    <br>
                    <strong>₽ {{ price }}</strong>
                    <v-text-field
                        dark
                        v-model="product.price"
                        type="number"
                        min="1"
                    />
                </v-form>
                <v-row class="bye">
                    <v-text-field
                        dark
                        class="page_selector"
                        v-model="quatity"
                        type="number"
                        min="1"
                    >
                        <template v-slot:prepend>
                            <span>Колич: </span>
                        </template>
                    </v-text-field>
                    <v-btn
                        dark
                        @click="save()"
                    >
                        Сохранить
                    </v-btn>
                </v-row>
            </v-col>
        </v-row>
        <v-row class="description_specification">
            <v-col cols="4" class="col">
                <p>Описание</p>
                <p>-</p>
                <p>Параметры</p>
                <!--                <p>-</p>-->
                <!--                <p>Специальные</p>-->
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
                quatity: 1,
                is_aviable: true,
                product_valid: true,
                new_files: [],
            }
        },
        computed: {
            image_src() {
                return '/'+this.product?.files?.[0];
            },
            title() {
                return this.product?.name;
            },
            article() {
                return this.product?.article;
            },
            brand_src() {
                return '/brand/' + this.product?.brand_id;
            },
            brand_name() {
                return this.product?.brand?.name;
            },
            price() {
                return this.product?.price ?? 0;
            },
            brands() {
                return this.$store.getters.getBrands;
            },
            categories() {
                return this.$store.getters.getFlatCategories;
            },
            in_stock() {
                return this.product?.deleted_at ? 'Не продаётся' : 'В продаже';
            },
        },

        watch: {
            is_aviable(val) {
                this.product.deleted_at = val ? null : moment();
            }
        },

        async mounted() {
            await this.getProduct();
        },

        methods: {
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
                    new_files: [],
                }
            },


            async getProduct() {
                await axios.get(`/api/products/${this.$route.params.id}`).then(response => {
                    this.product = response.data.product;
                    this.is_aviable = !this.product?.deleted_at;
                }).catch(errors => console.log(errors));
            },

            async save() {
                if (this.$refs.product_form.validate()) {
                    if (this.product.id) {
                        await this.$store.dispatch('updateProduct', {id:this.product.id, product_object: this.createFormData(this.product)});
                    } else {
                        this.store();
                    }
                }
            },

            createFormData(product_object) {
                let formData = new FormData();
                Object.keys(product_object).forEach(key => {
                    // if (key !== 'files') {
                        formData.append(key, product_object[key]);
                    // }
                });
                if (this.new_files.length){
                    this.uploadFiles(formData, this.new_files);
                }
                return formData;
            },

            uploadFiles(formData, files) {
                files.forEach(value => {
                    if (value.id === undefined) {
                        formData.append('new_files[]', value);
                    }
                    // else {
                    //     formData.append('old_files[]', value.id);
                    // }
                });
            },

            async update() {
                await axios.post(`/api/products/${this.product}`, this.product).then(response => {
                    this.product = response.data.product;
                }).catch(errors => console.log(errors));
            },

            async store() {
                await axios.post(`/api/products/`, this.product).then(response => {
                    this.product = response.data.product;
                }).catch(errors => console.log(errors));
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

    .bye {
        align-items: baseline;
    }
</style>
