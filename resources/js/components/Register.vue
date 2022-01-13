<template>
    <v-card
        dark
        flat
        class="card"
    >
        <v-card-title>
            <h2>Регистрация</h2>
        </v-card-title>
        <v-card-text>
            <v-row>
                <v-col
                    cols="8"
                    class="col pa-0"
                >
                    <v-text-field
                        v-model="name"
                        label="Имя"
                        :rules="[rules.required]"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    cols="8"
                    class="col pa-0"
                >
                    <v-text-field
                        v-model="email"
                        label="E-mail"
                        :rules="[rules.required]"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    cols="8"
                    class="col pa-0"
                >
                    <v-text-field
                        v-model="password"
                        label="Пароль"
                        :rules="[rules.required, rules.min]"
                        :append-icon="!is_shown ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="is_shown ? 'text' : 'password'"
                        hint="Не менее 8 символов"
                        counter
                        @click:append="is_shown = !is_shown"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    cols="8"
                    class="col pa-0"
                >
                    <v-text-field
                        v-model="re_password"
                        label="Подтвердите пароль"
                        :rules="[rules.required, rules.min]"
                        :append-icon="!re_is_shown ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="re_is_shown ? 'text' : 'password'"
                        hint="Не менее 8 символов"
                        counter
                        @click:append="is_shown = !is_shown"
                    />
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn
                @click="register"
            >
                Зарегистрироваться
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: 'Register',
        data() {
            return {
                name: '',
                email: '',
                password: '',
                re_password: '',
                is_shown: false,
                re_is_shown: false,
                rules: {
                    required: value => !!value || 'Обязательное.',
                    min: v => v.length >= 8 || 'Минимум 8 символов',
                },
            }
        },

        methods: {
            register() {
                if (this.password === this.re_password){
                    axios.post('api/auth/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.re_password,
                    }).then(() => {
                        this.$emit('registred');
                    }).catch(error => {
                        alert('Не удалось зарегистрироваться');
                    });
                } else {
                    alert('Пароли не совпадают');
                }

            },
        }
    }
</script>
<style scoped>
    .card {
        max-width: 1200px;
        margin: auto;
    }
</style>
