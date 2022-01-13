export default {
    actions: {
        /**
         * @description запрос на получение данных о роли пользователя
         * @param ctx
         * @return {Promise<void>}
         */
        async getRole(ctx) {
            await axios.get(`/api/role`).then(response => {
                ctx.commit('getRole', response.data.role);
                localStorage.setItem('is_logged', 'true');
            }).catch(() => {
                ctx.commit('getRole', 'user');
                localStorage.setItem('is_logged', 'false');
            });
        },

        godMode () {
            ctx.commit('godMode');
        },

        logout (ctx) {
            ctx.commit('getRole', 'user');
        }
    },
    mutations: {

        /**
         * @description Определение роли
         * @param state
         * @param {String} role
         */
        getRole(state, role) {
            state.role = role;
        },

        /**
         * @description Включение админа
         */
        godMode(state) {
            state.godmode = !godmode;
        },
    },
    state: {
        role: 'user', //Роль
        godmode: true, //Кнопка
    },
    getters: {
        /**
         * @description получить Роль
         * @param state
         * @return {String}
         */
        getRole(state) {
            return state.role;
        },

    },
}
