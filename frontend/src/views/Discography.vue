<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import '../assets/main.css';

const musicProjects = ref([]);
const selectedMusicProject = ref(null);
const showPopup = ref(false); 

onMounted(async () => {
  try {
    const response = await axios.get('/api/getMusicProjects');
    musicProjects.value = response.data;
  } catch (error) {
    console.error('Error fetching music projects:', error);
  }
});

const handleClick = (project) => {
  if (selectedMusicProject.value && selectedMusicProject.value.id === project.id) {
    selectedMusicProject.value = null;
    showPopup.value = false;
  } else {
    selectedMusicProject.value = project;
    showPopup.value = true;
  }
};

const closePopup = () => {
  showPopup.value = false;
  selectedMusicProject.value = null;
};
</script>

<template>
  <main class="main-container">
    <h1 class="mainheader visible">These are the musical projects I have worked on:</h1>
    <ul class="music-projects-grid">
      <li v-for="project in musicProjects" :key="project.id" class="music-project-item" @click="handleClick(project)">
        <div class="music-project-image-wrapper">
          <img v-if="project.musicprojectpicture" :src="`${axios.defaults.baseURL}storage/${project.musicprojectpicture}`" class="music-project-image" />
          <div class="overlay">
            <div class="music-project-text">{{ project.musicprojectname }}<br>Click me!</div>
          </div>
        </div>
      </li>
    </ul>

    <div v-if="showPopup" class="popup" @click.self="closePopup">
      <div class="popup-content">
        <span class="close" @click="closePopup">&times;</span>
        <div class="popup-inner">
          <img v-if="selectedMusicProject.musicprojectpicture" :src="`${axios.defaults.baseURL}storage/${selectedMusicProject.musicprojectpicture}`" class="music-project-image-large" />
          <div class="popup-text">
            <h2>{{ selectedMusicProject.musicprojectname }}</h2>
            <p>{{ selectedMusicProject.musicprojectdescription }}</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>