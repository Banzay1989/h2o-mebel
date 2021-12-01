import {commit} from "lodash/seq";

export default {
    actions: {
        async getOrders(ctx, params= {}) {
            let orders = [];
            let total_orders_count = 0;
            await axios.get(`/api/orders`,{
                params:params
            }).then(response => {
                orders = response.data.orders;
            });

            ctx.commit('updateAllOrders', orders)
        },

        async getOrderConst(ctx) {
            let order_const = [];
            await axios.get('/api/orders/const').then(response => {
                order_const = response.data.order_const;
            });

            ctx.commit('updateAllOrderConst', order_const)
        }
    },
    mutations: {
        updateAllOrders(state, orders) {
            state.orders = orders;
        },

        updateAllOrderConst(state, order_const) {
            state.order_const = order_const;
        },
    },
    state: {
        orders: [],
        order_const: [],
    },
    getters: {
        getAllOrders(state) {
            return state.orders;
        },

        getAllOrderConst(state) {
            return state.order_const
        }
    },
}
