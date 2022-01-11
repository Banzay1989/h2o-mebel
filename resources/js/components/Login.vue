<template>
    <v-card
        dark
        flat
        class="card"
    >
        <v-card-title>
            <h2>Авторизация</h2>
        </v-card-title>
        <v-card-text>
            <v-row>
                <v-col
                    cols="8"
                    class="col"
                >
                    <v-text-field
                        v-model="login"
                        label="Логин"
                        :rules="[rules.required]"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    cols="8"
                    class="col"
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
            <v-btn>
                Авторизоваться
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>

    export default {
        name: 'Login',
        data() {
            return {
                login: '',
                password: '',
                is_shown: false,
                rules: {
                    required: value => !!value || 'Обязательное.',
                    min: v => v.length >= 8 || 'Минимум 8 символов',
                },
            }
        },
    }
</script>
<style scoped>
    .card {
        max-width: 1200px;
        margin: auto;
    }
</style>
