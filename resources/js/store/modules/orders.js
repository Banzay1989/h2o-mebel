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
        }
    },
    mutations: {
        updateAllOrders(state, orders) {
            state.orders = orders;
        }
    },
    state: {
        orders: [],
    },
    getters: {
        getAllOrders(state) {
            return state.orders;
        },
    },
}
