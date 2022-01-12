import Vue from 'vue';
import Vuex from 'vuex';
import orders from './modules/orders'
import menu from './modules/menu'
import categories from './modules/categories'
import products from './modules/products'
import brands from "./modules/brands";
import role from "./modules/role";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        orders,
        menu,
        categories,
        products,
        brands,
        role,
    }
});
