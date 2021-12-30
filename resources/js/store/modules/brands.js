export default {
    actions: {
        /**
         * @description запрос на получение данных о брендах
         * @param ctx
         * @return {Promise<void>}
         */
        async getBrands(ctx) {
            await axios.get(`/api/brands`).then(response => {
                ctx.commit('getBrands', response.data.brands);
            });
        },
        // /**
        //  * @description Запрос на редактирование данных категории
        //  * @param ctx
        //  * @param params
        //  * @return {Promise<void>}
        //  */
        // async updateCategoryItem(ctx, params) {
        //     await axios.post(`/api/categories/${params.category_object.id}`, params.category_object).then(response => {
        //         ctx.dispatch('getCategories');
        //     }).catch(errors => console.log(errors));
        // },
        //
        // /**
        //  * @description Запрос на создание новой категории
        //  * @param ctx
        //  * @param category_object
        //  * @return {Promise<void>}
        //  */
        // async newCategoryItem(ctx, category_object) {
        //     if (confirm('Удалятся так же все подкатегории, вы уверены?')){
        //         await axios.post(`/api/categories`, category_object).then(response => {
        //             ctx.dispatch('getCategories');
        //         }).catch(errors => console.log(errors));
        //     }
        // },
        //
        // /**
        //  * @description Запрос на удаление категории
        //  * @param ctx
        //  * @param id
        //  * @return {Promise<void>}
        //  */
        // async deleteCategoryItem(ctx, id) {
        //     await axios.delete(`/api/categories/${id}`).then(response => {
        //         ctx.dispatch('getCategories');
        //     }).catch(errors => console.log(errors));
        // },


    },
    mutations: {

        /**
         * @description наполнение массива Брендов данными
         * @param state
         * @param {Array} brands
         */
        getBrands(state, brands) {
            state.brands = brands;
        },

        // /**
        //  * @description добавление нового заказа к массиву Заказов
        //  * @param state
        //  * @param order_object
        //  */
        // newOrder(state, order_object) {
        //     state.orders.count++;
        //     state.orders.items.unshift(order_object);
        // },
        //
        // /**
        //  * @description удаление заказа из массива Заказов
        //  * @param state
        //  * @param item
        //  */
        // deleteOrder(state, item){
        //     state.orders.count--;
        //     const deletable_order = state.orders.items.find(order => order.id === item.id);
        //     if (deletable_order !== undefined){
        //         const index = state.orders.items.indexOf(deletable_order);
        //         if (index !== -1){
        //             state.orders.items.splice(index, 1);
        //         }
        //     }
        // },
        //
        // /**
        //  * @description наполнение массива констант Заказов данными
        //  * @param state
        //  * @param order_const
        //  */
        // updateAllOrderConst(state, order_const) {
        //     state.order_const = order_const;
        // },
    },
    state: {
        brands: [], //Бренды
    },
    getters: {
        /**
         * @description получить Категории
         * @param state
         * @return {Array}
         */
        getBrands(state) {
            return state.brands;
        },

        // getFlatCategories(state) {
        //     let func = (arr,d) => {
        //         return d > 0 ? arr.reduce((acc, val) => acc.concat(val?.children?.length ? func(val.children, d - 1) : val), arr)
        //             : arr.slice();
        //     };
        //
        //     return func(state.categories, Infinity);
        // },

    },



}
