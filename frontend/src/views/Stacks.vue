<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import '../assets/main.css';

const stacks = ref([]);
const selectedStack = ref(null); // For storing the clicked stack details
const showPopup = ref(false); // For controlling the visibility of the popup
const contentLoaded = ref(false); // New flag to indicate content is loaded

onMounted(async () => {
  try {
    const response = await axios.get('/api/getStacks');
    stacks.value = response.data;
    contentLoaded.value = true; // Set the flag to true once content is loaded
  } catch (error) {
    console.error('Error fetching stacks:', error);
    contentLoaded.value = true; // Set the flag to true even if there is an error
  }
});

const handleClick = (stack) => {
  if (selectedStack.value && selectedStack.value.id === stack.id) {
    // If the clicked stack is already selected, close the popup
    selectedStack.value = null;
    showPopup.value = false;
  } else {
    // Otherwise, select the clicked stack and open the popup
    selectedStack.value = stack;
    showPopup.value = true;
  }
};

const closePopup = () => {
  showPopup.value = false;
  selectedStack.value = null;
};
</script>

<template>
  <main>
    <h1 
      v-if="contentLoaded" 
      class="mainheader visible"
    >
      These are the stacks that I work with currently, or have worked with:
    </h1>
    <ul class="stacks-grid">
      <li 
        v-for="stack in stacks" 
        :key="stack.id" 
        class="stack-item"
        @click="handleClick(stack)"
      >
        <div class="stack-image-wrapper">
          <img v-if="stack.stackpicture" :src="`${axios.defaults.baseURL}storage/${stack.stackpicture}`" class="stack-image" />
          <div class="overlay">
            <div class="text">{{ stack.stackname }}<br>Click me!</div>
          </div>
        </div>
      </li>
    </ul>

    <div v-if="showPopup" class="popup" @click.self="closePopup">
      <div class="popup-content">
        <span class="close" @click="closePopup">&times;</span>
        <div class="popup-body">
          <img v-if="selectedStack.stackpicture" :src="`${axios.defaults.baseURL}storage/${selectedStack.stackpicture}`" class="stack-image-large" />
          <div class="stack-details">
            <h2>{{ selectedStack.stackname }}</h2>
            <p>{{ selectedStack.stackdescription }}</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style>
.mainheader {
  width: 60vw; /* Set a fixed width */
  height: 20vh; /* Set a fixed height */
  padding-top: 30vh;
  padding-bottom: 20vh;
  text-align: center;
  font-size: 3vw;
  max-width: 80vw; /* Optional: Keep a max width for large screens */
  margin: 0 auto;
  word-wrap: break-word;
  word-break: break-word;
  white-space: normal;
  display: flex;
  justify-content: center;
  align-items: center; /* Center the content vertically */
  opacity: 0; /* Start with opacity 0 */
}

.mainheader.visible {
  animation: fadeInHeader 1s ease-out forwards;
}

main {
  padding-bottom: 20vh;
}

.stacks-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr); /* Always show 4 columns */
  gap: 2vw;
  list-style-type: none;
  padding: 0;
  justify-content: center;
}

.stack-item {
  position: relative;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
}

.stack-image-wrapper {
  position: relative;
  width: 15vw;
  height: 15vw;
  min-width: 15vw;
  min-height: 15vw;
  background-color: #f0f0f0;
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
  animation: fadeInPictures 1s ease-out 1s forwards;
}

.stack-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .5s ease;
  background-color: rgba(0, 0, 0, 0.5);
}

.stack-item:hover .overlay {
  opacity: 1;
}

.text {
  color: white;
  font-size: 1.5vw;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding-top: 15vh;
  animation: fadeIn 0.5s;
  z-index: 9999;
}

.popup-content {
  background: white;
  padding: 2vw;
  border-radius: 8px;
  width: 90%;
  max-width: 60vw;
  max-height: 60vh;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  position: relative;
  animation: slideIn 0.5s;
  overflow-y: auto;
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.popup-content::-webkit-scrollbar {
  display: none;
}

.popup-body {
  display: flex;
  align-items: center;
}

.stack-image-large {
  max-width: 20vw;
  height: auto;
  margin-right: 2vw;
}

.stack-details {
  flex-grow: 1;
  word-wrap: break-word;
  word-break: break-word;
}

.stack-details h2 {
  margin: 0;
  margin-bottom: 1vw;
  font-size: 2vw;
  word-wrap: break-word;
  word-break: break-word;
}

.stack-details p {
  margin: 0;
  font-size: 1.5vw;
  word-wrap: break-word;
  word-break: break-word;
}

.close {
  position: absolute;
  top: 1vw;
  right: 1vw;
  cursor: pointer;
  font-size: 2vw;
}

@media (max-width: 800px) {
  .stacks-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .popup-content {
    width: 100%;
    max-width: 90%;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideIn {
  from {
    transform: translateY(-20%);
  }
  to {
    transform: translateY(0);
  }
}

@keyframes fadeInHeader {
  from {
    opacity: 0;
    transform: translateY(-20%);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInPictures {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>