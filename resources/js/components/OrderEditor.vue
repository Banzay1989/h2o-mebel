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
            },

            async save() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('newOrder', this.editable_order);
                    // this.$emit('refresh');
                }
            },

            async update() {
                if (this.$refs.form.validate()) {
                    await this.$store.dispatch('updateOrder', this.editable_order);
                    // this.$emit('refresh');
                }
            },

        },
    };
</script>
<style scoped>
</style>
