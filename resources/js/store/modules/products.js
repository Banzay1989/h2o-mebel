export default {
    actions: {
        /**
         * @description запрос на получение данных о Продуктах
         * @param ctx
         * @param params
         * @return {Promise<void>}
         */
        async getProducts(ctx, params = {}) {
            await axios.get(`/api/products`, {
                params: params
            }).then(response => {
                ctx.commit('updateAllProducts', response.data.products);
            });
        },

        /**
         * @description Запрос на удаление Продукта
         * @param ctx
         * @param item
         * @return {Promise<void>}
         */
        async deleteProduct(ctx, item) {
            await axios.delete(`/api/products/${item.id}`).then(response => {
                ctx.commit('deleteOrder', item);
            }).catch(errors => console.log(errors));
        },

    },
    mutations: {

        /**
         * @description наполнение массива Заказов данными
         * @param state
         * @param products
         */
        updateAllProducts(state, products) {
            state.products = products;
        },

    },
    state: {
        products: [], //Продукты (items,count)
    },
    getters: {
        /**
         * @description получить Заказы
         * @param state
         * @return {Array}
         */
        getAllProducts(state) {
            return state.products;
        },

    },
}
