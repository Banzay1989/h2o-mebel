import actualDate from "./actualDate";

export default {
  methods: {

    /**
     * @description Приводим дату к формату 'DD.MM.YYYY'
     *
     * @example 01.01.2020
     *
     * @param {string} date
     * @return {string}
     */
    normalDate(date) {
        return date !== '' ? new Date(date.substr(0,10)).toLocaleDateString() : 'Не удалось определить дату';
    },
  },
};
