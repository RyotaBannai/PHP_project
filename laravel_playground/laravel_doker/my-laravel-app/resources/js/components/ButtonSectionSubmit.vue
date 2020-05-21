<template>
    <div class="main">
        <form v-bind:action="action_url" method="post">
            <slot></slot>
            <input type="text" v-bind:value="user_id" readonly disabled>
            <input type="submit"
            class="btn btn-primary"
            @click="executeDupe"
            :disabled="is_disable"
            v-bind:class="{'processing': is_disable}"
            v-model="button_value">
        </form>
    </div>
</template>

<script>
    export default {
        name: 'btn-section',
        data() {
            return {
                id: '',
                is_disable: false,
                button_value: 'Submit',
                action_url: window.location.origin+'/users/'+this.user_id,
            }
        },
        props:['user_id'],
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            executeDupe(event) {
                //this.is_disable = true; // if you make submit button disable it doesn't work.
                this.button_value = "Submitting...";
                console.log('Submitting...');
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
        opacity: .7;
    }
</style>
