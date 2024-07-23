<template>
  <p class="text-left">
    {{ expanded ? text : truncatedText }}
    <template v-if="showMoreLink">
      <a href="#" @click.prevent="toggleExpand">{{ expanded ? 'Show Less' : 'Show More' }}</a>
    </template>
  </p>
</template>

<script>
export default {
  name: 'TruncatedText',
  props: {
    text: {
      type: String,
      required: true
    },
    maxLength: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      expanded: false
    };
  },
  computed: {
    truncatedText() {
      if (!this.text) return '';
      return this.text.length > this.maxLength ? this.text.substring(0, this.maxLength) + '...' : this.text;
    },
    showMoreLink() {
      return this.text.length > this.maxLength;
    }
  },
  methods: {
    toggleExpand() {
      this.expanded = !this.expanded;
    }
  }
};
</script>

<style scoped>
.text-left {
  text-align: left;
}
</style>
