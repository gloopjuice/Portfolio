<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stackname = ref('');
const stackdescription = ref('');
const stackpicture = ref(null);
const musicProjectName = ref('');
const musicProjectDescription = ref('');
const musicProjectPicture = ref(null);
const projectName = ref('');
const projectDescription = ref('');
const projectPicture = ref(null);
const stacks = ref([]);
const projects = ref([]);
const musicProjects = ref([]);
const isEditing = ref(false);
const editStackId = ref(null);
const editProjectId = ref(null);
const editMusicProjectId = ref(null);
const showModal = ref(false);
const currentFormType = ref('');

onMounted(async () => {
  try {
    const [stackResponse, projectResponse, musicProjectResponse] = await Promise.all([
      axios.get('/api/getStacks'),
      axios.get('/api/getProjects'),
      axios.get('/api/getMusicProjects')
    ]);
    stacks.value = stackResponse.data;
    projects.value = projectResponse.data;
    musicProjects.value = musicProjectResponse.data;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});

const onFileChange = (event, type) => {
  if (type === 'stack') {
    stackpicture.value = event.target.files[0];
  } else if (type === 'project') {
    projectPicture.value = event.target.files[0];
  } else if (type === 'musicProject') {
    musicProjectPicture.value = event.target.files[0];
  }
};

const submitStack = async () => {
  const formData = new FormData();
  formData.append('stackname', stackname.value);
  formData.append('stackdescription', stackdescription.value);
  if (stackpicture.value) {
    formData.append('stackpicture', stackpicture.value);
  }

  try {
    if (isEditing.value && editStackId.value) {
      const response = await axios.post(`/api/editStack/${editStackId.value}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });

      alert('Stack updated successfully!');
      const updatedStack = response.data.stack;
      const index = stacks.value.findIndex((stack) => stack.id === editStackId.value);
      stacks.value[index] = updatedStack;
    } else {
      const response = await axios.post('/api/createStack', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });
      alert('Stack created successfully!');
      stacks.value.push(response.data.stack);
    }

    resetForm();
    showModal.value = false;
  } catch (error) {
    console.error('Error submitting stack:', error);
    alert('Failed to submit stack.');
  }
};

const submitProject = async () => {
  const formData = new FormData();
  formData.append('projectname', projectName.value);
  formData.append('projectdescription', projectDescription.value);
  if (projectPicture.value) {
    formData.append('projectpicture', projectPicture.value);
  }

  try {
    if (isEditing.value && editProjectId.value) {
      const response = await axios.post(`/api/editProject/${editProjectId.value}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });

      alert('Project updated successfully!');
      const updatedProject = response.data.project;
      const index = projects.value.findIndex((project) => project.id === editProjectId.value);
      projects.value[index] = updatedProject;
    } else {
      const response = await axios.post('/api/createProject', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });
      alert('Project created successfully!');
      projects.value.push(response.data.project);
    }

    resetForm();
    showModal.value = false;
  } catch (error) {
    console.error('Error submitting project:', error);
    alert('Failed to submit project.');
  }
};

const submitMusicProject = async () => {
  const formData = new FormData();
  formData.append('musicprojectname', musicProjectName.value);
  formData.append('musicprojectdescription', musicProjectDescription.value);
  if (musicProjectPicture.value) {
    formData.append('musicprojectpicture', musicProjectPicture.value);
  }

  try {
    if (isEditing.value && editMusicProjectId.value) {
      const response = await axios.post(`/api/editMusicProject/${editMusicProjectId.value}`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });

      alert('Music project updated successfully!');
      const updatedMusicProject = response.data.musicProject;
      const index = musicProjects.value.findIndex((musicProject) => musicProject.id === editMusicProjectId.value);
      musicProjects.value[index] = updatedMusicProject;
    } else {
      const response = await axios.post('/api/createMusicProject', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });
      alert('Music project created successfully!');
      musicProjects.value.push(response.data.musicProject);
    }

    resetForm();
    showModal.value = false;
  } catch (error) {
    console.error('Error submitting music project:', error);
    alert('Failed to submit music project.');
  }
};

const deleteStack = async (id) => {
  try {
    await axios.delete(`/api/deleteStack/${id}`);
    alert('Stack deleted successfully!');
    stacks.value = stacks.value.filter((stack) => stack.id !== id);
  } catch (error) {
    console.error('Error deleting stack:', error);
    alert('Failed to delete stack.');
  }
};

const deleteProject = async (id) => {
  try {
    await axios.delete(`/api/deleteProject/${id}`);
    alert('Project deleted successfully!');
    projects.value = projects.value.filter((project) => project.id !== id);
  } catch (error) {
    console.error('Error deleting project:', error);
    alert('Failed to delete project.');
  }
};

const deleteMusicProject = async (id) => {
  try {
    await axios.delete(`/api/deleteMusicProject/${id}`);
    alert('Music project deleted successfully!');
    musicProjects.value = musicProjects.value.filter((musicProject) => musicProject.id !== id);
  } catch (error) {
    console.error('Error deleting music project:', error);
    alert('Failed to delete music project.');
  }
};

const editStack = (stack) => {
  stackname.value = stack.stackname;
  stackdescription.value = stack.stackdescription;
  isEditing.value = true;
  editStackId.value = stack.id;
  currentFormType.value = 'stack';
  showModal.value = true;
};

const editProject = (project) => {
  projectName.value = project.projectname;
  projectDescription.value = project.projectdescription;
  isEditing.value = true;
  editProjectId.value = project.id;
  currentFormType.value = 'project';
  showModal.value = true;
};

const editMusicProject = (musicProject) => {
  musicProjectName.value = musicProject.musicprojectname;
  musicProjectDescription.value = musicProject.musicprojectdescription;
  isEditing.value = true;
  editMusicProjectId.value = musicProject.id;
  currentFormType.value = 'musicProject';
  showModal.value = true;
};

const openModal = (type) => {
  currentFormType.value = type;
  showModal.value = true;
};

const submitForm = () => {
  if (currentFormType.value === 'stack') {
    submitStack();
  } else if (currentFormType.value === 'project') {
    submitProject();
  } else if (currentFormType.value === 'musicProject') {
    submitMusicProject();
  }
};

const resetForm = () => {
  stackname.value = '';
  stackdescription.value = '';
  stackpicture.value = null;
  projectName.value = '';
  projectDescription.value = '';
  projectPicture.value = null;
  musicProjectName.value = '';
  musicProjectDescription.value = '';
  musicProjectPicture.value = null;
  isEditing.value = false;
  editStackId.value = null;
  editProjectId.value = null;
  editMusicProjectId.value = null;
  showModal.value = false;
  currentFormType.value = '';
};
</script>

<template>
  <main>
    <h1 style="padding-top:20vh;"></h1>
    <button @click="openModal('stack')">Create New Stack</button>
    <h2>Stacks</h2>
    <ul>
      <li v-for="stack in stacks" :key="stack.id">
        <h3>{{ stack.stackname }}</h3>
        <p>{{ stack.stackdescription }}</p>
        <img v-if="stack.stackpicture" :src="`${axios.defaults.baseURL}storage/${stack.stackpicture}`" style="max-width: 200px; max-height: 200px;" />
        <button @click="editStack(stack)">Edit</button>
        <button @click="deleteStack(stack.id)">Delete</button>
      </li>
    </ul>

    <h2>Projects</h2>
    <button @click="openModal('project')">Create New Project</button>
    <ul>
      <li v-for="project in projects" :key="project.id">
        <h3>{{ project.projectname }}</h3>
        <p>{{ project.projectdescription }}</p>
        <img v-if="project.projectpicture" :src="`${axios.defaults.baseURL}storage/${project.projectpicture}`" style="max-width: 200px; max-height: 200px;" />
        <button @click="editProject(project)">Edit</button>
        <button @click="deleteProject(project.id)">Delete</button>
      </li>
    </ul>

    <h2>Music Projects</h2>
    <button @click="openModal('musicProject')">Create New Music Project</button>
    <ul>
      <li v-for="musicProject in musicProjects" :key="musicProject.id">
        <h3>{{ musicProject.musicprojectname }}</h3>
        <p>{{ musicProject.musicprojectdescription }}</p>
        <img v-if="musicProject.musicprojectpicture" :src="`${axios.defaults.baseURL}storage/${musicProject.musicprojectpicture}`" style="max-width: 200px; max-height: 200px;" />
        <button @click="editMusicProject(musicProject)">Edit</button>
        <button @click="deleteMusicProject(musicProject.id)">Delete</button>
      </li>
    </ul>

    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="resetForm">&times;</span>
        <h2>{{ isEditing ? 'Edit' : 'Create' }} {{ currentFormType === 'stack' ? 'Stack' : currentFormType === 'project' ? 'Project' : 'Music Project' }}</h2>
        <form @submit.prevent="submitForm">
          <div v-if="currentFormType === 'stack'">
            <label>Stack Name:</label>
            <input v-model="stackname" type="text" required /><br/>
            <label>Stack Description:</label>
            <textarea v-model="stackdescription" required></textarea><br/>
            <label>Stack Picture:</label>
            <input type="file" @change="(e) => onFileChange(e, 'stack')" />
          </div>
          <div v-if="currentFormType === 'project'">
            <label>Project Name:</label>
            <input v-model="projectName" type="text" required /><br/>
            <label>Project Description:</label>
            <textarea v-model="projectDescription" required></textarea><br/>
            <label>Project Picture:</label>
            <input type="file" @change="(e) => onFileChange(e, 'project')" />
          </div>
          <div v-if="currentFormType === 'musicProject'">
            <label>Music Project Name:</label>
            <input v-model="musicProjectName" type="text" required /><br/>
            <label>Music Project Description:</label>
            <textarea v-model="musicProjectDescription" required></textarea><br/>
            <label>Music Project Picture:</label>
            <input type="file" @change="(e) => onFileChange(e, 'musicProject')" />
          </div>
          <button type="submit">{{ isEditing ? 'Update' : 'Submit' }}</button>
        </form>
      </div>
    </div>
  </main>
</template>

<style>
.modal {
  display: flex;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  position: relative;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 20px;
}
</style>