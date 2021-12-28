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
                    md="4"
                >
                    <v-autocomplete
                        dark
                        v-model="editable_category.parent_id"
                        :items="categories"
                        label="Категория"
                        item-value="id"
                        item-text="name"
                    />
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        dark
                        v-model="editable_category.name"
                        label="Наименование"
                        :rules="nameRules"
                    />
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        dark
                        v-model="editable_category.slug"
                        label="URL-префикс"
                        readonly
                    />
                </v-col>
                </v-row>
            <v-row>
                <v-col
                    cols="12"
                >
                    <v-textarea
                        dark
                        v-model="editable_category.description"
                        label="Описание"
                        :rules="nameRules"
                    />
                </v-col>
            </v-row>
        </v-form>
        <v-row>
            <v-spacer />
            <v-btn
                v-if="editable_category.id === null"
                color="green"
                text
                @click="save"
            >
                Сохранить
            </v-btn>
            <v-btn
                v-else
                color="warning"
                text
                @click="update"
            >
                Изменить
            </v-btn>
        </v-row>
    </v-container>
</template>

<script>

    /**
     * Компонент - "Редактор Категорий"
     */
    export default {
        name: 'CategoryEditor',
        props: {
            value: {
                type: Object,
                default: () => {
                },
            },
        },
        data() {
            return {
                editable_category: this.copyValue(),
                valid: true,
                nameRules: [
                    v => !!v || 'Поле обязательно для заполнения',
                ],
            };
        },
        computed: {
            categories() {
                return this.$store.getters.getFlatCategories;
            },
        },
        watch: {
            'editable_category.name': function (name) {
                    this.editable_category.slug = this.translit(name.toLowerCase());
            },
        },

        methods: {
            /**
             * @description в редактируемый объект вернет копию переданного, либо объект с пустыми полями
             * @return {{name: string, description: string, completion_date: string, id: ?number, status: string}|any}
             */
            copyValue() {
                return this.value === undefined || JSON.stringify(this.value) === '{}' ? this.clearCategory() : JSON.parse(JSON.stringify(this.value));
            },

            /**
             * @description вернет объект с пустыми полями
             * @return {{name: string, description: string, completion_date: string, id: null, status: string}}
             */
            clearCategory() {
                return {
                    id: null,
                    parent_id: null,
                    name: '',
                    slug: '',
                    description: '',
                }
            },

            /**
             * @description сохранение новой категории
             * @return {Promise<void>}
             */
            async save() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('newCategoryItem', this.editable_category);
                }
            },

            /**
             * @description изменение категории
             * @return {Promise<void>}
             */
            async update() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('updateCategoryItem', {category_object: this.editable_category});
                }
            },

            translit(text){
                return text
                    .replace(/\u042A/g, '')
                    .replace(/\u0451/g, 'yo')
                    .replace(/\u0439/g, 'i')
                    .replace(/\u0446/g, 'ts')
                    .replace(/\u0443/g, 'u')
                    .replace(/\u043A/g, 'k')
                    .replace(/\u0435/g, 'e')
                    .replace(/\u043D/g, 'n')
                    .replace(/\u0433/g, 'g')
                    .replace(/\u0448/g, 'sh')
                    .replace(/\u0449/g, 'sch')
                    .replace(/\u0437/g, 'z')
                    .replace(/\u0445/g, 'h')
                    .replace(/\u044A/g, "'")
                    .replace(/\u0444/g, 'f')
                    .replace(/\u044B/g, 'i')
                    .replace(/\u0432/g, 'v')
                    .replace(/\u0430/g, 'a')
                    .replace(/\u043F/g, 'p')
                    .replace(/\u0440/g, 'r')
                    .replace(/\u043E/g, 'o')
                    .replace(/\u043B/g, 'l')
                    .replace(/\u0434/g, 'd')
                    .replace(/\u0436/g, 'zh')
                    .replace(/\u044D/g, 'e')
                    .replace(/\u042C/g, "'")
                    .replace(/\u044F/g, 'ya')
                    .replace(/\u0447/g, 'ch')
                    .replace(/\u0441/g, 's')
                    .replace(/\u043C/g, 'm')
                    .replace(/\u0438/g, 'i')
                    .replace(/\u0442/g, 't')
                    .replace(/\u044C/g, "'")
                    .replace(/\u0431/g, 'b')
                    .replace(/\u0020/g, '_')
                    .replace(/\u044E/g, 'yu');
            }
        },
    };
</script>
<style scoped>
</style>
