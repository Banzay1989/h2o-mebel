<template>
    <v-navigation-drawer
        class="thin_container top_menu"
        app
    >
        <template v-slot:append>
            <admin-buttons add>
                <template v-slot:add>
                    <menu-editor />
                </template>
            </admin-buttons>
        </template>
        <v-list class="menu">
            <v-list-item
                class="menu_item"
                v-for="item in menu"
                :key="item.id"
            >
                <router-link :to="'/category/'+item.category.slug">
                    <v-menu
                        open-on-hover
                        bottom
                        offset-y
                        color="282828"
                    >
                        <template v-slot:activator="{ on }">
                            <v-list-item-content
                                v-on="on"
                            >
                                <v-list-item-title>
                                    {{ item.category.name }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </template>
                        <v-list
                            v-if="item.category.children.length"
                            class="submenu"
                            dense
                        >
                            <v-list-item
                                class="menu_item"
                                v-for="subitem in item.category.children"
                                :key="subitem.id"
                                link
                                exact
                                :to="'/category/'+subitem.slug"
                            >
                                <v-list-item-title>{{ subitem.name }}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </router-link>
                <div class="extra_buttons">
                    <admin-buttons
                        edit
                        remove
                        @click_remove="$store.dispatch('deleteMenuItem', item.id)"
                    >
                        <template v-slot:edit>
                            <menu-editor
                                :value="item"
                            />
                        </template>
                    </admin-buttons>
                </div>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import ButtonWithDialog from "./ButtonWithDialog";
    import MenuEditor from "./MenuEditor";
    import AdminButtons from "./AdminButtons";

    export default {
        name: 'Navbar',
        components: {
            ButtonWithDialog,
            MenuEditor,
            AdminButtons,
        },
        computed: {
            menu() {
                return this.$store.getters.getMenu;
            },
        },
        async mounted() {
            await this.$store.dispatch('getMenuItems');
        },

        methods:{
            getMenuItem(id){
                return this.menu.find(item => item.id === id);
            },
        }
    }
</script>
<style scoped>
    .menu {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        position: relative;
        align-self: center;
        background: transparent !important;
        padding: 0;
    }

    .top_menu {
        display: flex;
        width: 100% !important;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        position: relative;
        height: auto !important;
        align-self: center;
        background: transparent !important;
    }

    .submenu {
        background: #282828;
    }

    .menu_item {
        padding: 0 5px;
        background: transparent !important;
    }

    .menu_item:hover {
        box-shadow: inset 0 2px white;
    }
    .extra_buttons{
        position: absolute;
        margin: auto;
        top: -5px;
        right: 0px;
        flex-direction: row;
    }
</style>
