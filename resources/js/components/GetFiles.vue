<template>
    <v-container fluid>
        <v-row>
            <v-col
                md="10"
                sm="10"
                cols="10"
            >
                <ul>
                    <li
                        v-for="file in saved_files"
                        :key="file.id"
                    >

                        <a
                            :href="file.original_url"
                            :type="file.mime_type"
                            target="_blank"
                        >
                            {{ file.file_name }}
                        </a>
                    </li>
                </ul>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

    export default {
        name: 'GetFiles',

        props: {
            saved_files: {
                type: Array,
                default: () => [],
            },
        },
    };
</script>
