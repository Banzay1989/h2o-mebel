<template>
    <v-card
        dark
        flat
        class="card"
    >
        <v-card-title>
            <h2>Авторизация</h2>
        </v-card-title>
        <v-card-text
            v-if="!isLogged()"
        >
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
                        :append-icon="!is_shown ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required, rules.min]"
                        :type="is_shown ? 'text' : 'password'"
                        label="Пароль"
                        hint="Не менее 8 символов"
                        counter
                        @click:append="is_shown = !is_shown"
                    />
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn
                v-if="isLogged()"
                @click="logout"
            >
                Выйти
            </v-btn>
            <v-btn
                v-if="!isLogged()"
                @click="login"
            >
                Авторизоваться
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import isLogged from "../mixins/isLogged";

    export default {
        name: 'Login',
        mixins: [
            isLogged,
        ],
        data() {
            return {
                email: '',
                password: '',
                is_shown: false,
                rules: {
                    required: value => !!value || 'Обязательное.',
                    min: v => v.length >= 8 || 'Минимум 8 символов',
                },
            }
        },

        methods: {
            login() {
                axios.post('api/auth/login', {
                    email: this.email,
                    password: this.password,
                }).then(response => {
                    if (response.data.status === 'Success') {
                        localStorage.setItem('is_logged', 'true');
                        localStorage.setItem('token', `Bearer ${response.data.data.token}`);
                        axios.defaults.headers.common.Authorization = `Bearer ${response.data.data.token}`
                        this.$store.dispatch('getRole');
                    }
                }).catch(error => {
                    localStorage.setItem('is_logged', 'false');
                    localStorage.removeItem('token');
                    this.$store.dispatch('logout');
                    axios.defaults.headers.common.Authorization = undefined;
                })
            },

            logout() {
                axios.get('api/auth/logout')
                    .finally(() => {
                        localStorage.setItem('is_logged', 'false');
                        localStorage.removeItem('token');
                        this.$store.dispatch('logout');
                        axios.defaults.headers.common.Authorization = undefined;
                    });
            }
        }
    }
</script>
<style scoped>
    .card {
        max-width: 1200px;
        margin: auto;
    }
</style>
