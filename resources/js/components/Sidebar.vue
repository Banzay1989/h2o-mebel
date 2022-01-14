<template>
    <v-col cols="12">
        <h1 class="my-4">Категории</h1>
        <admin-buttons
            v-if="isAdmin()"
            add
        >
            <template v-slot:add>
                <category-editor />
            </template>
        </admin-buttons>
        <v-card
            dark
            elevation="0"
        >
            <v-treeview
                color="white"
                dense
                activatable
                :active.sync="active"
                :open.sync="open"
                hoverable
                item-key="uid"
                :items="categories"
                @update:active=stopActivate();
            >
                <template v-slot:append="{item}"
                    v-if="isAdmin()"
                >
                    <admin-buttons
                        edit
                        remove
                        @click_remove="$store.dispatch('deleteCategoryItem', item.id)"
                    >
                        <template v-slot:edit>
                            <category-editor
                                :value="item"
                            />
                        </template>
                    </admin-buttons>
                </template>
                <template v-slot:label="{ item }">
                    <v-list-item
                        link
                        exact
                        :to="'/category/'+item.slug"
                    >
                        <v-list-item-title>{{ item.name }}</v-list-item-title>
                    </v-list-item>
                </template>
            </v-treeview>
        </v-card>
    </v-col>
</template>
<script>
    import AdminButtons from "./AdminButtons";
    import CategoryEditor from "./CategoryEditor";
    import isAdmin from "../mixins/isAdmin";

    export default {
        name: "Sidebar",
        components: {
            CategoryEditor,
            AdminButtons,
        },
        mixins: [
            isAdmin,
        ],
        data() {
            return {
                active: [],
                open: [],
            }
        },
        computed: {
            categories() {
                return this.$store.getters.getCategories;
            },
            current_uid() {
                let flat_categories = this.$store.getters.getFlatCategories;
                return flat_categories?.length ? this.$store.getters.getFlatCategories.find(cat => cat.slug === this.$route.params.slug).uid : null;
            }
        },

        watch: {
            current_uid(uid) {
                this.active = uid ? [uid] : [];
                let main_cat_id = this.categories.find(cat => cat.children.find(subcat => subcat.uid === uid))?.id;
                if (!_.isNil(main_cat_id)) {
                    this.open.push(main_cat_id);
                }
            }
        },
        methods: {
            stopActivate() {
                this.active = this.current_uid ? [this.current_uid] : [];
            },
        }

    }
</script>
<style scoped>
    h1 {
        border-bottom: 2px solid #555;
        border-top: 2px solid #555;
    }

    .v-card {
        background: transparent;
    }

    .v-list-item--active:before, .v-list-item--active:hover:before, .v-list-item:focus:before, .v-list-item--link:hover:before {
        opacity: 0 !important;
    }
</style>
