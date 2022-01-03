<template>
    <v-app id="main">

        <app-header />
        <navbar ref="navbar"></navbar>
        <v-main>
            <router-view></router-view>
        </v-main>

<!--        <app-footer></app-footer>-->
    </v-app>

</template>

<script>
    import Navbar from './Navbar'
    import Header from './Header'
    import Footer from './Footer'

    export default {
        name: 'App',
        components: {
            'navbar': Navbar,
            'app-header': Header,
            'app-footer': Footer
        },

        async mounted() {
            document.title = 'h2o-mebel';
            await this.$store.dispatch('getCategories');
            await this.$store.dispatch('getBrands');
        },
    }
</script>
<style>
    #main {
        background: #282828 url(../../../public/images/body-bkg.jpg) no-repeat scroll top center;
        position: relative;
    }
    .v-main {
        padding: 0 !important;
        margin: 0;
    }

    @font-face {
        font-family: 'Denistina';
        src: url(/fonts/denistina_en.ttf);
    }

    a, p, h1, h2, h3, i, .v-list-item__title, strong, span {
        color: white !important;
    }

    a {
        text-decoration: none !important;
    }

    .v-list {
        background: #282828 !important;
    }

    .header_block {
        display: flex;
        align-items: center;
    }

    a:hover, p:hover, h1:hover, h2:hover, i:hover {
        color: #a9a9a9 !important;
        cursor: pointer;
    }
    .thin_container {
        padding: 0;
        width: 1200px;
    }
    .row, .col{
        padding: 12px 0;
        margin: 0;
    }
    .right {
        justify-content: right;
        display: flex;
        align-items: center;
    }

    li {
        list-style-type: none !important;
        margin-bottom: 12px;
    }

    ul{
        margin-left: 0;
        padding-left: 0 !important;
    }
</style>
