<template>
  <i @click="copyTextTranslation" class="bi bi-clipboard-check text-right mr-2 h4"
     aria-expanded="false" data-bs-placement="top" title="Copy verse"
     style="color: rgba(0, 191, 166); cursor: pointer"></i>
</template>

<script>
export default {
  name: 'CopyTranslateText',
  props: {
    text: {
      type: String,
      required: true
    }
  },
  methods: {
    copyTextTranslation() {
     if (this.text) {
        // Create a textarea element to copy the text
        var textarea = document.createElement("textarea");
        // Set the value of the textarea to the text to be copied
        textarea.value = this.text;
        // Append the textarea to the document body
        document.body.appendChild(textarea);
        // Select the text within the textarea
        textarea.select();
        // Execute the copy command to copy the selected text
        document.execCommand("copy");
        // Remove the textarea from the document body
        document.body.removeChild(textarea);
        // Log a success message
        console.log("Text copied to clipboard:", this.text);
      } else {
        console.error('No text to copy');
      }
    },
    hideAlertAfterDelay() {
      // Implement hide alert logic if needed after certain time
      setTimeout(() => {
        this.showAlertText = false;
      }, 3000); // Example: Hide alert after 3 seconds
    }
  }
};
</script>

<style scoped>
/* Add specific styles for the component if needed */
</style>
