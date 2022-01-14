export default {
  methods: {
    isLogged() {
      return localStorage.getItem('is_logged') === 'true';
    },
  },
};
