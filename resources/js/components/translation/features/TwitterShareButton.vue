<!-- TwitterShareButton.vue -->
<template>
  <i
    style="color: rgb(0, 191, 166); cursor: pointer"
    @click="shareHeadingOnTwitter"
    class="mr-2 bi bi-twitter-x text-right h4"
    aria-expanded="false"
    data-bs-placement="top"
    title="Share via X"
  ></i>
</template>

<script>
export default {
  name: 'TwitterShareButton',
  props: {
    textContent: {
      type: String,
      required: true
    }
  },
  methods: {
    shareHeadingOnTwitter() {
      try {
        const encodedHeading = encodeURIComponent(this.textContent);
        const twitterUrl = `https://twitter.com/intent/tweet?text=${encodedHeading}`;
        window.open(twitterUrl, "_blank") || console.error("Failed to open Twitter sharing dialog.");
      } catch (error) {
        console.error("Error:", error);
      }
    }
  }
};
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
