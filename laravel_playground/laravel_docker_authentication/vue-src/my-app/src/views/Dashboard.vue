<template>
    <div class="dashboard">
        <h1>Dashboard view</h1>
         <div>Email: {{ email }}</div>
        <button @click="logout">Logout</button>
    </div>
</template>

<script>
    import axios from 'axios'
    axios.defaults.withCredentials = true;
    axios.defaults.baseURL = 'http://localhost:8000';

    export default {
        name: "Dashboard.vue",
        data() {
            return {
                email: '',
            }
        },
        mounted() {
            axios.get('/api/user').then(responce => {
            console.log(responce);
            this.email =responce.data.email;
            })
        },
        methods:{
            logout() {
                axios.post('/logout').then(responce => {
                    this.$router.push({name: "Home"})
                })
            }
        }
    }
</script>

<style scoped>

</style>