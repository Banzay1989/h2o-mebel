<template>
    <v-container fluid>
        <v-row>
            <v-col cols="10">
                <h1>{{ value.name }}</h1>
                <h4>создан: {{ normalDate(value.created_at) }}</h4>
            </v-col>
            <v-col cols="2">
                <h3>{{ value.status }}</h3>
                <h4>завершить до: {{ normalDate(value.completion_date) }}</h4>
            </v-col>
        </v-row>
        <v-row>
            <p>
                <span v-html="value.description" />
            </p>
        </v-row>
        <v-row>
            <get-files
                v-if="value.files.length"
                :saved_files="value.files"
            ></get-files>
        </v-row>
        <!--            <v-row>-->
        <!--                <v-col cols="12">-->
        <!--                    <v-tooltip top>-->
        <!--                        <template v-slot:activator="{ on }">-->
        <!--                            <v-textarea-->
        <!--                                v-model="editable_order.description"-->
        <!--                                label="Описание"-->
        <!--                                :rules="nameRules"-->
        <!--                                v-on="on"-->
        <!--                            />-->
        <!--                        </template>-->
        <!--                        <p v-if="editable_order.description !== ''">-->
        <!--                            <span v-html="editable_order.description" />-->
        <!--                        </p>-->
        <!--                    </v-tooltip>-->
        <!--                </v-col>-->
        <!--            </v-row>-->
        <!--            <v-row>-->
        <!--                <v-col cols="12">-->

        <!--                </v-col>-->
        <!--            </v-row>-->
        <!--            <v-row>-->
        <!--                <v-col cols="12">-->
        <!--                    <v-file-input-->
        <!--                        v-model="editable_order.files"-->
        <!--                        show-size-->
        <!--                        counter-->
        <!--                        multiple-->
        <!--                        label="Файлы"-->
        <!--                    />-->
        <!--                </v-col>-->
        <!--            </v-row>-->

    </v-container>
</template>

<script>
    import normalDate from "../mixins/normalDate";
    import GetFiles from "./GetFiles";

    /**
     * Компонент - "Редактор заказа"
     */
    export default {
        name: 'OrderReader',
        mixins: [
            normalDate,
        ],
        components: {
            GetFiles,
        },
        props: {
            value: {
                type: Object,
                default: () => {
                },
            },
        },
    };
</script>
<style scoped>
    h1 {
        display: inline-block;
    }
</style>
