export default {
    actions: {
        /**
         * @description запрос на получение данных о пунктах меню
         * @param ctx
         * @return {Promise<void>}
         */
        async getMenuItems(ctx) {
            await axios.get(`/api/menu`).then(response => {
                ctx.commit('getMenu', response.data.menu_items);
            });
        },

        /**
         * @description Запрос на редактирование данных Меню
         * @param ctx
         * @param params
         * @return {Promise<void>}
         */
        async updateMenuItem(ctx, params) {
            await axios.post(`/api/menu/${params.menu_object.id}`, params.menu_object).then(response => {
                ctx.commit('deleteMenuItem', response.data.new_menu_item.id);
                ctx.commit('newMenuItem', response.data.new_menu_item);
            }).catch(errors => console.log(errors));
        },

        /**
         * @description Запрос на создание нового пункта Меню
         * @param ctx
         * @param menu_object
         * @return {Promise<void>}
         */
        async newMenuItem(ctx, menu_object) {
            await axios.post(`/api/menu`, menu_object).then(response => {
                ctx.commit('newMenuItem', response.data.menu_item);
            }).catch(errors => console.log(errors));
        },

        /**
         * @description Запрос на удаление Пункта Меню
         * @param ctx
         * @param id
         * @return {Promise<void>}
         */
        async deleteMenuItem(ctx, id) {
            await axios.delete(`/api/menu/${id}`).then(response => {
                ctx.commit('deleteMenuItem', id);
            }).catch(errors => console.log(errors));
        },

    },
    mutations: {

        /**
         * @description наполнение массива Заказов данными
         * @param state
         * @param {Array} menu_items
         */
        getMenu(state, menu_items) {
            state.menu_items = menu_items;
        },

        /**
         * @description добавление нового пункта Меню
         * @param state
         * @param menu_object
         */
        newMenuItem(state, menu_object) {
            state.menu_items.unshift(menu_object);
        },

        /**
         * @description удаление пункта Меню
         * @param state
         * @param id
         */
        deleteMenuItem(state, id){
            const deletable_menu_item = state.menu_items.find(item => item.id === id);
            if (deletable_menu_item !== undefined){
                const index = state.menu_items.indexOf(deletable_menu_item);
                if (index !== -1){
                    state.menu_items.splice(index, 1);
                }
            }
        },
    },
    state: {
        menu_items: [], //Элементы меню
    },
    getters: {
        /**
         * @description получить Меню
         * @param state
         * @return {Array}
         */
        getMenu(state) {
            return state.menu_items;
        },
    },
}
