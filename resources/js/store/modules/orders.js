export default {
    actions: {
        async getOrders(ctx, params = {}) {
            let orders = [];
            await axios.get(`/api/orders`, {
                params: params
            }).then(response => {
                orders = response.data.orders;
                ctx.commit('updateAllOrders', orders);
            });


        },

        async getOrderConst(ctx) {
            let order_const = [];
            await axios.get('/api/orders/const').then(response => {
                order_const = response.data.order_const;
                ctx.commit('updateAllOrderConst', order_const)
            });


        },

        async updateOrder(ctx, order_object) {
            await axios.put(`/api/orders/${order_object.id}`, {order: order_object}).then(response => {
            }).catch(errors => console.log(errors));
        },

        async newOrder(ctx, order_object) {
            await axios.post(`/api/orders`, {order: order_object}).then(response => {
            }).catch(errors => console.log(errors));
        },

        async deleteOrder(ctx, item) {
            console.log(item);
            await axios.delete(`/api/orders/${item.id}`).then(response => {
            }).catch(errors => console.log(errors));
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
