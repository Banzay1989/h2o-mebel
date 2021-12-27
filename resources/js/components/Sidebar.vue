<template>
    <v-col cols="12">
        <h1 class="my-4">Категории</h1>
        <admin-buttons
            add>

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
                hoverable
                item-key="uid"
                :items="categories"
            >
                <template v-slot:append="{item}">
                    <admin-buttons
                        edit
                        remove
                    />
                </template>
            </v-treeview>
        </v-card>
    </v-col>
</template>
<script>
    import AdminButtons from "./AdminButtons";

    export default {
        name: "Sidebar",
        components: {
            AdminButtons,
        },
        data() {
            return {
                active: [],
            }
        },
        computed: {
            categories() {
                return this.$store.getters.getCategories;
            }
        },
        mounted() {
            console.log(this.$route.params.slug);

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

</style>
