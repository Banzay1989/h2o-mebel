export default {
  methods: {
    isAdmin() {
        console.log(this.$store.getters.getRole === 'administrator');
      return this.$store.getters.getRole === 'administrator';
    },
  },
};
