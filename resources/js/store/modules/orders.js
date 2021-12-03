export default {
    actions: {
        /**
         * @description запрос на получение данных о Заказах
         * @param ctx
         * @param params
         * @return {Promise<void>}
         */
        async getOrders(ctx, params = {}) {
            await axios.get(`/api/orders`, {
                params: params
            }).then(response => {
                ctx.commit('updateAllOrders', response.data.orders);
            });
        },

        /**
         * @description запрос на получение данных о константах Заказа
         * @param ctx
         * @return {Promise<void>}
         */
        async getOrderConst(ctx) {
            await axios.get('/api/orders/const').then(response => {
                ctx.commit('updateAllOrderConst', response.data.order_const)
            });
        },

        /**
         * @description Запрос на редактирование данных Заказа
         * @param ctx
         * @param params
         * @return {Promise<void>}
         */
        async updateOrder(ctx, params) {
            await axios.post(`/api/orders/${params.id}`, params.order_object).then(response => {
                ctx.commit('deleteOrder', response.data.order);
                ctx.commit('newOrder', response.data.order);
            }).catch(errors => console.log(errors));
        },

        /**
         * @description Запрос на создание нового Заказа
         * @param ctx
         * @param order_object
         * @return {Promise<void>}
         */
        async newOrder(ctx, order_object) {
            await axios.post(`/api/orders`, order_object).then(response => {
                ctx.commit('newOrder', response.data.new_order);
            }).catch(errors => console.log(errors));
        },

        /**
         * @description Запрос на удаление Заказа
         * @param ctx
         * @param item
         * @return {Promise<void>}
         */
        async deleteOrder(ctx, item) {
            await axios.delete(`/api/orders/${item.id}`).then(response => {
                ctx.commit('deleteOrder', item);
            }).catch(errors => console.log(errors));
        },

    },
    mutations: {

        /**
         * @description наполнение массива Заказов данными
         * @param state
         * @param orders
         */
        updateAllOrders(state, orders) {
            state.orders = orders;
        },

        /**
         * @description добавление нового заказа к массиву Заказов
         * @param state
         * @param order_object
         */
        newOrder(state, order_object) {
            state.orders.count++;
            state.orders.items.unshift(order_object);
        },

        /**
         * @description удаление заказа из массива Заказов
         * @param state
         * @param item
         */
        deleteOrder(state, item){
            state.orders.count--;
            const deletable_order = state.orders.items.find(order => order.id === item.id);
            if (deletable_order !== undefined){
                const index = state.orders.items.indexOf(deletable_order);
                if (index !== -1){
                    state.orders.items.splice(index, 1);
                }
            }
        },

        /**
         * @description наполнение массива констант Заказов данными
         * @param state
         * @param order_const
         */
        updateAllOrderConst(state, order_const) {
            state.order_const = order_const;
        },
    },
    state: {
        orders: [], //Заказы (items,count)
        order_const: [], //Константы (statuses)
    },
    getters: {
        /**
         * @description получить Заказы
         * @param state
         * @return {Array}
         */
        getAllOrders(state) {
            return state.orders;
        },

        /**
         * @description получить константы
         * @param state
         * @return {Array}
         */
        getAllOrderConst(state) {
            return state.order_const
        },
    },
}
