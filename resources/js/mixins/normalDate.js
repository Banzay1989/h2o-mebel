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
        console.log(Date.parse(date.substr(0,10)));
        return date !== '' ? Date.parse(date.substr(0,10)).toISOString().split('T')[0] : actualDate;
    },
  },
};
