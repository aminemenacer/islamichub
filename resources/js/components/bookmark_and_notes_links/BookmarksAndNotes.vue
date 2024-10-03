<template>
  <div v-if="isLoggedIn && information !== null">
    <div class="row" style="padding:10px">
      <div class="text-center">
        <hr>
        <!-- Apply the icon color to this section -->
        <div :style="{ color: iconColor }">
          <h3>{{ information.title }}</h3>
          <p>{{ information.content }}</p>
        </div>
        <div class="row">
          <!-- Applying :style="iconStyle" to each icon -->
          <div class="col">
            <a href="/bookmarks" class="h4">
              <i :style="{ color: iconColor }" class="bi bi-bookmark h4"></i>
            </a>
          </div>
          <div class="col">
            <a href="/notes" class="h4">
              <i :style="{ color: iconColor }" class="bi bi-file-earmark-text h4"></i>
            </a>
          </div>
          <div class="col">
            <a href="/collection" class="h4">
              <i :style="{ color: iconColor }" class="bi bi-collection h4"></i>
            </a>
          </div>
          <div class="col">
            <a href="/profile" class="h2">
              <i :style="{ color: iconColor }" class="bi bi-person h2"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BookmarksAndNotes',
  props: {
    information: {
      type: Object,
      default: null,
    },
    iconColor: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      isLoggedIn: false,
    }
  },
  
};
</script>

<style>
</style>
