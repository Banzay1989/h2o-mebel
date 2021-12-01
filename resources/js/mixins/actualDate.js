export default {
  methods: {
    actualDate() {
      return new Date().toISOString().split('T')[0];
    },
  },
};
