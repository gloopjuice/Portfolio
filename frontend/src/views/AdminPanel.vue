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
const showPasswordModal = ref(true);
const password = ref('');

const correctPassword = '123';

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

const checkPassword = () => {
  if (password.value === correctPassword) {
    showPasswordModal.value = false;
  } else {
    alert('Incorrect password');
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
  <main v-if="!showPasswordModal">
    <h1 style="padding-top:20vh;"></h1>
    
    <h2>Stacks</h2>
    <button @click="openModal('stack')">Create New Stack</button>
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

  <div v-else class="modal">
    <div class="modal-content">
      <h2>Enter Password</h2>
      <input v-model="password" type="password" placeholder="Password" />
      <button @click="checkPassword">Submit</button>
    </div>
  </div>
</template>
<style>
/* General Styling */
body {
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
  margin: 0;
  padding: 0;
  color: #343a40;
}

main {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

/* Headings */
h1, h2 {
  color: #212529;
  margin-bottom: 20px;
  text-align: center;
}

/* Posts List */
ul {
  list-style: none;
  padding: 0;
}

li {
  background: #fff;
  margin: 20px 0;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

li:hover {
  transform: translateY(-5px);
  box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.15);
}

li h3 {
  margin: 0;
  color: #495057;
}

li p {
  color: #6c757d;
  margin: 10px 0;
}

li img {
  margin: 10px 0;
  border-radius: 8px;
  border: 1px solid #dee2e6;
}

/* Buttons */
button {
  display: inline-block;
  background: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  margin-right: 5px;
  transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
}

button:hover {
  background: #0056b3;
  transform: scale(1.05);
}

button:active {
  background: #004085;
  transform: scale(1);
}

button:last-child {
  background: #dc3545;
}

button:last-child:hover {
  background: #c82333;
}

/* Modal Styling */
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
  z-index: 9999;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  position: relative;
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 20px;
  color: #6c757d;
}

.close:hover {
  color: #495057;
}

/* Input Fields */
input, textarea {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 14px;
}

input[type="file"] {
  padding: 5px;
}

input:focus, textarea:focus {
  border-color: #80bdff;
  outline: none;
  box-shadow: 0 0 3px rgba(0, 123, 255, 0.25);
}

/* Submit Button */
button[type="submit"] {
  background-color: #28a745;
}

button[type="submit"]:hover {
  background-color: #218838;
}
</style>
