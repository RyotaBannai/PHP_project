<template>
    <div class="main">
        {{ user_id }}
        <button
            type="button"
            class="btn btn-primary"
            @click="unlock"
            :disabled="is_disable"
            v-bind:class="{'processing': is_disable}"
        >Primary</button>
    </div>
</template>

<script>
    import axios from "axios"

    export default {
        name: 'btn-section',
        data() {
            return {
                id: '',
                is_disable: false,

            }
        },
        props:['user_id'],
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            unlock() {
                this.is_disable = true;
                const id = this.user_id;
                axios.post('http://localhost:8000/api/unlock', {
                    id,
                })
                    .then(res => {
                        console.log(res);
                        window.location.href = `http://localhost:8000/users/${id}`;
                    })
                    .catch(err => console.log(err));
            }
        }
    }

</script>
<style scoped>
    .main{
        padding: 10px;
    }
    .processing{
        cursor: wait;
    }
</style>
