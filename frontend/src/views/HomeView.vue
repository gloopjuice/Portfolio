<template>
  <div id="app">
    <h1 class="animated-title">My name is Girts, and this is my portfolio! I still do not know how to make a good looking frontend!</h1>
    <h3 v-html="animatedText" class="animated-subtitle" style="padding-top: 50vh;"></h3>
  </div>
</template>

<script>
export default {
  data() {
    return {
      animatedText: "Check out some of the things I have made!"
    };
  },
  mounted() {
    this.animateTitles();
  },
  methods: {
    animateTitles() {
      const title = document.querySelector('.animated-title');
      const subtitle = document.querySelector('.animated-subtitle');
      
      title.classList.add('fade-in');
      setTimeout(() => {
        subtitle.classList.add('fade-in');
      }, 1000); // delay for the subtitle
    }
  }
}
</script>

<style scoped>
#app {
  position: relative;
  width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  text-align: center;
}

.animated-title, .animated-subtitle {
  position: absolute;
  opacity: 0;
}

.fade-in {
  animation: fadeIn 2s forwards;
}

@keyframes fadeIn {
  0% { opacity: 0; }
  100% { opacity: 1; }
}
</style>