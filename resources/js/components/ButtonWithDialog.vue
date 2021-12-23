<template>
    <v-dialog
        v-model="dialog"
        :fullscreen="fullscreen"
        :width="width"
        persistent
    >
        <template v-slot:activator="{ on }">
            <v-btn
                :disabled="disabled"
                :title="title"
                :small="small"
                :x-small="x_small"
                text
                fab
                :color="button_color"
                v-on="on"
            >
                <v-icon v-if="icon">
                    {{ mdi_icon }}
                </v-icon>
                <span v-else>
                  {{ button_text }}
                </span>
            </v-btn>
        </template>
        <v-card
          color="#282828"
        >
            <v-card-title>
                <h2>
                    {{ header_text }}
                </h2>
                <v-spacer />
                <v-btn
                    icon
                    color="error"
                    @click="close"
                >
                    <v-icon small
                      color="white"
                    >
                        mdi-close
                    </v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <slot>
                    Body
                </slot>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>

    /**
     * Компонент - "Кнопка с диалоговым окном"
     */
    export default {
        name: 'ButtonWithDialog',
        props: {
            //Ширина окна
            width: {
                type: Number,
                default: 1500,
            },

            //Развернуть окно на весь экран (игнорирует параметр ширины окна)
            fullscreen: {
                type: Boolean,
                default: false,
            },

            //Название иконки для кнопки (игнорирует параметр текста кнопки)
            mdi_icon: {
                type: String,
                default: '',
            },

            //Название кнопки
            button_text: {
                type: String,
                default: 'BUTTON',
            },

            //Подсказка на кнопке
            title: {
                type: String,
                default: '',
            },

            //Цвет кнопки
            button_color: {
                type: String,
                default: 'white'
            },

            //Название окна в шапке
            header_text: {
                type: String,
                default: '',
            },

            //Закрывать окно при сигнале из встроенного компонента
            listen_close_event: {
                type: Boolean,
                default: false,
            },
            //деактивация кнопки
            disabled: {
                type: Boolean,
                default: false,
            },
            small:{
                type: Boolean,
                default: false,
            },

            x_small:{
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                dialog: false,
            };
        },
        computed: {
            icon() {
                return this.mdi_icon !== '';
            },
        },
        methods: {

            /**
             * @description Закрыть диалоговое окно
             */
            close() {
                this.dialog = false;
            },

        },
    };
</script>
<style scoped>
    button {
        width: 24px !important;
        height: 24px !important;
    }
</style>
