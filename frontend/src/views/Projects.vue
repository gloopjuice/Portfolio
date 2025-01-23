<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import '../assets/main.css';

const projects = ref([]);
const selectedProject = ref(null); // For storing the clicked project details
const showPopup = ref(false); // For controlling the visibility of the popup

onMounted(async () => {
  try {
    const response = await axios.get('/api/getProjects');
    projects.value = response.data;
  } catch (error) {
    console.error('Error fetching projects:', error);
  }
});

const handleClick = (project) => {
  if (selectedProject.value && selectedProject.value.id === project.id) {
    // If the clicked project is already selected, close the popup
    selectedProject.value = null;
    showPopup.value = false;
  } else {
    // Otherwise, select the clicked project and open the popup
    selectedProject.value = project;
    showPopup.value = true;
  }
};

const closePopup = () => {
  showPopup.value = false;
  selectedProject.value = null;
};
</script>

<template>
  <main class="main-container">
    <h1 style="padding-top: 20vh;">These are some non-music projects I have made</h1>
    <ul class="projects-grid">
      <li v-for="project in projects" :key="project.id" class="project-item" @click="handleClick(project)">
        <div class="project-image-wrapper">
          <img v-if="project.projectpicture" :src="`${axios.defaults.baseURL}storage/${project.projectpicture}`" class="project-image" />
          <div class="overlay">
            <div class="project-text">{{ project.projectname }}<br>Click me!</div>
          </div>
        </div>
      </li>
    </ul>

    <div v-if="showPopup" class="popup" @click.self="closePopup">
      <div class="popup-content">
        <span class="close" @click="closePopup">&times;</span>
        <div class="popup-inner">
          <img v-if="selectedProject.projectpicture" :src="`${axios.defaults.baseURL}storage/${selectedProject.projectpicture}`" class="project-image-large" />
          <div class="popup-text">
            <h2>{{ selectedProject.projectname }}</h2>
            <p>{{ selectedProject.projectdescription }}</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>