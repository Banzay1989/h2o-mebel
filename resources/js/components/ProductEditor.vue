<template>
    <v-container fluid>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
        >
            <v-row>
                <v-col
                    cols="12"
                    md="3"
                >
                    <v-row wrap>
                        <v-col
                            v-for="(image,i) in editable_product.files"
                            :key="i"
                            cols="3"
                        >
                            <v-img
                                class="image"
                                :src="image"
                                :aspect-ratio="1"
                                height="100"
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
                                            height="100"
                                        />
                                    </v-row>
                                </template>
                            </v-img>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-file-input
                            v-model="new_files"
                            dark
                            counter
                            multiple
                            show-size
                            small-chips
                            accept="image/*"
                        />
                    </v-row>
                </v-col>
                <v-col
                    cols="12"
                    md="9"
                >
                    <v-row>
                        <v-col
                            cols="12"
                            md="3"
                        >
                            <v-text-field
                                dark
                                label="Наименование"
                                v-model="editable_product.name"
                                :rules="nameRules"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            md="3"
                        >
                            <v-text-field
                                dark
                                label="Артикул"
                                v-model="editable_product.article"
                                :rules="nameRules"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            md="3"
                        >
                            <v-autocomplete
                                dark
                                label="Бренд"
                                :items="brands"
                                v-model="editable_product.brand_id"
                                item-text="name"
                                item-value="id"
                                :rules="nameRules"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            md="3"
                        >
                            <v-autocomplete
                                dark
                                label="Категория"
                                :items="categories"
                                v-model="editable_product.category_id"
                                item-text="name"
                                item-value="id"
                                :rules="nameRules"
                            />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col
                            cols="12"
                            md="2"
                        >
                            <v-text-field
                                dark
                                v-model="editable_product.price"
                                label="Стоимость"
                                type="number"
                                min="1"
                                :rules="nameRules"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            md="2"
                        >
                            <v-checkbox
                                dark
                                label="В продаже"
                                v-model="is_aviable"
                            />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-textarea
                                dark
                                label="Описание"
                                v-model="editable_product.description"
                                :rules="nameRules"
                            />
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>

        </v-form>
        <v-row>
            <v-spacer />
            <v-btn
                v-if="editable_product.id === null"
                color="green"
                @click="save"
            >
                Сохранить
            </v-btn>
            <v-btn
                v-else
                color="warning"
                @click="update"
            >
                Изменить
            </v-btn>
        </v-row>
    </v-container>
</template>

<script>

    /**
     * Компонент - "Редактор Продукта"
     */
    export default {
        name: 'ProductEditor',
        props: {
            value: {
                type: Object,
                default: () => {
                },
            },
        },
        data() {
            return {
                editable_product: this.copyValue(),
                valid: true,
                nameRules: [
                    v => !!v || 'Поле обязательно для заполнения',
                ],
                is_aviable: true,
                new_files: [],
            };
        },
        computed: {
            brands() {
                return this.$store.getters.getBrands;
            },
            categories() {
                return this.$store.getters.getFlatCategories;
            },
        },

        watch: {
            is_aviable(val) {
                if (!val && this.editable_product.id) {
                    this.$store.dispatch('deleteProduct', this.editable_product);
                }

            }
        },
        mounted() {
        },

        methods: {
            /**
             * @description в редактируемый объект вернет копию переданного, либо объект с пустыми полями
             * @return {Object}
             */
            copyValue() {
                return this.value === undefined || JSON.stringify(this.value) === '{}' ? this.clearProduct() : JSON.parse(JSON.stringify(this.value));
            },

            /**
             * @description вернет объект с пустыми полями
             * @return {Object}
             */
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
                }
            },

            /**
             * @description сохранение нового заказа
             * @return {Promise<void>}
             */
            async save() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('newProduct', this.createFormData(this.editable_product));
                }
            },

            /**
             * @description изменение заказа
             * @return {Promise<void>}
             */
            async update() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('updateProduct', {
                        id: this.editable_product.id,
                        product_object: this.createFormData(this.editable_product)
                    });
                }
            },

            createFormData(product_object) {
                let formData = new FormData();
                Object.keys(product_object).forEach(key => {
                    // if (key !== 'files') {
                    formData.append(key, product_object[key]);
                    // }
                });
                if (this.new_files.length) {
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

        },
    };
</script>
<style scoped>
</style>
