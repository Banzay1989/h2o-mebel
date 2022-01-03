<template>
    <v-carousel
        dark
        cycle
        height="600"
        hide-delimiter-background
        show-arrows-on-hover
        delimiter-icon="mdi-crop-square"
        class="carousel"
        align="center"
        justify="center"
    >
        <v-carousel-item
            v-for="(banner, i) in banners"
            :key="i"
        >
            <v-img
                class="image"
                :src="banner.src"
                :aspect-ratio="1200/600"
                height="600"
            >
                <template v-slot:placeholder>
                    <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                    >
                        <v-progress-circular
                            indeterminate
                            color="white"
                        ></v-progress-circular>
                    </v-row>
                </template>
            </v-img>
        </v-carousel-item>
    </v-carousel>
</template>

<script>

    export default {
        name: 'BannerTop',
        data() {
            return {
                banners:[
                    {src: '/images/banners/1.jpg'},
                    {src: '/images/banners/2.jpg'},
                    {src: '/images/banners/3.jpg'},
                    // {src: '/images/banners/4.jpg'},
                    // {src: '/images/banners/5.jpg'},
                ],
            }
        },
    }
</script>
<style scoped>
    .carousel{
        max-width: 1200px;
        margin: auto;
    }
</style>
