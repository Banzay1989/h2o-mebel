import Homepage from '../pages/Homepage.vue'
import About from '../pages/About.vue'
import Contact from '../pages/Contact.vue'
import Category from "../pages/Category";
import Product from "../pages/Product";
import Brand from "../pages/Brand";
import Empty from "../pages/Empty";

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
            path: '*',
            component: Empty,
        },
    ]
}
