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
            v-for="(file, file_index) in saved_files"
            :key="file_index"
          >
            <v-icon
              v-if="can_delete"
              color="red"
              small
              @click="deleteFile(file)"
            >
              delete
            </v-icon>
            <a
              download
              @click="downloadFileById(file.id)"
            >
              {{ file.name }}
            </a>
          </li>
        </ul>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  /**
   * Mixins
   */
  import showErrorsAndMessages from 'Mixins/showErrorsAndMessages';
  import downloadFileById from 'Mixins/downloadFileById';

  export default {
    name: 'GetFiles',
    mixins: [
      showErrorsAndMessages,
      downloadFileById,
    ],

    props: { //роут по которому можно получить файлы
      url: {
        type: String,
        default: '',
      },

      can_delete: { //показывает файлы, но не позволяет их удалить
        type: Boolean,
        default: false,
      },

    },
    data() {
      return {
        saved_files: [],
      };
    },
    mounted() {
      if (this.url !== '') {
        this.getFilesFromServer();
      } else {
        this.showErrors(['пустой url']);
      }
    },

    methods: {

      /**
       * @description Загрузить файлы с сервера
       *
       * @return {Object} this (VueComponent)
       */
      async getFilesFromServer() {
        this.saved_files = [];

        Preloader('get_files_preloader').setText('Загрузка прикреплённых файлов').show();
        axios.get(this.url).then(response => {
          this.saved_files = response.data.content.files;
        }).catch(error => {
          this.showErrors(error.response.data.messages, true);
        }).finally(() => Preloader('get_files_preloader').remove());

        return this;
      },

      /**
       * Удалит файл
       *
       * @param {File} file
       * @return {Object} this (VueComponent)
       */
      deleteFile(file) {
        if (confirm('Удалить файл?')) {
          Preloader('delete_files_preloader').setText('Удаление файла...').show();

          axios.delete(this.url, {
            params: {
              file_name: file.name,
            },
          }).then(response => {
            this.showMessagesOnSnackBar(response.data.messages);
            this.getFilesFromServer();
          }).catch(error => {
            this.showErrors(error.response.data.messages, true);
          }).finally(() => Preloader('delete_files_preloader').remove());
        }

        return this;
      },

    },
  };
</script>
