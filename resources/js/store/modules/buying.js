export default {
    actions: {
       addToCart(ctx, params = {}){
            ctx.commit('addToCart', params);
       },

        /**
         * @description Запрос на удаление Продукта
         * @param ctx
         * @param {Number} index
         * @return {Promise<void>}
         */
        removeItem(ctx, index) {
            ctx.commit('removeItem', index);
        },

        changeQuantity(ctx, params) {
            ctx.commit('changeQuantity', params);
        },

        changeCredentials(ctx, params) {
            ctx.commit('changeCredentials', params);
        }

    },
    mutations: {
        addToCart(state, params){
            state.products.forEach(product => {
                if (product.product.id === params.product.id){
                    product.quantity+=params.quantity;
                    params = null;
                }
            });
            if (!_.isNil(params)){
                state.products.push(params);
            }

        },

        removeItem(state, index) {
            state.products.splice(index,1);
        },

        changeQuantity(state, params) {
            state.products[params.index].quantity = params.quantity;
        },
        changeCredentials(state, params){
            state.credential[params.index] = params.value;
        }

    },
    state: {
        products: [], //Купленные продукты
        credential: {
            name:'',
            phone:'+7',
            address:'',
            comment:'',
        },
    },
    getters: {
        /**
         * @description получить Заказанные продукты
         * @param state
         * @return {Array}
         */
        getBuyingProducts(state) {
            return state.products;
        },
        /**
         * @description получить Данные для заказа
         * @param state
         * @return {Object}
         */
        getCredential(state) {
            return state.credential;
        },
    },
}
