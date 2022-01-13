export default {
    actions: {
       addToCart(ctx, params = {}){
           console.log(params);
            ctx.commit('addToCart', params);
       }

    },
    mutations: {
        addToCart(state, params){
            state.products.push(params);
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
