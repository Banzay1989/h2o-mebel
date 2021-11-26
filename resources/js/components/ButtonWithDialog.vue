<template>
  <v-dialog
    v-model="dialog"
    :fullscreen="fullscreen"
    :width="width"
    persistent
  >
    <template v-slot:activator="{ on }">
      <v-btn
        :disabled="disabled"
        :icon="icon"
        :title="title"
        v-on="on"
      >
        <v-icon v-if="icon">
          {{ mdi_icon }}
        </v-icon>
        <span v-else>
          {{ button_text }}
        </span>
      </v-btn>
    </template>
    <v-card
      @close-dialog="close(listen_close_event)"
    >
      <v-card-title>
        <h2>
          {{ header_text }}
        </h2>
        <v-spacer />
        <v-btn
          icon
          color="error"
          @click="close"
        >
          <v-icon large>
            mdi-close
          </v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <slot>
          Body
        </slot>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>

  /**
   * Компонент - "Кнопка с диалоговым окном"
   */
  export default {
    name: 'ButtonWithDialog',
    props: {
      //Ширина окна
      width: {
        type: Number,
        default: 1500,
      },

      //Развернуть окно на весь экран (игнорирует параметр ширины окна)
      fullscreen: {
        type: Boolean,
        default: false,
      },

      //Название иконки для кнопки (игнорирует параметр текста кнопки)
      mdi_icon: {
        type: String,
        default: '',
      },

      //Название кнопки
      button_text: {
        type: String,
        default: 'BUTTON',
      },

      //Название кнопки
      title: {
        type: String,
        default: '',
      },

      //Название окна в шапке
      header_text: {
        type: String,
        default: '',
      },

      //Закрывать окно при сигнале из встроенного компонента
      listen_close_event: {
        type: Boolean,
        default: false,
      },
      //деактивация кнопки
      disabled: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        dialog: false,
      };
    },
    computed: {
      icon() {
        return this.mdi_icon !== '';
      },
    },
    methods: {

      /**
       * @description Закрыть диалоговое окно
       * Если хотите закрывать диалоговое окно из формы, то необходимо генерировать событие this.$parent.$emit('close-dialog');
       * @param {boolean} listen_close_event
       * @return {Object} this (VueComponent)
       */
      close(listen_close_event = true) {
        if (listen_close_event) {
          this.dialog = false;
        }

        return this;
      },

    },
  };
</script>
<style scoped>
    button{
        margin-bottom: 12px;
    }
</style>
