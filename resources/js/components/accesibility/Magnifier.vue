<template>
<div class="magnifier-container" @mouseover="moveMagnifier" @mouseleave="hideMagnifier">
 <div class="magnifier" v-if="isMagnifierVisible" :style="magnifierStyle"></div>
</div>
</template>

<script>
export default {
 data() {
  return {
   isMagnifierVisible: false,
   magnifierStyle: {
    top: '0px',
    left: '0px',
    backgroundImage: 'none',
   },
   methods: {
    moveMagnifier(onEvent) {
      const magnifierSize = 100; // Size of the magnifier
      const { clientX, clientY } = event;

      // Position the magnifier
      this.magnifierStyle = {
        top: `${clientY - magnifierSize / 2}px`,
        left: `${clientX - magnifierSize / 2}px`,
        backgroundImage: `url(${this.$refs.contentImage.src})`,
        backgroundSize: `${this.$refs.contentImage.width * 2}px ${this.$refs.contentImage.height * 2}px`, // 2x magnification
        backgroundPosition: `-${clientX * 2}px -${clientY * 2}px`,
      };

      this.isMagnifierVisible = true;
    },
    hideMagnifier(){
     this.isMagnifierVisible = false;
    }
   }
  }
 }
}
</script>

<style>

</style>
