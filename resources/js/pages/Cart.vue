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
                >
                    <v-card-text>
                        <v-data-table
                            dark
                            hide-default-footer
                            hide-default-header
                            :items="buying_products"
                        >
                            <template v-slot:no-data>
                                Вы еще ничего не заказали
                            </template>
                            <template v-slot:item="{item, index}">
                                <tr>
                                    <td style="width:50px;">
                                        <v-img
                                            v-if="item.product.images.length"
                                            :src="item.product.images[0].url"
                                            :aspect-ratio="1"
                                            height="50"
                                            width="50"
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
                                                    />
                                                </v-row>
                                            </template>
                                        </v-img>
                                    </td>
                                    <td style="width:70%;">
                                        {{ item.product.name }}
                                    </td>
                                    <td>
                                        <v-text-field
                                            dark
                                            v-model="item.quantity"
                                            type="number"
                                            min="1"
                                            @change="$store.dispatch('changeQuantity', {
                                               index: index,
                                               quantity: item.quantity,
                                            })"
                                        />
                                    </td>
                                    <td>
                                        {{item.quantity*item.product.price}} ₽
                                    </td>
                                    <td>
                                        <v-btn
                                            title="Удалить"
                                            icon
                                            x-small
                                            color="error"
                                            @click="$store.dispatch('removeItem', index)"
                                        >
                                            <v-icon
                                                color="white"
                                            >
                                                mdi-close
                                            </v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                        <strong>Итоговая стоимость: {{total_price}}</strong>
                    </v-card-text>
                </v-card>

                <v-btn
                    dark
                    v-if="buying_products.length"
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
                >
                    <v-form
                        ref="credentials"
                        v-model="valid"
                        lazy-validation
                    >
                        <v-text-field
                            v-model="credential.name"
                            :rules="[rules.required, rules.min_10]"
                            label="ФИО"
                            hint="Не менее 10 символов"
                            counter
                            @change="$store.dispatch('changeCredentials', {
                                index: 'name',
                                value: credential.name,
                            })"
                        />
                        <v-text-field
                            v-model="credential.phone"
                            :rules="[rules.required, rules.min_12]"
                            label="Номер телефона"
                            hint="Не менее 10 символов"
                            counter
                            @change="$store.dispatch('changeCredentials', {
                                index: 'phone',
                                value: credential.phone,
                            })"
                        />
                        <v-text-field
                            v-model="credential.email"
                            :rules="[rules.required, rules.email]"
                            label="E-mail"
                            counter
                            @change="$store.dispatch('changeCredentials', {
                                index: 'email',
                                value: credential.email,
                            })"
                        />
                        <v-textarea
                            v-model="credential.address"
                            :rules="[rules.required, rules.min_10]"
                            label="Адрес"
                            hint="Не менее 10 символов"
                            counter
                            @change="$store.dispatch('changeCredentials', {
                                index: 'address',
                                value: credential.address,
                            })"
                        />
                        <v-textarea
                            v-model="credential.comment"
                            label="Комментарий к заказу"
                            @change="$store.dispatch('changeCredentials', {
                                index: 'comment',
                                value: credential.comment,
                            })"
                        />
                    </v-form>
                </v-card>
                <v-btn
                    dark
                    @click="checkAndGo"
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
                    @click="buy()"
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
                valid:true,
                rules: {
                    required: value => !!value || 'Обязательное.',
                    min_10: v => v.length >= 10 || 'Минимум 10 символов',
                    min_12: v => v.length >= 12 || 'Минимум 12 символов',
                    email: v => this.validEmail(this.credential.email) || 'Некорректный email',
                },
            }
        },
        computed: {
            buying_products() {
                return this.$store.getters.getBuyingProducts;
            },

            credential() {
                return this.$store.getters.getCredential;
            },

            total_price() {
                return this.buying_products.reduce((acc,item) => {
                    return acc+=Number(item.quantity)*Number(item.product.price);
                },0);
            }
        },

        methods:{
            validEmail(email) {
                let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },

            checkAndGo(){
                if (this.$refs.credentials.validate()) {
                    this.stepper = 3;
                }
            },

            buy(){
                this.$store.dispatch('newOrder', {
                    products: this.buying_products,
                    credential: this.credential,
                })
            }
        }

    }
</script>
