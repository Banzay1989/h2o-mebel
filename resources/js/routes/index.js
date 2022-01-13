import Homepage from '../pages/Homepage.vue'
import About from '../pages/About.vue'
import Contact from '../pages/Contact.vue'
import Category from "../pages/Category";
import Product from "../pages/Product";
import Brand from "../pages/Brand";
import Account from "../pages/Account";
import Empty from "../pages/Empty";
import Cart from "../pages/Cart"

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Homepage,
        },
        {
            path: '/about',
            name: 'about',
            component: About,
        },
        {
            path: '/contact',
            name: 'contact',
            component: Contact,
        },
        {
            path: '/category/:slug',
            component: Category,
        },
        {
            path: '/product/:id',
            component: Product,
        },
        {
            path: '/brand/:id',
            component: Brand,
        },
        {
            path: '/account',
            component: Account,
        },
        {
            path: '/cart',
            component: Cart,
        },
        {
            path: '*',
            component: Empty,
        },
    ]
}
