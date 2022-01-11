<template>
    <v-container
        class="thin_container header_container"
        fluid
    >
        <v-row pa="0" ma="0">
            <v-col
                cols="12"
                md="4"
                class="header_block left"
            >
<!--                Место для соцсетей-->
            </v-col>
            <v-col
                cols="12"
                md="4"
                class="header_block middle"
            >
                <a href="\">
                    <v-img src="/images/gold_logo.png"
                           :aspect-ratio="278/318"
                           width="150"
                    />
<!--                    <h1>H20-mebel</h1>-->
                </a>
            </v-col>
            <v-col
                cols="12"
                md="4"
                class="header_block right"
            >
                <v-icon
                    class="header_icon"
                    color="white"
                >
                    mdi-magnify
                </v-icon>
                <v-icon
                    class="header_icon"
                    color="white"
                    @click="$router.push('/account')"
                >
                    mdi-account-outline
                </v-icon>
                <v-icon
                    class="header_icon"
                    color="white"
                >
                    mdi-cart-outline
                </v-icon>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    export default {
        name: 'Header',
    }
</script>
<style scoped>
    .left p {
        margin-right: 15px;
    }

    .header_container {
        border-bottom: 1px solid #37302e;
    }

    .header_block {
        display: flex;
        align-items: center;
        padding: 12px 0;
    }

    .header_block.left {
        justify-content: left;
    }



    .header_block.middle {
        justify-content: center;

    }

    .middle h1 {
        font-family: 'Denistina';
        font-size: 5em;
    }

    .right .header_icon {
        margin-left: 15px;
    }
</style>
