export default {
  methods: {
    isAdmin() {
      return this.$store.getters.getRole === 'administrator';
    },
  },
};
