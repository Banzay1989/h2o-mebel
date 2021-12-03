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
                    <v-text-field
                        v-model="editable_order.name"
                        type="text"
                        label="Название заказа"
                        :rules="nameRules"
                    />
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-text-field
                        v-model="editable_order.completion_date"
                        type="date"
                        label="Дата завершения заказа"
                        :min="actualDate()"
                    />
                </v-col>
                <v-col
                    cols="12"
                    md="4"
                >
                    <v-autocomplete
                        v-model="editable_order.status"
                        :items="statuses"
                        label="Статус"
                        :rules="nameRules"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-tooltip top>
                        <template v-slot:activator="{ on }">
                            <v-textarea
                                v-model="editable_order.description"
                                label="Описание"
                                :rules="nameRules"
                                v-on="on"
                            />
                        </template>
                        <p v-if="editable_order.description !== ''">
                            <span v-html="editable_order.description" />
                        </p>
                    </v-tooltip>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">

                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-file-input
                        v-model="editable_order.files"
                        show-size
                        counter
                        multiple
                        label="Файлы"
                    />
                </v-col>
            </v-row>
        </v-form>
        <v-row>
            <v-spacer />
            <v-btn
                v-if="editable_order.id === null"
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
    import actualDate from "../mixins/actualDate";

    /**
     * Компонент - "Редактор заказа"
     */
    export default {
        name: 'OrderEditor',
        mixins: [
            actualDate,
        ],
        props: {
            value: {
                type: Object,
                default: () => {
                },
            },
        },
        data() {
            return {
                editable_order: this.copyValue(),
                valid: true,
                nameRules: [
                    v => !!v || 'Поле обязательно для заполнения',
                ],
            };
        },
        computed: {
            statuses() {
                return this.$store.getters.getAllOrderConst.statuses ?? [];
            },
        },
        mounted() {
            this.$store.dispatch('getOrderConst');
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
                    name: '',
                    description: '',
                    completion_date: this.actualDate(),
                    status: '',
                    files: [],
                }
            },

            /**
             * @description сохранение нового заказа
             * @return {Promise<void>}
             */
            async save() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('newOrder', this.createFormData(this.editable_order));
                }
            },

            /**
             * @description изменение заказа
             * @return {Promise<void>}
             */
            async update() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('updateOrder', {id: this.editable_order.id, order_object: this.createFormData(this.editable_order)});
                }
            },

            createFormData(order_object) {
                let formData = new FormData();
                Object.keys(order_object).forEach(key => {
                    if (key !== 'files') {
                        formData.append(key, order_object[key]);
                    }
                });
                if (order_object.files.length){
                    this.uploadFiles(formData, order_object.files);
                }
                return formData;
            },

            uploadFiles(formData, files) {
                files.forEach(value => {
                    if (value.id === undefined) {
                        formData.append('files[]', value);
                    } else {
                        formData.append('old_files[]', value.id);
                    }
                });
            },

        },
    };
</script>
<style scoped>
</style>
