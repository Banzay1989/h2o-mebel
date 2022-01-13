<template>
    <v-container
        class="thin_container"
        fluid
    >
        <v-stepper
            dark
            v-model="stepper"
            vertical
            flat
        >
            <v-stepper-step
                color="black"
                :complete="stepper > 1"
                step="1"
            >
                Заказанные товары
                <small>Проверьте товары и их количество</small>
            </v-stepper-step>

            <v-stepper-content step="1">
                <v-card
                    dark
                    class="mb-12"
                ></v-card>
                <v-btn
                    dark
                    @click="stepper = 2"
                >
                    Продолжить
                </v-btn>
                <v-btn
                    text
                    @click="$router.push('/')"
                >
                    Вернуться к покупкам
                </v-btn>
            </v-stepper-content>

            <v-stepper-step
                color="black"
                :complete="stepper > 2"
                step="2"
            >
                Контактные данные
                <small>Введите данные чтоб менеджер смог с вами связаться</small>
            </v-stepper-step>

            <v-stepper-content step="2">
                <v-card
                    dark
                    class="mb-12"
                ></v-card>
                <v-btn
                    dark
                    @click="stepper = 3"
                >
                    Продолжить
                </v-btn>
                <v-btn text
                       @click="stepper = 1"
                >

                    Назад
                </v-btn>
            </v-stepper-content>

            <v-stepper-step
                color="black"
                :complete="stepper > 3"
                step="3"
            >
                Отправка заказа в работу
            </v-stepper-step>

            <v-stepper-content step="3">
                <v-card
                    dark
                    class="mb-12"
                >
                    <v-card-text>
                        Вы успешно заполнили все поля
                    </v-card-text>
                </v-card>
                <v-btn
                    dark
                    @click=""
                >
                    Оформить заказ
                </v-btn>
                <v-btn
                    text
                    @click="stepper = 2"
                >
                    Назад
                </v-btn>
            </v-stepper-content>
        </v-stepper>
    </v-container>
</template>
<script>
    export default {
        name: "Cart",
        data() {
            return {
                stepper: 1,
            }
        },
        computed: {
            buying_products() {
                return this.$store.getters.getBuyingProducts;
            },

            credential() {
                return this.$store.getters.getCredential;
            },
        }
    }
</script>
