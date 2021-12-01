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
                        label="Название заявки"
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
                <v-col>
                    <v-radio-group
                        v-model="option"
                        row
                    >
                        <v-radio
                            label="Text"
                            value="text"
                        ></v-radio>
                        <v-radio
                            label="HTMLText"
                            value="html"
                        ></v-radio>
                    </v-radio-group>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-textarea
                        v-show="option==='text'"
                        v-model="editable_order.description"
                        label="Описание"
                        :rules="nameRules"
                    >
                    </v-textarea>
                    <p v-show="option==='html'">
                        <span v-html="editable_order.description" />
                    </p>
                </v-col>
            </v-row>
        </v-form>
        <v-row>
            <v-spacer/>
            <v-btn
                v-if="editable_order.id === null"
                color="green"
            >
                Сохранить
            </v-btn>
            <v-btn
                v-else
                color="warning"
            >
                Изменить
            </v-btn>
        </v-row>
    </v-container>
</template>

<script>

    /**
     * Компонент - "Редактор заявки"
     */
    import actualDate from "../mixins/actualDate";

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
                option: 'text',
                nameRules: [
                    v => !!v || 'Поле обязательно для заполнения',
                ],
            };
        },
        computed: {
            statuses() {
                return this.$store.getters.getAllOrderConst.statuses;
            },
        },
        // watch:{
        //     value:{
        //         handler(val){
        //
        //         },
        //         deep: true,
        //     },
        // },
        mounted() {
            this.$store.dispatch('getOrderConst');
        },

        methods: {
            copyValue() {
                return this.value === undefined || JSON.stringify(this.value) === '{}' ? this.clearOrder() : JSON.parse(JSON.stringify(this.value));
            },

            clearOrder() {
                return {
                    id: null,
                    name: '',
                    description: '',
                    completion_date: this.actualDate(),
                    status: '',
                }
            }

        },
    };
</script>
<style scoped>
</style>
