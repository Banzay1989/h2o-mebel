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
                    md="8"
                >
                    <v-autocomplete
                        dark
                        v-model="editable_menu.category_id"
                        :items="categories"
                        label="Категория"
                        item-value="id"
                        item-text="name"
                        :rules="nameRules"
                    />
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        dark
                        v-model="editable_menu.priority"
                        type="number"
                        label="Приоритет"
                    />
                </v-col>
            </v-row>
        </v-form>
        <v-row>
            <v-spacer />
            <v-btn
                v-if="editable_menu.id === null"
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
     * Компонент - "Редактор меню"
     */
    export default {
        name: 'MenuEditor',
        props: {
            value: {
                type: Object,
                default: () => {
                },
            },
        },
        data() {
            return {
                editable_menu: this.copyValue(),
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

        methods: {
            /**
             * @description в редактируемый объект вернет копию переданного, либо объект с пустыми полями
             * @return {{name: string, description: string, completion_date: string, id: ?number, status: string}|any}
             */
            copyValue() {
                return this.value === undefined || JSON.stringify(this.value) === '{}' ? this.clearOrder() : JSON.parse(JSON.stringify(this.value));
            },

            /**
             * @description вернет объект с пустыми полями
             * @return {{name: string, description: string, completion_date: string, id: null, status: string}}
             */
            clearOrder() {
                return {
                    id: null,
                    category_id: null,
                    priority: 1,
                }
            },

            /**
             * @description сохранение нового пункта меню
             * @return {Promise<void>}
             */
            async save() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('newMenuItem', this.editable_menu);
                }
            },

            /**
             * @description изменение пункта меню
             * @return {Promise<void>}
             */
            async update() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('updateMenuItem', {menu_object: this.editable_menu});
                }
            },
        },
    };
</script>
<style scoped>
</style>
