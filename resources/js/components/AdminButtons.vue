<template>
    <v-col cols="12">
        <button-with-dialog
            v-if="add"
            mdi_icon="mdi-plus"
            small
            header_text="Добавить"
        >
            <slot name="add"/>
        </button-with-dialog>
        <button-with-dialog
            v-if="edit"
            mdi_icon="mdi-pencil"
            x_small
            header_text="Редактировать"
        >
            <slot name="edit"/>
        </button-with-dialog>
        <v-btn
            v-if="remove"
            title="Удалить"
            icon
            x-small
            color="error"
            @click.exact="$emit('click_remove')"
        >
            <v-icon
                color="white"
            >
                mdi-close
            </v-icon>
        </v-btn>
    </v-col>

</template>

<script>
    import ButtonWithDialog from "./ButtonWithDialog";
    export default {
        name: "AdminButtons",
        components:{
            ButtonWithDialog,
        },
        props:{
            add:{
                type: Boolean,
                default: false,
            },
            edit:{
                type:Boolean,
                default: false,
            },
            remove:{
                type: Boolean,
                default: false,
            },
        },
    }
</script>

<style scoped>
    .col{
        padding: 0;
        margin: 0;
    }
</style>
