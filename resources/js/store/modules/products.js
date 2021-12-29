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
         * @description запрос на получение данных о константах Продукта
         * @param ctx
         * @return {Promise<void>}
         */
        async getOrderConst(ctx) {
            await axios.get('/api/products/const').then(response => {
                ctx.commit('updateAllOrderConst', response.data.product_const)
            });
        },

        /**
         * @description Запрос на редактирование данных Продуктов
         * @param ctx
         * @param params
         * @return {Promise<void>}
         */
        async updateOrder(ctx, params) {
            await axios.post(`/api/products/${params.id}`, params.product_object).then(response => {
                ctx.commit('deleteOrder', response.data.new_product);
                ctx.commit('newOrder', response.data.new_product);
            }).catch(errors => console.log(errors));
        },

        /**
         * @description Запрос на создание нового Продукта
         * @param ctx
         * @param product_object
         * @return {Promise<void>}
         */
        async newProduct(ctx, product_object) {
            await axios.post(`/api/products`, product_object).then(response => {
                ctx.commit('newOrder', response.data.new_product);
            }).catch(errors => console.log(errors));
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

        /**
         * @description добавление нового заказа к массиву Заказов
         * @param state
         * @param product_object
         */
        newOrder(state, product_object) {
            state.products.count++;
            state.products.items.unshift(product_object);
        },

        /**
         * @description удаление заказа из массива Заказов
         * @param state
         * @param item
         */
        deleteOrder(state, item){
            state.products.count--;
            const deletable_product = state.products.items.find(product => product.id === item.id);
            if (deletable_product !== undefined){
                const index = state.products.items.indexOf(deletable_product);
                if (index !== -1){
                    state.products.items.splice(index, 1);
                }
            }
        },

        /**
         * @description наполнение массива констант Заказов данными
         * @param state
         * @param product_const
         */
        updateAllOrderConst(state, product_const) {
            state.product_const = product_const;
        },
    },
    state: {
        products: [], //Заказы (items,count)
        product_const: [], //Константы (statuses)
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

        // /**
        //  * @description получить константы
        //  * @param state
        //  * @return {Array}
        //  */
        // getAllOrderConst(state) {
        //     return state.product_const
        // },
    },
}
