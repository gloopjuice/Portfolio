<template>
    <header>
        <div id="navbar">
            <router-link to="/" class="nav-link">Home</router-link>
            <router-link to="/stacks" class="nav-link">Stacks</router-link>
            <router-link to="/projects" class="nav-link">Projects</router-link>
            <router-link to="/discography" class="nav-link">Discography</router-link>
        </div> 
    </header>
</template>

<script>
export default {
    name: 'Header',
};
</script>

<style scoped>
header {
    position: absolute;
    top: 0vh;
    left: 0vh;
    background-color: #333;
    color: white;
    padding: 2vh 0;
    width: 100%;  
    text-align: left;
}

#navbar {
    display: flex; 
    justify-content: space-around; 
    align-items: center;
    width: 50%; 
}
.nav-link {
    color: white;
    font-size: 1.5rem;
    text-decoration: none; 
}
.nav-link:hover {
    color: #ccc;
}
</style>